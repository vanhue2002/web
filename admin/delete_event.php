<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số event_id được truyền vào không
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Xóa sự kiện dựa trên event_id
    $query = "DELETE FROM events WHERE event_id = $event_id";

    if (mysqli_query($conn, $query)) {
        echo "<script type='text/javascript'>alert('Event deleted successfully'); window.location.href='./manage_event.php';</script>";

    } else {
        echo "Error occurred while deleting event: " . mysqli_error($conn);
    }
} else {
    echo "Event ID not provided";
}

// Đóng kết nối database
mysqli_close($conn);
?>
