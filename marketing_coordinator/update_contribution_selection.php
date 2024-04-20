<?php
require_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contribution_id = (int)$_POST['contribution_id'];
    $is_selected = isset($_POST['is_selected']) ? 1 : 0;

    // Cập nhật trạng thái chọn trong cơ sở dữ liệu
    $sql = "UPDATE contributions SET is_selected = $is_selected WHERE contribution_id = $contribution_id";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: coordinator_manage_contribution.php');
        exit;
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Đóng kết nối
mysqli_close($conn);
?>
