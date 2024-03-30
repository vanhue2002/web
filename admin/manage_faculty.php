<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Khoa</title>
</head>
<body>
    <h2>Quản Lý Khoa</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên Khoa</th>
            <th>Hành Động</th>
        </tr>
        <?php
        // Kết nối database
        require_once('../config.php');

        // Truy vấn để lấy danh sách các khoa
        $query = "SELECT * FROM faculties";
        $result = mysqli_query($conn, $query);

        // Hiển thị các khoa trong bảng
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['faculty_id'] . "</td>";
            echo "<td>" . $row['faculty_name'] . "</td>";
            echo "<td><a href='view_faculty.php?faculty_id=" . $row['faculty_id'] . "'>Xem</a> | <a href='delete_faculty.php?faculty_id=" . $row['faculty_id'] . "'>Xóa</a> | <a href='update_faculty.php?faculty_id=" . $row['faculty_id'] . "'>Cập Nhật</a></td>";
            echo "</tr>";
        }

        // Đóng kết nối database
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
