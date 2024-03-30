<?php
session_start();

// Hủy phiên đăng nhập
unset($_SESSION['username']);
unset($_SESSION['user_id']);
unset($_SESSION['role']);

// Chuyển hướng đến trang khác sau khi đăng xuất
header("Location: login.php"); // Thay đổi "login.php" thành URL của trang bạn muốn chuyển hướng người dùng đến
exit(); // Đảm bảo không có mã HTML hoặc PHP được thực thi sau khi chuyển hướng
?>
