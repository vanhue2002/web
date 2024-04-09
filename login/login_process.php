<?php
require_once('../config.php');

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "SELECT * FROM users WHERE username = '$username'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email']; 

        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../admin/index.php");
                break;
            case 'guest':
                session_start();
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT faculty_name FROM users WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['faculty_name'] = $row['faculty_name'];
                    header("Location: ../guest/list_publish_contribution.php");
                    exit();
                } else {
                    header("Location: login.php?error=no_faculty_info");
                    exit();
                }
                break;
            case 'student':
                session_start();
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT faculty_name FROM users WHERE user_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['faculty_name'] = $row['faculty_name'];
                    header("Location: ../student/index.php");
                    exit();
                } else {
                    header("Location: login.php?error=no_faculty_info");
                    exit();
                }
                break;
            case 'Marketing Manager':
                header("Location: ../marketing_manager/index.php");
                break;
            case 'Marketing Coordinator':
                session_start();
                $_SESSION['faculty_name'] = $user['faculty_name']; 
                header("Location: ../marketing_coordinator/index.php");
                exit();
                break;
            default:
                header("Location: login.php?error=invalid_role");
                break;
        }
        exit();
    } else {
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    header("Location: login.php?error=query_error");
    exit();
}

mysqli_close($conn);
?>
