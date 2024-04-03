<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <style>
       
/* Thêm CSS mới */
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
.container {
    display: flex;
    justify-content: center;
    align-items: center;
}

form {
    padding: 25px;
    border: 1px solid #ccc;
    box-shadow: 4px 4px 5px rgba(0,0,0,0.2);
    width: 60%;
    background: white;
}

form input[type="text"], form input[type="date"], form select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
}

form input[type="submit"] {
    background-color: #7986CB;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
  
</style>
    </style>
</head>
<body>
<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số event_id được truyền vào không
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Kiểm tra xem có dữ liệu được gửi từ biểu mẫu hay không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu và làm sạch dữ liệu
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $submission_start_date = $_POST['submission_start_date'];
        $submission_end_date = $_POST['submission_end_date'];
        $faculty_name = $_POST['faculty_name'];

        // Truy vấn SQL để cập nhật thông tin sự kiện
        $query = "UPDATE events SET event_name = '$event_name', submission_start_date = '$submission_start_date', submission_end_date = '$submission_end_date', faculty_name = '$faculty_name' WHERE event_id = $event_id";

        if (mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'>alert('Sự kiện đã được cập nhật thành công!'); window.location.href='./manage_event.php';</script>";
        } else {
            echo "Đã xảy ra lỗi khi cập nhật sự kiện: " . mysqli_error($conn);
        }
    }

    // Truy vấn để lấy thông tin của sự kiện dựa trên event_id
    $event_query = "SELECT * FROM events WHERE event_id = $event_id";
    $event_result = mysqli_query($conn, $event_query);

    // Hiển thị biểu mẫu để cập nhật thông tin sự kiện
    if (mysqli_num_rows($event_result) == 1) {
        $row = mysqli_fetch_assoc($event_result);
?>
        
            <h2>Cập Nhật Sự Kiện</h2>
           <div class="container">
           <form method="post">
                <label for="event_name">Tên Sự Kiện:</label><br>
                <input type="text" id="event_name" name="event_name" value="<?php echo $row['event_name']; ?>"><br>
                <label for="submission_start_date">Ngày Bắt Đầu:</label><br>
                <input type="date" id="submission_start_date" name="submission_start_date" value="<?php echo $row['submission_start_date']; ?>"><br>
                <label for="submission_end_date">Ngày Kết Thúc:</label><br>
                <input type="date" id="submission_end_date" name="submission_end_date" value="<?php echo $row['submission_end_date']; ?>"><br>
                <label for="faculty_name">Khoa:</label><br>
                <!-- Đây là một ví dụ đơn giản, bạn có thể sử dụng các phương thức khác để lấy danh sách khoa từ cơ sở dữ liệu -->
                <select id="faculty_name" name="faculty_name">
                    <?php
                        // Truy vấn để lấy danh sách các khoa
                        $query = "SELECT * FROM faculties";
                        $result = mysqli_query($conn, $query);

                        // Hiển thị các tùy chọn cho khoa
                        while ($faculty_row = mysqli_fetch_assoc($result)) {
                            $selected = ($faculty_row['faculty_name'] == $row['faculty_name']) ? 'selected' : '';
                            echo "<option value='" . $faculty_row['faculty_name'] . "' $selected>" . $faculty_row['faculty_name'] . "</option>";
                        }
                    ?>
                </select><br><br>
                <input type="submit" value="Cập Nhật">
            </form>
           </div>
                        
<?php
    } else {
        echo "Sự kiện không tồn tại.";
    }
} else {
    echo "ID sự kiện không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>

</body>
</html>