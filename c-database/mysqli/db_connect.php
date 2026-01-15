<?php
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "it67040233116"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
