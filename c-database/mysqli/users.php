<?php
include 'db_connect.php';

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

    <h3>รายชื่อผู้ใช้</h3>
    <a href="form.php" class="btn btn-success mb-3">เพิ่มข้อมูล</a>

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
                <td>
                    <?= $row['sex'] == 'M' ? 'ชาย' : ($row['sex'] == 'F' ? 'หญิง' : 'อื่นๆ'); ?>
                </td>
                <td><?= $row['phone']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['birthday']; ?></td>
                <td>
                    <a href="form.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                    <a href="delete.php?id=<?= $row['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>

</html>