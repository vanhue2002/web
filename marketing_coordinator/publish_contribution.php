<?php
session_start();
require_once('../config.php');
require_once('authentication.php');
require_once('header.php');

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
                echo "Đóng góp đã được xuất bản thành công.";
            } else {
                echo "Có lỗi xảy ra. Không thể xuất bản đóng góp.";
            }
        } else {
            echo "Đóng góp này đã được xuất bản trước đó.";
        }
    } else {
        echo "Không thể kiểm tra trạng thái của đóng góp.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
