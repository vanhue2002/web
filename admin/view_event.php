<?php
// Kết nối database
require_once('../config.php');
require_once('authentication.php');
include '../header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        section .signin .container h2 {
  font-size: 2em;
  color: #0f0;
  text-transform: uppercase;
  
}

/* CSS cho thẻ label */
section .signin .container{
  color: #fff;
}

section .signin .container form {
  text-align: center;
}

    </style>
</head>
<body>
      <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
    <div class="signin">
<div class="container">
    <h2 style="color: #0f0;">View  Event</h2><br>
   
        <?php 
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

    ?>
    </div>
    </div>
    </section>
    
</body>
</html>
<?php
// Đóng kết nối database
mysqli_close($conn);
?>
