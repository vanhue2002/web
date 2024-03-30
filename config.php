<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "asm4";

// Thực hiện kết nối đến cơ sở dữ liệu
$conn = new mysqli($hostname, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    // Nếu kết nối thất bại, hiển thị thông báo lỗi và kết thúc kịch bản
    die("Kết nối database thất bại: " . $conn->connect_error);
} else {
    // // Nếu kết nối thành công, hiển thị thông báo thành công
    // echo "Kết nối database thành công!";
}

// Thiết lập bộ ký tự cho kết nối
$conn->set_charset("utf8");
?>
