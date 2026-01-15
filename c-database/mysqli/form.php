<?php
include 'db_connect.php';

$id = $name = $sex = $phone = $email = $birthday = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $row = $result->fetch_assoc();

    $name = $row['name'];

    if ($row['sex'] == 'M') {
        $sex = 'male';
    } elseif ($row['sex'] == 'F') {
        $sex = 'female';
    } else {
        $sex = 'other';
    }

    $phone = $row['phone'];
    $email = $row['email'];
    $birthday = $row['birthday'];
}

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if ($sex == 'male') {
        $sex_db = 'M';
    } elseif ($sex == 'female') {
        $sex_db = 'F';
    } else {
        $sex_db = 'O';
    }

    if ($_POST['id'] == "") {
        $conn->query("INSERT INTO users (name, sex, phone, email, birthday)
                      VALUES ('$name','$sex_db','$phone','$email','$birthday')");
    } else {
        $id = $_POST['id'];
        $conn->query("UPDATE users SET
            name='$name',
            sex='$sex_db',
            phone='$phone',
            email='$email',
            birthday='$birthday'
            WHERE id=$id");
    }
    header("Location: users.php");
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ฟอร์มผู้ใช้</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <h3><?= $id ? "แก้ไขข้อมูล" : "เพิ่มข้อมูล"; ?></h3>

    <form method="post">
        <input type="hidden" name="id" value="<?= $id; ?>">

        <div class="mb-3">
            <label>ชื่อ</label>
            <input type="text" name="name" class="form-control" required value="<?= $name; ?>">
        </div>

        <div class="mb-3">
            <label>เพศ</label>
            <select name="sex" class="form-control" required>
                <option value="">-- เลือก --</option>
                <option value="male" <?= $sex == 'male' ? 'selected' : ''; ?>>ชาย</option>
                <option value="female" <?= $sex == 'female' ? 'selected' : ''; ?>>หญิง</option>
                <option value="other" <?= $sex == 'other' ? 'selected' : ''; ?>>อื่นๆ</option>
            </select>
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
        <a href="users.php" class="btn btn-secondary">กลับ</a>
    </form>

</body>

</html>