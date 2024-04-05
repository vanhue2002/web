<?php
require_once('../config.php');
require_once('authentication.php');

// Kiểm tra xem đã nhận được dữ liệu từ form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem tất cả các trường cần thiết đã được điền vào chưa
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['role']) && isset($_POST['faculty_name'])) {
        // Lấy dữ liệu từ form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = $_POST['role'];
        $faculty_name = $_POST['faculty_name'];

        // Kiểm tra xem đã có Marketing Coordinator trong khoa được chỉ định hay chưa
        $query_check_existing_role = "SELECT * FROM users WHERE role = 'Marketing Coordinator' AND faculty_name = '$faculty_name'";
        $result_check_existing_role = mysqli_query($conn, $query_check_existing_role); 

        if ($role == "Marketing Coordinator" && mysqli_num_rows($result_check_existing_role) > 0) {
            // Nếu đã có Marketing Coordinator trong khoa, hiển thị thông báo lỗi
            echo "<script>alert('Đã có một Marketing Coordinator cho khoa này rồi. Không thể thêm nữa.'); window.history.back();</script>";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Thêm người dùng vào cơ sở dữ liệu với vai trò đã chọn và faculty_name tương ứng
            $sql = "INSERT INTO users (username, password, email, role, faculty_name) VALUES ('$username', '$hashed_password', '$email', '$role', '$faculty_name')";

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
    header("Location: register_admin.php");
}

// Đóng kết nối database
mysqli_close($conn);
?>
