<?php
session_start(); 
require_once('../config.php');

if (isset($_POST['publish_contribution']) && isset($_SESSION['faculty_name'])) {
    $faculty_name = $_SESSION['faculty_name'];
    $contribution_id = $_POST['contribution_id'];

    $sql_check_status = "SELECT status FROM contributions WHERE contribution_id = $contribution_id";
    $result_check_status = mysqli_query($conn, $sql_check_status);
    if ($result_check_status && mysqli_num_rows($result_check_status) > 0) {
        $row = mysqli_fetch_assoc($result_check_status);
        $current_status = $row['status'];
        
        if ($current_status === "submitted") {
            $sql_update = "UPDATE contributions SET status = 'published' WHERE contribution_id = $contribution_id";
            $result_update = mysqli_query($conn, $sql_update);

            if ($result_update) {
                echo "Contributions published successfully!.";
            } else {
                echo "An error occurred, publication failed.";
            }
        } else {
            echo "This contribution has been published.";
        }
    } else {
        echo "Can't check on current status of the contribution.";
    }
} else {
    echo "Invalid request.";
}
?>
