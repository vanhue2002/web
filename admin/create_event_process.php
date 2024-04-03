<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem đã nhận được dữ liệu từ form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem tất cả các trường cần thiết đã được điền vào chưa
    if (isset($_POST['event_name']) && isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['faculty_name'])) {
        // Lấy dữ liệu từ form
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        // Thêm thông tin về sự kiện vào cơ sở dữ liệu
        $sql = "INSERT INTO events (event_name, submission_start_date, submission_end_date, faculty_name) VALUES ('$event_name', '$start_date', '$end_date', '$faculty_name')";

        // Thực thi truy vấn
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('Sự kiện đã được tạo thành công!'); window.location.href='./manage_event.php';</script>";

        } else {
            echo "Đã xảy ra lỗi khi tạo sự kiện: " . mysqli_error($conn);
        }
    } else {
        // Nếu thiếu trường thông tin cần thiết, hiển thị thông báo lỗi
        echo "Vui lòng điền đầy đủ thông tin để tạo sự kiện.";
    }
} else {
    // Nếu không phải là phương thức POST, chuyển hướng người dùng đến trang tạo sự kiện
    header("Location: create_event.php");
}

// Đóng kết nối database
mysqli_close($conn);
?>
