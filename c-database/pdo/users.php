<?php
require_once "db_connect.php";

/* =====================
   ADD USER
===================== */
if (isset($_POST['add'])) {
    $sql = "INSERT INTO users (name, sex, phone, email, birthday)
            VALUES (:name, :sex, :phone, :email, :birthday)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':sex' => $_POST['sex'],
        ':phone' => $_POST['phone'],
        ':email' => $_POST['email'],
        ':birthday' => $_POST['birthday']
    ]);
    header("Location: users.php");
    exit;
}

/* =====================
   DELETE USER
===================== */
if (isset($_GET['delete'])) {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $_GET['delete']]);
    header("Location: users.php");
    exit;
}

/* =====================
   GET DATA FOR EDIT
===================== */
$editData = null;
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $_GET['edit']]);
    $editData = $stmt->fetch();
}

/* =====================
   UPDATE USER
===================== */
if (isset($_POST['update'])) {
    $sql = "UPDATE users SET
            name = :name,
            sex = :sex,
            phone = :phone,
            email = :email,
            birthday = :birthday
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name'],
        ':sex' => $_POST['sex'],
        ':phone' => $_POST['phone'],
        ':email' => $_POST['email'],
        ':birthday' => $_POST['birthday'],
        ':id' => $_POST['id']
    ]);
    header("Location: users.php");
    exit;
}

/* =====================
   SHOW USERS
===================== */
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Users CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">
        <h3 class="mb-3">จัดการข้อมูลผู้ใช้</h3>

        <!-- FORM ADD / EDIT -->
        <div class="card mb-4">
            <div class="card-header">
                <?= $editData ? "แก้ไขข้อมูล" : "เพิ่มข้อมูล" ?>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>ชื่อ</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= $editData['name'] ?? '' ?>">
                        </div>

                        <div class="col-md-2">
                            <label>เพศ</label>
                            <select name="sex" class="form-select" required>
                                <option value="">--เลือก--</option>
                                <option value="M" <?= ($editData['sex'] ?? '') == 'M' ? 'selected' : '' ?>>ชาย</option>
                                <option value="F" <?= ($editData['sex'] ?? '') == 'F' ? 'selected' : '' ?>>หญิง</option>
                                <option value="O" <?= ($editData['sex'] ?? '') == 'O' ? 'selected' : '' ?>>อื่นๆ</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>เบอร์โทร</label>
                            <input type="text" name="phone" class="form-control"
                                value="<?= $editData['phone'] ?? '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= $editData['email'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>วันเกิด</label>
                            <input type="date" name="birthday" class="form-control"
                                value="<?= $editData['birthday'] ?? '' ?>">
                        </div>
                    </div>

                    <button type="submit"
                        name="<?= $editData ? 'update' : 'add' ?>"
                        class="btn btn-<?= $editData ? 'warning' : 'success' ?>">
                        <?= $editData ? 'อัปเดต' : 'บันทึก' ?>
                    </button>

                    <?php if ($editData): ?>
                        <a href="users.php" class="btn btn-secondary">ยกเลิก</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- TABLE -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>ชื่อ</th>
                    <th>เพศ</th>
                    <th>โทรศัพท์</th>
                    <th>Email</th>
                    <th>วันเกิด</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $row): ?>
                    <tr>
                        <td class="text-center"><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td class="text-center">
                            <?= $row['sex'] === 'M' ? 'ชาย' : ($row['sex'] === 'F' ? 'หญิง' : 'อื่นๆ') ?>
                        </td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td class="text-center"><?= $row['birthday'] ?></td>
                        <td class="text-center">
                            <a href="users.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button
                                class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="<?= $row['id'] ?>"
                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                data-sex="<?= $row['sex'] ?>"
                                data-phone="<?= htmlspecialchars($row['phone']) ?>"
                                data-email="<?= htmlspecialchars($row['email']) ?>"
                                data-birthday="<?= $row['birthday'] ?>">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <!-- DELETE CONFIRM MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-danger fw-bold">คุณต้องการลบข้อมูลผู้ใช้รายนี้หรือไม่?</p>

                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td id="d-id"></td>
                        </tr>
                        <tr>
                            <th>ชื่อ</th>
                            <td id="d-name"></td>
                        </tr>
                        <tr>
                            <th>เพศ</th>
                            <td id="d-sex"></td>
                        </tr>
                        <tr>
                            <th>โทรศัพท์</th>
                            <td id="d-phone"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="d-email"></td>
                        </tr>
                        <tr>
                            <th>วันเกิด</th>
                            <td id="d-birthday"></td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                        ยืนยันลบ
                    </a>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const sex = button.getAttribute('data-sex') === 'M' ? 'ชาย' :
                button.getAttribute('data-sex') === 'F' ? 'หญิง' :
                'อื่นๆ';
            const phone = button.getAttribute('data-phone');
            const email = button.getAttribute('data-email');
            const birthday = button.getAttribute('data-birthday');

            document.getElementById('d-id').textContent = id;
            document.getElementById('d-name').textContent = name;
            document.getElementById('d-sex').textContent = sex;
            document.getElementById('d-phone').textContent = phone;
            document.getElementById('d-email').textContent = email;
            document.getElementById('d-birthday').textContent = birthday;

            document.getElementById('confirmDeleteBtn').href =
                "users.php?delete=" + id;
        });
    </script>

</body>

</html>