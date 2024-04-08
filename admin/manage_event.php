<?php
require_once('authentication.php');
include '../header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sự Kiện</title>
    <link rel="stylesheet" href="./css/manage_event.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
       
    </style>


</head>
<body>
    
<section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
        <div class="signin " style="width:80%" > <!-- Thêm lớp "signin" để giữ cấu trúc và kiểu dáng -->
            <div class="container"> <!-- Thêm phần container để bao bọc nội dung -->
  
                <h2 style="color: #0f0;">MANAGE EVENTS</h2>
                <br>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Event name</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Faculty</th>
                        <th>Action</th>
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
                        echo "<td><a href='view_event.php?event_id=" . $row['event_id'] . "'>View</a> | <a href='delete_event.php?event_id=" . $row['event_id'] . "'>Delete</a> | <a href='update_event.php?event_id=" . $row['event_id'] . "'>Update</a></td>";
                        echo "</tr>";
                    }

                    // Đóng kết nối database
                    mysqli_close($conn);
                    ?>
                </table>
            </div> <!-- Kết thúc container -->
        </div> <!-- Kết thúc signin -->
    </section>
    
</body>
</html>
