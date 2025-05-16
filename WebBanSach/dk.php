<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $ten = trim($_POST['ten']);
    $ten_tai_khoan = trim($_POST['ten_tai_khoan']);
    $email = trim($_POST['email']);
    $mat_khau = $_POST['mat_khau'];
    $mat_khau_confirm = $_POST['mat_khau_confirm'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($ten) || empty($ten_tai_khoan) || empty($email) || empty($mat_khau) || empty($mat_khau_confirm)) {
        echo "Vui lòng điền đầy đủ thông tin.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Địa chỉ email không hợp lệ.";
        exit();
    }

    if (strlen($mat_khau) < 6) {
        echo "Mật khẩu phải có ít nhất 6 ký tự.";
        exit();
    }

    if ($mat_khau !== $mat_khau_confirm) {
        echo "Mật khẩu và xác nhận mật khẩu không khớp.";
        exit();
    }

    // Mã hóa mật khẩu
    $mat_khau_hash = password_hash($mat_khau, PASSWORD_DEFAULT);

    // Kết nối CSDL
    $conn = new mysqli("localhost", "root", "vertrigo", "csdlbansach");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Dùng prepared statement để tránh lỗi SQL Injection
    $stmt = $conn->prepare("INSERT INTO nguoi_dung (ten_tk, email, mat_khau) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ten_tai_khoan, $email, $mat_khau_hash);

    if ($stmt->execute()) {
        // Thành công -> chuyển sang trang đăng nhập
        header("Location: dn.html");
        exit();
    } else {
        if ($conn->errno == 1062) {
            echo "Tên tài khoản hoặc email đã tồn tại.";
        } else {
            echo "Lỗi đăng ký: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
