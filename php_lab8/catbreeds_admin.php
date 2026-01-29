<?php
require_once __DIR__ . '/db_connect.php';

$uploadDir = __DIR__ . '/uploads/';
$errors = [];
$success = '';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function short_text($text, $limit = 120) {
    $text = (string)$text;
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $limit, '...');
    }
    if (strlen($text) > $limit) {
        return substr($text, 0, max(0, $limit - 3)) . '...';
    }
    return $text;
}

function detect_image_mime($tmpPath) {
    if (function_exists('mime_content_type')) {
        return mime_content_type($tmpPath);
    }
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = finfo_file($finfo, $tmpPath);
            finfo_close($finfo);
            return $mime;
        }
    }
    return null;
}

function upload_error_message($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            $max = ini_get('upload_max_filesize');
            return 'ไฟล์ใหญ่เกินค่าที่ตั้งใน upload_max_filesize (' . $max . ')';
        case UPLOAD_ERR_FORM_SIZE:
            return 'ไฟล์ใหญ่เกินค่าที่กำหนดในฟอร์ม';
        case UPLOAD_ERR_PARTIAL:
            return 'อัปโหลดไฟล์ไม่ครบถ้วน';
        case UPLOAD_ERR_NO_FILE:
            return 'ไม่พบไฟล์ที่อัปโหลด';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'ไม่พบโฟลเดอร์ชั่วคราวบนเซิร์ฟเวอร์ (upload_tmp_dir)';
        case UPLOAD_ERR_CANT_WRITE:
            return 'ไม่สามารถเขียนไฟล์ลงดิสก์ได้ กรุณาตรวจสอบพื้นที่และสิทธิ์';
        case UPLOAD_ERR_EXTENSION:
            return 'อัปโหลดถูกหยุดโดยส่วนขยายของ PHP';
        default:
            return 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'add') {
        $name_th = trim(isset($_POST['name_th']) ? $_POST['name_th'] : '');
        $name_en = trim(isset($_POST['name_en']) ? $_POST['name_en'] : '');
        $description = trim(isset($_POST['description']) ? $_POST['description'] : '');
        $characteristics = trim(isset($_POST['characteristics']) ? $_POST['characteristics'] : '');
        $care_instructions = trim(isset($_POST['care_instructions']) ? $_POST['care_instructions'] : '');
        $is_visible = isset($_POST['is_visible']) ? 1 : 0;
        $image_url = null;

        if ($name_th === '' || $name_en === '' || $description === '') {
            $errors[] = 'กรุณากรอกข้อมูล ชื่อไทย ชื่ออังกฤษ และคำอธิบายให้ครบถ้วน';
        }

        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = upload_error_message($file['error']);
            } else {
                $maxSize = 5 * 1024 * 1024;
                if ($file['size'] > $maxSize) {
                    $errors[] = 'ไฟล์รูปภาพต้องมีขนาดไม่เกิน 5MB';
                } elseif (!is_uploaded_file($file['tmp_name'])) {
                    $errors[] = 'ไฟล์อัปโหลดไม่ถูกต้องหรือถูกบล็อกโดยเซิร์ฟเวอร์';
                } else {
                    $mime = detect_image_mime($file['tmp_name']);
                    $allowed = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/gif' => 'gif',
                        'image/webp' => 'webp'
                    ];
                    $extension = null;

                    if ($mime !== null && isset($allowed[$mime])) {
                        $extension = $allowed[$mime];
                    } else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        if ($ext === 'jpeg') {
                            $ext = 'jpg';
                        }
                        $extAllowed = ['jpg', 'png', 'gif', 'webp'];
                        if (in_array($ext, $extAllowed, true)) {
                            $extension = $ext;
                        }
                    }

                    if ($extension === null) {
                        $errors[] = 'ชนิดไฟล์รูปภาพไม่ถูกต้อง (รองรับ JPG, PNG, GIF, WEBP)';
                    } else {
                        $filename = 'cat_' . uniqid('', true) . '.' . $extension;
                        $targetPath = $uploadDir . $filename;
                        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                            $image_url = 'uploads/' . $filename;
                        } else {
                            $errors[] = 'บันทึกรูปภาพไม่สำเร็จ';
                        }
                    }
                }
            }
        }

        if (!$errors) {
            $stmt = mysqli_prepare($conn, "INSERT INTO CatBreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssssssi', $name_th, $name_en, $description, $characteristics, $care_instructions, $image_url, $is_visible);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header('Location: catbreeds_admin.php?status=added');
                exit;
            }
            $errors[] = 'บันทึกข้อมูลไม่สำเร็จ: ' . mysqli_error($conn);
            mysqli_stmt_close($stmt);
        }
    }

    if ($action === 'delete') {
        $delete_id = (int)(isset($_POST['delete_id']) ? $_POST['delete_id'] : 0);
        if ($delete_id > 0) {
            $imageUrl = null;
            $stmt = mysqli_prepare($conn, 'SELECT image_url FROM CatBreeds WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'i', $delete_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $imageUrl);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($conn, 'DELETE FROM CatBreeds WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'i', $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                if (!empty($imageUrl)) {
                    $imagePath = __DIR__ . '/' . $imageUrl;
                    if (is_file($imagePath)) {
                        unlink($imagePath);
                    }
                }
                header('Location: catbreeds_admin.php?status=deleted');
                exit;
            }
            $errors[] = 'ลบข้อมูลไม่สำเร็จ: ' . mysqli_error($conn);
            mysqli_stmt_close($stmt);
        }
    }
}

