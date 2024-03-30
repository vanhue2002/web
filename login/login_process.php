<?php
// Kết nối database
require_once('../config.php');

// Lấy dữ liệu từ form và loại bỏ ký tự đặc biệt
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Chuẩn bị truy vấn
$sql = "SELECT * FROM users WHERE username = '$username'";

// Thực thi truy vấn
$result = mysqli_query($conn, $sql);

// Kiểm tra xem có kết quả trả về hay không
if ($result) {
    // Lấy thông tin người dùng từ kết quả truy vấn
    $user = mysqli_fetch_assoc($result);

    // Kiểm tra mật khẩu
    if (password_verify($password, $user['password'])) {
        // Mật khẩu đúng, đăng nhập thành công
        // Lưu trữ thông tin session
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email']; // Gán giá trị email cho $_SESSION['email']

        // Chuyển hướng đến trang index của người dùng dựa trên vai trò
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../admin/index.php");
                break;
            case 'guest':
                // Thiết lập biến session cho guest
                session_start();
                // Thực hiện truy vấn để lấy thông tin khoa của guest từ cơ sở dữ liệu
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT faculty_name FROM users WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['faculty_name'] = $row['faculty_name']; // Giả sử thông tin khoa được lưu trong cột 'faculty_name'
                    header("Location: ../guest/index.php");
                    exit();
                } else {
                    // Xử lý khi không tìm thấy thông tin khoa của guest
                    header("Location: login.php?error=no_faculty_info");
                    exit();
                }
                break;
            case 'student':
                // Thiết lập biến session cho student
                session_start();
                // Thực hiện truy vấn để lấy thông tin khoa của sinh viên từ cơ sở dữ liệu
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT faculty_name FROM users WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['faculty_name'] = $row['faculty_name']; // Giả sử thông tin khoa được lưu trong cột 'faculty_name'
                    header("Location: ../student/index.php");
                    exit();
                } else {
                    // Xử lý khi không tìm thấy thông tin khoa của sinh viên
                    header("Location: login.php?error=no_faculty_info");
                    exit();
                }
                break;
            case 'Marketing Manager':
                header("Location: ../marketing_manager/index.php");
                break;
            case 'Marketing Coordinator':
                // Thiết lập biến session cho Marketing Coordinator
                session_start();
                $_SESSION['faculty_name'] = $user['faculty_name']; // Giả sử thông tin khoa được lưu trong cột 'faculty_name'
                header("Location: ../marketing_coordinator/index.php");
                exit();
                break;
            default:
                // Nếu vai trò không phù hợp, chuyển hướng đến trang đăng nhập
                header("Location: login.php?error=invalid_role");
                break;
        }
        exit();
    } else {
        // Mật khẩu không đúng, hiển thị thông báo lỗi
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    // Lỗi trong quá trình truy vấn, hiển thị thông báo lỗi
    header("Location: login.php?error=query_error");
    exit();
}

// Đóng kết nối database
mysqli_close($conn);
?>
