<?php
session_start();
require_once('../config.php');
require_once('authentication.php');
include '../header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Import CSS từ Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

        /* Thiết lập CSS cơ bản */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }

        /* CSS cho phần tử đã được xuất bản */
        .published-item {
            background-color: #4CAF50; /* Màu nền cho phần tử đã xuất bản */
            color: white; /* Màu chữ cho phần tử đã xuất bản */
            /* Thêm các thuộc tính CSS khác tùy theo yêu cầu của bạn */
        }
    </style>
</head>
<body>
    <?php
if (isset($_POST['publish_contribution']) && isset($_SESSION['faculty_name'])) {
    $faculty_name = $_SESSION['faculty_name'];
    $contribution_id = $_POST['contribution_id'];

    $sql_check_status = "SELECT status FROM contributions WHERE contribution_id = $contribution_id";
    $result_check_status = mysqli_query($conn, $sql_check_status);
    if ($result_check_status && mysqli_num_rows($result_check_status) > 0) {
        $row = mysqli_fetch_assoc($result_check_status);
        $current_status = $row['status'];
        
        if ($current_status === "submitted") {
            $sql_update = "UPDATE contributions SET status = 'published', created_at = NOW() WHERE contribution_id = $contribution_id";
            $result_update = mysqli_query($conn, $sql_update);

            if ($result_update) {

                echo "<script>alert('The contribution has been published successfully.'); window.history.back()</script>";
        
            } else {
                echo "An error occurred. Contribution cannot be published.";
            }
        } else {
            echo "This contribution has been published previously.";
        }
    } else {
        echo "Unable to check the status of the contribution.";
    }
} else {
    echo "Invalid request.";
}
?>
</body>
</html>
