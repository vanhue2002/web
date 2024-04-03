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
<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số event_id được truyền vào không
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Truy vấn để lấy thông tin của sự kiện dựa trên event_id và JOIN với bảng faculties để lấy tên khoa
    $query = "SELECT events.*, faculties.faculty_name 
              FROM events 
              LEFT JOIN faculties ON events.faculty_name = faculties.faculty_name 
              WHERE event_id = $event_id";
    $result = mysqli_query($conn, $query);

    // Kiểm tra xem sự kiện có tồn tại không
    if (mysqli_num_rows($result) == 1) {
        // Hiển thị thông tin của sự kiện
        $row = mysqli_fetch_assoc($result);
        echo "ID: " . $row['event_id'] . "<br>";
        echo "Tên Sự Kiện: " . $row['event_name'] . "<br>";
        echo "Ngày Bắt Đầu: " . $row['submission_start_date'] . "<br>";
        echo "Ngày Kết Thúc: " . $row['submission_end_date'] . "<br>";
        echo "Khoa: " . $row['faculty_name'] . "<br>";
    } else {
        echo "Sự kiện không tồn tại.";
    }
} else {
    echo "ID sự kiện không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
 <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>