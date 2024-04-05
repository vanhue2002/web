<?php
session_start();
require_once('../config.php');

if (isset($_POST['submit_comment'])) {
    $contribution_id = $_POST['contribution_id'];
    $comment_content = $_POST['comment_content'];
    $user_id = $_SESSION['user_id']; 
    $sql_check_comment = "SELECT * FROM comments WHERE contribution_id = $contribution_id";
    $result_check_comment = mysqli_query($conn, $sql_check_comment);

    if (mysqli_num_rows($result_check_comment) > 0) {
        $sql_update_comment = "UPDATE comments SET content = '$comment_content', created_at = NOW() WHERE contribution_id = $contribution_id";
        $result_update_comment = mysqli_query($conn, $sql_update_comment);

        if ($result_update_comment) {
            echo "Edit comment successfully!";
        } else {
            echo "An error occurred while editing comment: " . mysqli_error($conn);
        }
    } else {
        $sql_add_comment = "INSERT INTO comments (contribution_id, user_id, content, created_at) VALUES ($contribution_id, $user_id, '$comment_content', NOW())";
        $result_add_comment = mysqli_query($conn, $sql_add_comment);

        if ($result_add_comment) {
            echo "Successfully commented!";
        } else {
            echo "An error occurred while commenting: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request!";
}

mysqli_close($conn);
?>
