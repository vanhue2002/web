<?php
require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['event_name']) && isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['faculty_name'])) {
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        $sql = "INSERT INTO events (event_name, submission_start_date, submission_end_date, faculty_name) VALUES ('$event_name', '$start_date', '$end_date', '$faculty_name')";

        if (mysqli_query($conn, $sql)) {

        } else {
            echo "Error occured while creating event: " . mysqli_error($conn);
        }
    } else {
        echo "Please fill in all required namespace!.";
    }
} else {
    header("Location: create_event.php");
}

mysqli_close($conn);
?>
