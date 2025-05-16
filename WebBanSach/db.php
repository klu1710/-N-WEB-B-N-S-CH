<?php
$servername = "localhost";
$username = "root";  // Tên đăng nhập CSDL
$password = "vertrigo";      // Mật khẩu CSDL
$dbname = "csdlbs"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}
?>
