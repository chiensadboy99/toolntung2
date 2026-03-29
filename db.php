<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "key_system";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Hiện lỗi rõ ràng nếu có
?>
