<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem đã nhận được dữ liệu từ form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem trường tên khoa đã được điền vào hay không
    if (isset($_POST['faculty_name'])) {
        // Lấy tên khoa từ form và làm sạch dữ liệu
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        // Kiểm tra xem tên khoa đã tồn tại trong cơ sở dữ liệu hay chưa
        $query = "SELECT * FROM faculties WHERE faculty_name = '$faculty_name'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Nếu tên khoa đã tồn tại, hiển thị thông báo lỗi
            echo "<script type='text/javascript'>alert('Tên khoa đã tồn tại. Vui lòng chọn tên khoa khác.'); window.location.href='./create_faculty.php';</script>";

         
        } else {
            // Nếu tên khoa chưa tồn tại, thêm thông tin về khoa vào cơ sở dữ liệu
            $sql = "INSERT INTO faculties (faculty_name) VALUES ('$faculty_name')";

            // Thực thi truy vấn
            if (mysqli_query($conn, $sql)) {
                echo "<script type='text/javascript'>alert('Khoa đã được tạo thành công!'); window.location.href='./manage_faculty.php';</script>";

            } else {
                echo "Đã xảy ra lỗi khi tạo khoa: " . mysqli_error($conn);
            }
        }
    } else {
        // Nếu thiếu trường thông tin cần thiết, hiển thị thông báo lỗi
        echo "Vui lòng điền tên khoa để tạo khoa mới.";
    }
} else {
    // Nếu không phải là phương thức POST, chuyển hướng người dùng đến trang tạo khoa
    header("Location: create_faculty.php");
}

// Đóng kết nối database
mysqli_close($conn);
?>
