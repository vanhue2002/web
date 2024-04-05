<?php
require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['faculty_name'])) {
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        $query = "SELECT * FROM faculties WHERE faculty_name = '$faculty_name'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script type='text/javascript'>alert('Faculty name already exist. Please choose another name.'); window.location.href='./create_faculty.php';</script>";

         
        } else {
            $sql = "INSERT INTO faculties (faculty_name) VALUES ('$faculty_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<script type='text/javascript'>alert('Khoa đã được tạo thành công!'); window.location.href='./manage_faculty.php';</script>";

            } else {
                echo "Error occurred while creating Faculty: " . mysqli_error($conn);
            }
        }
    } else {
    }
} else {
    header("Location: create_faculty.php");
}

mysqli_close($conn);
?>
