<?php
require_once('../config.php');

if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    $query = "DELETE FROM faculties WHERE faculty_id = $faculty_id";

    if (mysqli_query($conn, $query)) {
        echo "<script type='text/javascript'>alert('Faculty deleted successfully!'); window.location.href='./manage_faculty.php';</script>";

      
    } else {
        echo "Error occurred while deleting faculty: " . mysqli_error($conn);
    }
    echo "Faculty ID not provided.";
}

mysqli_close($conn);
?>
