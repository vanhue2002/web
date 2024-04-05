<?php
// Đảm bảo rằng phiên đã được bắt đầu
// Kiểm tra xem session đã tồn tại chưa
if (session_status() == PHP_SESSION_NONE) {
    // Nếu chưa, bắt đầu một phiên session mới
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa và có vai trò là admin không
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Lưu trữ URL của trang trước đó
    $previous_page = $_SERVER['HTTP_REFERER'];

    // Nếu không có trang trước đó hoặc URL trống (nghĩa là không có thông tin về trang trước đó), hãy chuyển hướng về trang đăng nhập
    if ($previous_page === '' || !isset($previous_page)) {
        $previous_page = '../login/login.php';
    }

    // Hiển thị thông báo lỗi và chuyển hướng về trang trước đó
    echo "<script>alert('You don't have authorization to access this page!'); window.history.back();</script>";
    exit(); // Dừng kịch bản để ngăn chặn mã dưới đây được thực thi
}

// Nếu đến đây, có nghĩa là người dùng đã đăng nhập và có vai trò là admin

?>