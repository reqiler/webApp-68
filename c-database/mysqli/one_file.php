<?php
include 'db_connect.php';

/* ---------------- DELETE ---------------- */
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = (int)$_GET['id'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: one_file.php");
    exit;
}

/* ---------------- INIT FORM ---------------- */
$id = $name = $sex = $phone = $email = $birthday = "";

if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $row = $result->fetch_assoc();

    $name = $row['name'];
    $phone = $row['phone'];
    $email = $row['email'];
    $birthday = $row['birthday'];

    if ($row['sex'] == 'M') $sex = 'male';
    elseif ($row['sex'] == 'F') $sex = 'female';
    else $sex = 'other';
}

/* ---------------- SAVE ---------------- */
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    $sex_db = ($sex == 'male') ? 'M' : (($sex == 'female') ? 'F' : 'O');

    if ($id == "") {
        $conn->query("INSERT INTO users (name, sex, phone, email, birthday)
                      VALUES ('$name','$sex_db','$phone','$email','$birthday')");
    } else {
        $conn->query("UPDATE users SET
            name='$name',
            sex='$sex_db',
            phone='$phone',
            email='$email',
            birthday='$birthday'
            WHERE id=$id");
    }
    header("Location: one_file.php");
    exit;
}

/* ---------------- LIST ---------------- */
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) { ?>

        <h3><?= $id ? "แก้ไขข้อมูล" : "เพิ่มข้อมูล"; ?></h3>

        <form method="post">
            <input type="hidden" name="id" value="<?= $id; ?>">

            <div class="mb-3">
                <label>ชื่อ</label>
                <input type="text" name="name" class="form-control" required value="<?= $name; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label d-block">เพศ</label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        type="radio"
                        name="sex"
                        id="sex_male"
                        value="male"
                        <?= $sex == 'male' ? 'checked' : ''; ?>
                        required>
                    <label class="form-check-label" for="sex_male">ชาย</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        type="radio"
                        name="sex"
                        id="sex_female"
                        value="female"
                        <?= $sex == 'female' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="sex_female">หญิง</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                        type="radio"
                        name="sex"
                        id="sex_other"
                        value="other"
                        <?= $sex == 'other' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="sex_other">อื่นๆ</label>
                </div>
            </div>

            <div class="mb-3">
                <label>โทรศัพท์</label>
                <input type="text" name="phone" class="form-control" value="<?= $phone; ?>">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $email; ?>">
            </div>

            <div class="mb-3">
                <label>วันเกิด</label>
                <input type="date" name="birthday" class="form-control" value="<?= $birthday; ?>">
            </div>

            <button type="submit" name="save" class="btn btn-primary">บันทึก</button>
            <a href="one_file.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
        <br>
    <?php } ?>

    <h3>รายชื่อผู้ใช้</h3>
    <a href="one_file.php?action=add" class="btn btn-success mb-3">เพิ่มข้อมูล</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>ชื่อ</th>
            <th>เพศ</th>
            <th>โทรศัพท์</th>
            <th>Email</th>
            <th>วันเกิด</th>
            <th>จัดการ</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['sex'] == 'M' ? 'ชาย' : ($row['sex'] == 'F' ? 'หญิง' : 'อื่นๆ'); ?></td>
                <td><?= $row['phone']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['birthday']; ?></td>
                <td>
                    <a href="one_file.php?action=edit&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                    <button class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-id="<?= $row['id']; ?>"
                        data-name="<?= $row['name']; ?>"
                        data-sex="<?= $row['sex']; ?>"
                        data-phone="<?= $row['phone']; ?>"
                        data-email="<?= $row['email']; ?>"
                        data-birthday="<?= $row['birthday']; ?>">
                        ลบ
                    </button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Delete Confirm Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">ยืนยันการลบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-danger fw-bold">คุณต้องการลบผู้ใช้รายนี้ใช่หรือไม่?</p>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>ID:</strong> <span id="d_id"></span>
                        </li>
                        <li class="list-group-item">
                            <strong>ชื่อ:</strong> <span id="d_name"></span>
                        </li>
                        <li class="list-group-item">
                            <strong>เพศ:</strong> <span id="d_sex"></span>
                        </li>
                        <li class="list-group-item">
                            <strong>โทรศัพท์:</strong> <span id="d_phone"></span>
                        </li>
                        <li class="list-group-item">
                            <strong>Email:</strong> <span id="d_email"></span>
                        </li>
                        <li class="list-group-item">
                            <strong>วันเกิด:</strong> <span id="d_birthday"></span>
                        </li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                        ลบข้อมูล
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;

            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const sex = btn.dataset.sex;
            const phone = btn.dataset.phone;
            const email = btn.dataset.email;
            const birthday = btn.dataset.birthday;

            document.getElementById('d_id').textContent = id;
            document.getElementById('d_name').textContent = name;
            document.getElementById('d_sex').textContent =
                sex === 'M' ? 'ชาย' : (sex === 'F' ? 'หญิง' : 'อื่นๆ');
            document.getElementById('d_phone').textContent = phone;
            document.getElementById('d_email').textContent = email;
            document.getElementById('d_birthday').textContent = birthday;

            document.getElementById('confirmDeleteBtn').href =
                'one_file.php?action=delete&id=' + id;
        });
    </script>


</body>

</html>