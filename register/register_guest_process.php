<?php
require_once('../config.php');

// Kiểm tra xem đã nhận được dữ liệu từ form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem tất cả các trường cần thiết đã được điền vào chưa
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Lấy dữ liệu từ form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
        $query_check_username = "SELECT * FROM users WHERE username = '$username'";
        $result_check_username = mysqli_query($conn, $query_check_username);

        if (mysqli_num_rows($result_check_username) > 0) {
            // Nếu tên người dùng đã tồn tại, hiển thị thông báo lỗi
            echo "Tên người dùng đã tồn tại. Vui lòng chọn một tên người dùng khác.";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng vào cơ sở dữ liệu với vai trò khách
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'guest')";

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
