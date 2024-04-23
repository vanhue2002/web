<?php
require_once('../config.php');
require_once('authentication.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['role']) && isset($_POST['faculty_name'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = $_POST['role'];
        $faculty_name = $_POST['faculty_name'];

        $query_check_existing_role = "SELECT * FROM users WHERE role = 'Marketing Coordinator' AND faculty_name = '$faculty_name'";
        $result_check_existing_role = mysqli_query($conn, $query_check_existing_role); 

        if ($role == "Marketing Coordinator" && mysqli_num_rows($result_check_existing_role) > 0) {
            echo "<script>alert('Đã có một Marketing Coordinator cho khoa này rồi. Không thể thêm nữa.'); window.history.back();</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, email, role, faculty_name) VALUES ('$username', '$hashed_password', '$email', '$role', '$faculty_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<script type='text/javascript'>alert('Sucessfully!.'); window.location.href='../login/login.php';</script>";

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
