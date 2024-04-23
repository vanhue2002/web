<?php
require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['faculty'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
        $query_check_faculty = "SELECT * FROM users WHERE role = 'guest' AND faculty_name = '$faculty'";
        $result_check_faculty = mysqli_query($conn, $query_check_faculty);

        if (mysqli_num_rows($result_check_faculty) > 0) {
            echo "<script>alert('A guest from this department has already registered. Please choose another department.'); window.history.back();</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, role, faculty_name) VALUES ('$username', '$hashed_password', 'guest', '$faculty')";

            if (mysqli_query($conn, $sql)) {
       
                      echo "<script type='text/javascript'>alert('Sucessfully!.'); window.location.href='../login/login.php';</script>";


            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Please fill in all information.";
    }
} else {
    header("Location: register_guest.php");
}

mysqli_close($conn);
?>
