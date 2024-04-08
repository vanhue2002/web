<?php
require_once('../config.php');
require_once('authentication.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['faculty_name'])) {
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        $query = "SELECT * FROM faculties WHERE faculty_name = '$faculty_name'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Faculty name already exists. Please choose another faculty name.'); window.history.back();</script>";
        } else {
            $sql = "INSERT INTO faculties (faculty_name) VALUES ('$faculty_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('The faculty has been created successfully!'); window.history.back();</script>";
            } else {
                echo "<script>alert('An error occurred while creating the faculty: '); window.history.back();</script>" . mysqli_error($conn);
            }
        }
    } else {
        echo "<script>alert('Please fill in all information to create an faculty.'); window.history.back();</script>";
    }
} else {
    header("Location: create_faculty.php");
}

mysqli_close($conn);
?>
