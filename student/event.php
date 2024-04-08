<?php
require_once('../config.php');
include '../header.php';
require_once('authentication.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.event_id, e.event_name, e.submission_start_date, e.submission_end_date
        FROM events e
        INNER JOIN faculties f ON e.faculty_name = f.faculty_name
        INNER JOIN users u ON u.faculty_name = f.faculty_name
        WHERE u.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
include("./views/event.html");
?>



<?php
mysqli_close($conn);
?>
