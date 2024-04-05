<?php
require_once('../config.php');

// Kiểm tra xem đã nhận được dữ liệu từ form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem tất cả các trường cần thiết đã được điền vào chưa
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['faculty'])) {
        // Lấy dữ liệu từ form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);

        // Kiểm tra xem khoa đã có guest khác đăng ký chưa
        $query_check_faculty = "SELECT * FROM users WHERE role = 'guest' AND faculty_name = '$faculty'";
        $result_check_faculty = mysqli_query($conn, $query_check_faculty);

        if (mysqli_num_rows($result_check_faculty) > 0) {
            // Nếu đã tồn tại guest từ khoa đó, hiển thị thông báo lỗi
            echo "<script>alert('Đã có một guest từ khoa này đăng ký rồi. Vui lòng chọn khoa khác.'); window.history.back();</script>";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng vào cơ sở dữ liệu với vai trò khách
            $sql = "INSERT INTO users (username, password, role, faculty_name) VALUES ('$username', '$hashed_password', 'guest', '$faculty')";

            // Thực thi truy vấn
            if (mysqli_query($conn, $sql)) {
                echo "Đăng ký tài khoản thành công!";
                echo "<a href='../'>Trở lại trang chủ</a>";
            } else {
                echo "Đã xảy ra lỗi: " . mysqli_error($conn);
            }
        }
    } else {
        // Nếu thiếu trường thông tin cần thiết, hiển thị thông báo lỗi
        echo "Vui lòng điền đầy đủ thông tin đăng ký.";
    }
} else {
    // Nếu không phải là phương thức POST, chuyển hướng người dùng đến trang đăng ký
    header("Location: register_guest.php");
}

// Đóng kết nối database
mysqli_close($conn);
?>
