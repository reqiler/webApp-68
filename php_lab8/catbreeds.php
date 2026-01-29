<?php
require_once __DIR__ . '/db_connect.php';

$breeds = [];
$sql = "SELECT id, name_th, name_en, description, characteristics, care_instructions, image_url FROM CatBreeds WHERE is_visible = 1 ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $breeds[] = $row;
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function format_text($value) {
    $safe = e($value);
    return nl2br($safe);
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>สายพันธุ์แมวยอดนิยม</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ink: #1f2937;
            --muted: #6b7280;
            --sand: #f8f5f0;
            --caramel: #f0c27b;
            --forest: #1f6f54;
        }
        body {
            font-family: "Kanit", "Prompt", "Sarabun", "Segoe UI", sans-serif;
            color: var(--ink);
            background: radial-gradient(circle at top, #fff7e6 0%, #f9efe0 35%, #f2efe9 100%);
        }
        .hero {
            padding: 4rem 1.5rem 3rem;
            background: linear-gradient(120deg, #fff3db 0%, #f2e9dc 55%, #e7f2eb 100%);
            border-bottom: 1px solid #f3e1c2;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            background: #fff;
            border: 1px solid #f0d4a6;
            font-weight: 600;
            color: #a7661a;
            box-shadow: 0 8px 20px rgba(166, 102, 25, 0.08);
        }
        .hero h1 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 700;
        }
        .hero p {
            max-width: 680px;
            color: var(--muted);
            font-size: 1.05rem;
        }
        .card {
            border: none;
            border-radius: 1.2rem;
            box-shadow: 0 18px 40px rgba(17, 24, 39, 0.08);
        }
        .card-img-top {
            border-top-left-radius: 1.2rem;
            border-top-right-radius: 1.2rem;
            height: 220px;
            object-fit: cover;
        }
        .placeholder-image {
            height: 220px;
            border-top-left-radius: 1.2rem;
            border-top-right-radius: 1.2rem;
            background: linear-gradient(135deg, #fde3b2 0%, #f4d2a0 50%, #d8f0e5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #92653a;
            font-size: 2.2rem;
        }
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            background: rgba(31, 111, 84, 0.1);
            color: var(--forest);
            font-size: 0.85rem;
            font-weight: 600;
        }
        .detail-block {
            background: #f8fafc;
            border-radius: 0.85rem;
            padding: 0.9rem 1rem;
            font-size: 0.92rem;
            color: #374151;
        }
        .footer-note {
            color: #7c6f64;
        }
    </style>
</head>
<body>
    <header class="hero">
        <div class="container">
            <span class="hero-badge"><i class="bi bi-stars"></i> คัดเลือกสายพันธุ์ยอดนิยม</span>
            <div class="row align-items-center mt-3">
                <div class="col-lg-8">
                    <h1 class="mb-3">สายพันธุ์แมวยอดนิยม</h1>
                    <p class="mb-0">
                        รวมข้อมูลสายพันธุ์แมวยอดนิยม ทั้งชื่อไทย ชื่ออังกฤษ และแนวทางดูแลเบื้องต้น เพื่อให้เลือกคู่หูได้ตรงใจที่สุด
                    </p>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="p-4 rounded-4 bg-white shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-2 text-uppercase text-muted" style="font-size: 0.85rem; letter-spacing: 0.08rem;">
                            <i class="bi bi-heart-pulse"></i> ไฮไลต์วันนี้
                        </div>
                        <h5 class="mb-2">ดูแลด้วยความเข้าใจ</h5>
                        <p class="mb-0 text-muted">ให้ความสำคัญกับบุคลิก อาหาร และการดูแลขน เพื่อสุขภาพที่แข็งแรง</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">รายการสายพันธุ์</h2>
                <span class="tag"><i class="bi bi-collection"></i> แสดงเฉพาะรายการที่เผยแพร่</span>
            </div>

            <?php if (count($breeds) === 0) : ?>
                <div class="alert alert-warning">ยังไม่มีข้อมูลสายพันธุ์ที่เผยแพร่</div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($breeds as $breed) : ?>
                        <?php
                        $imageUrl = isset($breed['image_url']) ? $breed['image_url'] : '';
                        $imagePath = $imageUrl ? __DIR__ . '/' . $imageUrl : '';
                        $hasImage = $imageUrl && is_file($imagePath);
                        ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card h-100">
                                <?php if ($hasImage) : ?>
                                    <img src="<?php echo e($imageUrl); ?>" class="card-img-top" alt="<?php echo e($breed['name_th']); ?>">
                                <?php else : ?>
                                    <div class="placeholder-image">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h3 class="h5 mb-0"><?php echo e($breed['name_th']); ?></h3>
                                        <span class="text-muted small"><?php echo e($breed['name_en']); ?></span>
                                    </div>
                                    <p class="mt-3 text-muted">
                                        <?php echo format_text($breed['description']); ?>
                                    </p>

                                    <?php if (!empty($breed['characteristics'])) : ?>
                                        <div class="detail-block mb-3">
                                            <div class="fw-semibold mb-1"><i class="bi bi-list-stars me-1"></i> ลักษณะเด่น</div>
                                            <?php echo format_text($breed['characteristics']); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($breed['care_instructions'])) : ?>
                                        <div class="detail-block">
                                            <div class="fw-semibold mb-1"><i class="bi bi-shield-check me-1"></i> การดูแล</div>
                                            <?php echo format_text($breed['care_instructions']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="py-4 border-top">
        <div class="container d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <span class="footer-note">CatBreeds Showcase</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
