<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sự Kiện</title>
</head>
<body>
    <h2>Quản Lý Sự Kiện</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên Sự Kiện</th>
            <th>Ngày Bắt Đầu</th>
            <th>Ngày Kết Thúc</th>
            <th>Khoa</th>
            <th>Hành Động</th>
        </tr>
        <?php
        // Kết nối database
        require_once('../config.php');

        // Truy vấn để lấy danh sách các sự kiện và tên khoa
        $query = "SELECT events.*, faculties.faculty_name FROM events LEFT JOIN faculties ON events.faculty_name = faculties.faculty_name";
        $result = mysqli_query($conn, $query);

        // Hiển thị các sự kiện trong bảng
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['event_id'] . "</td>";
            echo "<td>" . $row['event_name'] . "</td>";
            echo "<td>" . $row['submission_start_date'] . "</td>";
            echo "<td>" . $row['submission_end_date'] . "</td>";
            echo "<td>" . $row['faculty_name'] . "</td>";
            echo "<td><a href='view_event.php?event_id=" . $row['event_id'] . "'>Xem</a> | <a href='delete_event.php?event_id=" . $row['event_id'] . "'>Xóa</a> | <a href='update_event.php?event_id=" . $row['event_id'] . "'>Cập Nhật</a></td>";
            echo "</tr>";
        }

        // Đóng kết nối database
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
