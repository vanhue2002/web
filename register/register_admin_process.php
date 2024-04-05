<?php
require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['role']) && isset($_POST['faculty_name'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = $_POST['role'];
        $faculty_name = $_POST['faculty_name'];

        $query_check_username = "SELECT * FROM users WHERE username = '$username'";
        $result_check_username = mysqli_query($conn, $query_check_username);

        if (mysqli_num_rows($result_check_username) > 0) {
            echo "Tên người dùng đã tồn tại. Vui lòng chọn một tên người dùng khác.";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, email, role, faculty_name) VALUES ('$username', '$hashed_password', '$email', '$role', '$faculty_name')";

            if (mysqli_query($conn, $sql)) {
                echo "Đăng ký tài khoản thành công!";
                echo "<a href='../'>Trở lại trang chủ</a>";
            } else {
                echo "Đã xảy ra lỗi: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin đăng ký.";
    }

} else {
    header("Location: register_admin.php");
}

mysqli_close($conn);
?>
