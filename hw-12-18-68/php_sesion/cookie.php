<?php
$welcome_message = "";

// 1. ตรวจสอบเมื่อมีการกดปุ่ม Submit
if (isset($_POST["submit"])) {
    $new_username = htmlspecialchars($_POST["username"]); // ชื่อที่กรอกเข้ามาใหม่
    $old_username = isset($_COOKIE["user"]) ? $_COOKIE["user"] : ""; // ชื่อที่เคยจำไว้ (ถ้ามี)

    // 2. ตรวจสอบว่าชื่อที่กรอกใหม่ "ไม่ตรงกับ" ชื่อที่เคยจำไว้ใช่หรือไม่
    if ($new_username !== $old_username) {
        // ถ้าชื่อไม่ตรงกัน หรือไม่เคยมีชื่อมาก่อนเลย ให้ถือว่าเป็นผู้ใช้ใหม่
        $welcome_message = "ยินดีต้อนรับผู้ใช้ใหม่: " . $new_username;
    } else {
        // ถ้าชื่อตรงกับที่มีใน Cookie อยู่แล้ว
        $welcome_message = "ยินดีต้อนรับกลับ คุณ, " . $new_username;
    }

    // 3. บันทึกชื่อใหม่ลงใน Cookie (จะทับชื่อเดิมถ้ามี)
    setcookie("user", $new_username, time() + 3600, "/");

} 
// 4. กรณีเปิดหน้าเว็บมาเฉยๆ โดยไม่ได้กด Submit
elseif (isset($_COOKIE["user"])) {
    $welcome_message = "ยินดีต้อนรับกลับ คุณ, " . $_COOKIE["user"];
} else {
    $welcome_message = "ยินดีต้อนรับผู้ใช้ใหม่";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Cookie Check</title>
</head>
<body>
    <h1><?php echo $welcome_message; ?></h1>

    <form method="post" action="">
        <label>กรอกชื่อของคุณ:</label>
        <input type="text" name="username" required>
        <button type="submit" name="submit">ส่งข้อมูล</button>
    </form>
</body>
</html>