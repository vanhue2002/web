<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số faculty_id được truyền vào không
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Truy vấn để lấy thông tin của khoa dựa trên faculty_id
    $query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $result = mysqli_query($conn, $query);

    // Kiểm tra xem khoa có tồn tại không
    if (mysqli_num_rows($result) == 1) {
        // Hiển thị thông tin của khoa
        $row = mysqli_fetch_assoc($result);
        echo "ID: " . $row['faculty_id'] . "<br>";
        echo "Tên Khoa: " . $row['faculty_name'] . "<br>";
    } else {
        echo "Khoa không tồn tại.";
    }
} else {
    echo "ID khoa không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
