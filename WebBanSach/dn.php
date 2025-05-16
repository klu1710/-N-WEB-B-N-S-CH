<?php
session_start();
include('config.php'); // Kết nối cơ sở dữ liệu

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra người dùng trong cơ sở dữ liệu
    $query = "SELECT * FROM nguoi_dung WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['mat_khau'])) {
            $_SESSION['user'] = $user['id_nguoi_dung'];
            header('Location: index.php'); // Chuyển hướng đến trang chính
            exit;
        } else {
            echo "Mật khẩu không chính xác.";
        }
    } else {
        echo "Email không tồn tại.";
    }
}
?>
