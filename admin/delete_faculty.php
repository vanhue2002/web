<?php
require_once('../config.php');
require_once('authentication.php');

if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi liên quan trong bảng 'events'
        $delete_events_query = "DELETE FROM events WHERE faculty_name IN (SELECT faculty_name FROM faculties WHERE faculty_id = ?)";
        $stmt = $conn->prepare($delete_events_query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();

        // Xóa các bản ghi liên quan trong bảng 'contributions'
        $delete_contributions_query = "DELETE FROM contributions WHERE user_id IN (SELECT user_id FROM users WHERE faculty_name IN (SELECT faculty_name FROM faculties WHERE faculty_id = ?))";
        $stmt = $conn->prepare($delete_contributions_query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();

        // Xóa các bản ghi liên quan trong bảng 'comments'
        $delete_comments_query = "DELETE FROM comments WHERE contribution_id IN (SELECT contribution_id FROM contributions WHERE user_id IN (SELECT user_id FROM users WHERE faculty_name IN (SELECT faculty_name FROM faculties WHERE faculty_id = ?)))";
        $stmt = $conn->prepare($delete_comments_query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();

        // Xóa các bản ghi liên quan trong bảng 'users'
        $delete_users_query = "UPDATE users SET faculty_name = NULL WHERE faculty_name IN (SELECT faculty_name FROM faculties WHERE faculty_id = ?)";
        $stmt = $conn->prepare($delete_users_query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();

        // Xóa bản ghi trong bảng 'faculties'
        $delete_faculty_query = "DELETE FROM faculties WHERE faculty_id = ?";
        $stmt = $conn->prepare($delete_faculty_query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();

        // Nếu tất cả các thao tác thành công, hoàn tất giao dịch
        $conn->commit();

        echo "<script>alert('The faculty has been successfully deleted!'); window.history.back();</script>";
    } catch (mysqli_sql_exception $e) {
        // Nếu có lỗi, hủy giao dịch và thông báo lỗi
        $conn->rollback();
        echo "<script>alert('An error occurred while deleting the faculty: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }

    // Đóng truy vấn và kết nối
    $stmt->close();
} else {
    echo "<script>alert('Faculty ID not provided.'); window.history.back();</script>";
}

mysqli_close($conn);

?>