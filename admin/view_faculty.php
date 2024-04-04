<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        main {
    padding: 20px;
    background-color: #fff;
    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm box-shadow */
    margin: 0 20%; /* Căn giữa với padding 20% ở cả hai bên */
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
    <main>
    <?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số faculty_id được truyền vào không
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Truy vấn để lấy thông tin của khoa dựa trên faculty_id
    $query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $result = mysqli_query($conn, $query);

    // Kiểm tra xem khoa có tồn tại không
    if (mysqli_num_rows($result) == 1) {
        // Hiển thị thông tin của khoa
        $row = mysqli_fetch_assoc($result);
        echo "ID: " . $row['faculty_id'] . "<br>";
        echo "Tên Khoa: " . $row['faculty_name'] . "<br>";
    } else {
        echo "Khoa không tồn tại.";
    }
} else {
    echo "ID khoa không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
    </main>

 <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>