<?php
$host = "localhost";
$dbname = "it67040233116";
$user = "root";
$pass = "";

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // แสดง error แบบ Exception
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // ดึงข้อมูลเป็น array แบบ associative
        ]
    );
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
