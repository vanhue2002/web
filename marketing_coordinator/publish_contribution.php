<?php
session_start(); // Bắt đầu hoặc khởi tạo phiên
require_once('../config.php');

if (isset($_POST['publish_contribution']) && isset($_SESSION['faculty_name'])) {
    $faculty_name = $_SESSION['faculty_name'];
    $contribution_id = $_POST['contribution_id'];

    // Kiểm tra trạng thái hiện tại của đóng góp
    $sql_check_status = "SELECT status FROM contributions WHERE contribution_id = $contribution_id";
    $result_check_status = mysqli_query($conn, $sql_check_status);
    if ($result_check_status && mysqli_num_rows($result_check_status) > 0) {
        $row = mysqli_fetch_assoc($result_check_status);
        $current_status = $row['status'];
        
        // Nếu trạng thái là "submitted" thì cập nhật thành "published"
        if ($current_status === "submitted") {
            $sql_update = "UPDATE contributions SET status = 'published' WHERE contribution_id = $contribution_id";
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
