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
            echo "Sự kiện đã được xóa thành công!";
        } else {
            echo "Đã xảy ra lỗi khi xóa sự kiện: " . mysqli_error($conn);
        }
    } else {
        echo "Đã xảy ra lỗi khi xóa các bản ghi liên quan: " . mysqli_error($conn);
    }
} else {
    echo "ID sự kiện không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
