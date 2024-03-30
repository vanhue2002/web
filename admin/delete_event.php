<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số event_id được truyền vào không
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Xóa sự kiện dựa trên event_id
    $query = "DELETE FROM events WHERE event_id = $event_id";

    if (mysqli_query($conn, $query)) {
        echo "Sự kiện đã được xóa thành công!";
    } else {
        echo "Đã xảy ra lỗi khi xóa sự kiện: " . mysqli_error($conn);
    }
} else {
    echo "ID sự kiện không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
