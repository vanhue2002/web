<?php
// Kết nối database
require_once('../config.php');
require_once('authentication.php');

// Kiểm tra xem có tham số event_id được truyền vào không
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Xóa các bản ghi liên quan từ bảng "contributions" trước khi xóa sự kiện từ bảng "events"
    $delete_contributions_query = "DELETE FROM contributions WHERE event_id = $event_id";

    if (mysqli_query($conn, $delete_contributions_query)) {
        // Tiếp tục xóa sự kiện từ bảng "events" sau khi đã xóa các bản ghi liên quan từ bảng "contributions"
        $delete_event_query = "DELETE FROM events WHERE event_id = $event_id";

        if (mysqli_query($conn, $delete_event_query)) {
            echo "<script>alert('The event has been successfully deleted!'); window.history.back();</script>";
        } else {
            echo "<script>alert('An error occurred while deleting the event: '); window.history.back();</script>" . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('An error occurred while deleting related records: '); window.history.back();</script>" . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Event ID not provided.'); window.history.back();</script>";
}

// Đóng kết nối database
mysqli_close($conn);
?>
