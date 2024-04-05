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
    mysqli_query($conn, $delete_statistics_query);

    // Xóa khoa từ bảng faculties
    $delete_faculty_query = "DELETE FROM faculties WHERE faculty_id = $faculty_id";

    if (mysqli_query($conn, $delete_faculty_query)) {
        echo "Khoa đã được xóa thành công!";
    } else {
        echo "Đã xảy ra lỗi khi xóa khoa: " . mysqli_error($conn);
    }
} else {
    echo "ID khoa không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>