<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "กรุณาล็อกอินเข้าระบบ";
} else{
    echo "ยินดีต้อนรับสู้ระบบ " . $_SESSION['username'];
}
?>