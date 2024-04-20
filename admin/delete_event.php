<?php
require_once('../config.php');
require_once('authentication.php');

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi liên quan trong bảng 'comments'
        $delete_comments_query = "DELETE FROM comments WHERE contribution_id IN (SELECT contribution_id FROM contributions WHERE event_id = ?)";
        $stmt = $conn->prepare($delete_comments_query);
        $stmt->bind_param('i', $event_id);
        $stmt->execute();

        // Xóa các bản ghi trong bảng 'contributions' liên quan đến sự kiện
        $delete_contributions_query = "DELETE FROM contributions WHERE event_id = ?";
        $stmt = $conn->prepare($delete_contributions_query);
        $stmt->bind_param('i', $event_id);
        $stmt->execute();

        // Xóa bản ghi trong bảng 'events'
        $delete_event_query = "DELETE FROM events WHERE event_id = ?";
        $stmt = $conn->prepare($delete_event_query);
        $stmt->bind_param('i', $event_id);
        $stmt->execute();

        // Nếu tất cả các thao tác thành công, hoàn tất giao dịch
        $conn->commit();

        echo "<script>alert('The event has been successfully deleted!'); window.history.back();</script>";
    } catch (mysqli_sql_exception $e) {
        // Nếu có lỗi, hủy giao dịch và thông báo lỗi
        $conn->rollback();
        echo "<script>alert('An error occurred while deleting the event: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }

    // Đóng truy vấn và kết nối
    $stmt->close();
} else {
    echo "<script>alert('Event ID not provided.'); window.history.back();</script>";
}

mysqli_close($conn);

?>