$status = isset($_GET['status']) ? $_GET['status'] : '';
if ($status === 'added') {
    $success = 'เพิ่มข้อมูลสายพันธุ์สำเร็จแล้ว';
} elseif ($status === 'deleted') {
    $success = 'ลบข้อมูลสายพันธุ์สำเร็จแล้ว';
}

$breeds = [];
$result = mysqli_query($conn, 'SELECT id, name_th, name_en, description, image_url, is_visible FROM CatBreeds ORDER BY id DESC');
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $breeds[] = $row;
    }
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการสายพันธุ์แมว</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --slate: #1f2937;
            --accent: #f59e0b;
            --mint: #d1fae5;
        }
        body {
            font-family: "Kanit", "Prompt", "Sarabun", "Segoe UI", sans-serif;
            background: linear-gradient(160deg, #f7f2ea 0%, #f1f7f4 100%);
            color: var(--slate);
        }
        .page-header {
            background: #fff;
            border-bottom: 1px solid #f2e5d4;
        }
        .page-header h1 {
            font-weight: 700;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        }
        .form-section {
            border-left: 4px solid var(--accent);
        }
        .table thead th {
            background: #fff4dd;
        }
        .badge-visibility {
            background: var(--mint);
            color: #0f5132;
            font-weight: 600;
        }
        .thumbnail {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 12px;
        }
        .thumbnail-placeholder {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: #f6e5c6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9a6b1a;
        }
    </style>
</head>
<body>
    <header class="page-header py-4 mb-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <div class="text-uppercase text-muted" style="font-size: 0.85rem; letter-spacing: 0.1rem;">Back Office</div>
                    <h1 class="h3 mb-0">จัดการสายพันธุ์แมว</h1>
                </div>
                <a class="btn btn-outline-dark" href="catbreeds.php"><i class="bi bi-box-arrow-up-right"></i> เปิดหน้าบ้าน</a>
            </div>
        </div>
    </header>

    <main class="container pb-5">
        <?php if ($success) : ?>
            <div class="alert alert-success d-flex align-items-center gap-2">
                <i class="bi bi-check-circle"></i>
                <?php echo e($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($errors) : ?>
            <div class="alert alert-danger">
                <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle"></i> พบปัญหา</div>
                <ul class="mb-0">
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card form-section p-4">
                    <h2 class="h5 mb-3"><i class="bi bi-plus-circle"></i> เพิ่มสายพันธุ์ใหม่</h2>
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label class="form-label">ชื่อสายพันธุ์ (ไทย) *</label>
                            <input type="text" class="form-control" name="name_th" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ชื่อสายพันธุ์ (อังกฤษ) *</label>
                            <input type="text" class="form-control" name="name_en" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">คำอธิบาย *</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ลักษณะเด่น</label>
                            <textarea class="form-control" name="characteristics" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">การดูแล</label>
                            <textarea class="form-control" name="care_instructions" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รูปภาพ</label>
                            <input type="file" class="form-control" name="image" accept="image/*">
                            <div class="form-text">รองรับ JPG, PNG, GIF, WEBP ขนาดไม่เกิน 5MB</div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible" checked>
                            <label class="form-check-label" for="is_visible">แสดงบนหน้าบ้าน</label>
                        </div>
                        <button type="submit" class="btn btn-warning text-dark w-100">
                            <i class="bi bi-save"></i> บันทึกข้อมูล
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h5 mb-0"><i class="bi bi-list-ul"></i> รายการสายพันธุ์</h2>
                        <span class="text-muted">ทั้งหมด <?php echo count($breeds); ?> รายการ</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>รูป</th>
                                    <th>ชื่อสายพันธุ์</th>
                                    <th>คำอธิบาย</th>
                                    <th>สถานะ</th>
                                    <th class="text-end">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$breeds) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">ยังไม่มีข้อมูล</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($breeds as $breed) : ?>
                                        <?php
                                        $imageUrl = isset($breed['image_url']) ? $breed['image_url'] : '';
                                        $imagePath = $imageUrl ? __DIR__ . '/' . $imageUrl : '';
                                        $hasImage = $imageUrl && is_file($imagePath);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php if ($hasImage) : ?>
                                                    <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($breed['name_th']); ?>" class="thumbnail">
                                                <?php else : ?>
                                                    <div class="thumbnail-placeholder"><i class="bi bi-image"></i></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="fw-semibold"><?php echo e($breed['name_th']); ?></div>
                                                <div class="text-muted small"><?php echo e($breed['name_en']); ?></div>
                                            </td>
                                            <td class="text-muted" style="max-width: 220px;">
                                                <?php echo e(short_text($breed['description'], 120)); ?>
                                            </td>
                                            <td>
                                                <?php if ((int)$breed['is_visible'] === 1) : ?>
                                                    <span class="badge badge-visibility">เผยแพร่</span>
                                                <?php else : ?>
                                                    <span class="badge text-bg-secondary">ซ่อน</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <form method="post" onsubmit="return confirm('ต้องการลบรายการนี้หรือไม่');" class="d-inline">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="delete_id" value="<?php echo (int)$breed['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i> ลบ
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
