<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số faculty_id được truyền vào không
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Truy vấn SQL để xóa khoa dựa trên faculty_id
    $query = "DELETE FROM faculties WHERE faculty_id = $faculty_id";

    if (mysqli_query($conn, $query)) {
        echo "<script type='text/javascript'>alert('Khoa đã được xóa thành công!'); window.location.href='./manage_faculty.php';</script>";

      
    } else {
        echo "Đã xảy ra lỗi khi xóa khoa: " . mysqli_error($conn);
    }
} else {
    echo "ID khoa không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
