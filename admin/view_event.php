<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Sự Kiện</title>
    <link rel="stylesheet" href="./css/view_event.css"> <!-- Liên kết file CSS -->
</head>
<body>
    <div class="container">
        <h2>Thông Tin Sự Kiện</h2>
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
                echo "<div class='info'>ID: " . $row['event_id'] . "</div>";
                echo "<div class='info'>Tên Sự Kiện: " . $row['event_name'] . "</div>";
                echo "<div class='info'>Ngày Bắt Đầu: " . $row['submission_start_date'] . "</div>";
                echo "<div class='info'>Ngày Kết Thúc: " . $row['submission_end_date'] . "</div>";
                echo "<div class='info'>Khoa: " . $row['faculty_name'] . "</div>";
            } else {
                echo "Sự kiện không tồn tại.";
            }
        } else {
            echo "ID sự kiện không được cung cấp.";
        }

        // Đóng kết nối database
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
