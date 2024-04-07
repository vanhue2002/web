<?php
// Kết nối database
require_once('../config.php');
require_once('authentication.php');

// Kiểm tra xem có tham số faculty_id được truyền vào không
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Truy vấn SQL để xóa các thông tin liên quan đến khoa
    $delete_contributions_query = "DELETE FROM contributions WHERE user_id IN (SELECT user_id FROM users WHERE faculty_name IN (SELECT faculty_name FROM faculties WHERE faculty_id = $faculty_id))";
    $delete_comments_query = "DELETE FROM comments WHERE contribution_id IN (SELECT contribution_id FROM contributions WHERE user_id IN (SELECT user_id FROM users WHERE faculty_name IN (SELECT faculty_name FROM faculties WHERE faculty_id = $faculty_id)))";
    $delete_statistics_query = "DELETE FROM statistics WHERE faculty_id = $faculty_id";

    // Thực thi truy vấn xóa
    mysqli_query($conn, $delete_comments_query);
    mysqli_query($conn, $delete_contributions_query);

    // Xóa khoa từ bảng faculties
    $delete_faculty_query = "DELETE FROM faculties WHERE faculty_id = $faculty_id";

    if (mysqli_query($conn, $delete_faculty_query)) {
        echo "<script>alert('The faculty has been successfully deleted!'); window.history.back();</script>";
    } else {
        echo "<script>alert('An error occurred while deleting the faculty: '); window.history.back();</script>" . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Faculty ID not provided.'); window.history.back();</script>";
}

// Đóng kết nối database
mysqli_close($conn);
?>