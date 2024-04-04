<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Khoa</title>
    <style>
            body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
  min-height: 100vh; /* new */
  display: flex; /* new */
  flex-direction: column; /* new */
}
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #f0f0f0;
  margin-bottom:60px;
}
main {
  flex:1;
    padding: 20px;
    background-color: #fff;
    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm box-shadow */
    margin: 0 20%; /* Căn giữa với padding 20% ở cả hai bên */
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
@media screen and (max-width: 800px) {
            main {
              margin: 0 4%; /* Căn giữa với padding 20% ở cả hai bên */
            }
           
    </style>
</head>
<body>
   <main>
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
   </main>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
