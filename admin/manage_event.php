<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sự Kiện</title>
    <style>
        body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #f0f0f0;
  margin-bottom:60px;
}

table {
  border-collapse: collapse;
  width: 80%;
  margin: 0 auto;
  box-shadow: 0px 0px 20px 0px rgba(15,15,15,0.2);
  background-color: white;
}

table th, table td {
  padding: 12px;
  text-align: center;
}

table th {
  background-color: #7986CB;
  color: white;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}
footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  background-color: #343a40;
  color: #fff;
  text-align: center;
}
    </style>

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
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>

</body>
</html>
