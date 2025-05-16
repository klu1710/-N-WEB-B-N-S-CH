<?php
session_start();
include('config.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header('Location: login.html');  // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    exit;
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$user_id = $_SESSION['user'];
$query = "SELECT * FROM nguoi_dung WHERE ma_nguoi_dung = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <h1>Chào mừng, <?php echo htmlspecialchars($user['ten']); ?>!</h1>
        <p>Đây là trang chủ của bạn.</p>
        <a href="logout.php">Đăng xuất</a>
    </div>

    <div class="content">
        <h2>Danh sách sách</h2>
        <?php
        // Truy vấn danh sách sách (hoặc nội dung khác bạn muốn hiển thị)
        $booksQuery = "SELECT * FROM sach";
        $booksResult = $conn->query($booksQuery);
        if ($booksResult->num_rows > 0) {
            while ($book = $booksResult->fetch_assoc()) {
                echo "<div class='book-item'>";
                echo "<h3>" . htmlspecialchars($book['ten_sach']) . "</h3>";
                echo "<p>Tác giả: " . htmlspecialchars($book['tac_gia']) . "</p>";
                echo "<p>Giá: " . number_format($book['gia'], 2) . " VNĐ</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Không có sách nào.</p>";
        }
        ?>
    </div>
</body>
</html>
