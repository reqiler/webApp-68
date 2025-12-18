<?php
session_start();

$_SESSION['username'] = "Student";
$_SESSION['role'] = "Admin";

echo "สร้าง Session เรียบร้อย";
?>