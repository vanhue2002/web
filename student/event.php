<?php
require_once('../config.php');
require_once('../login/header.php');

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy user_id của sinh viên từ session
$user_id = $_SESSION['user_id'];

// Truy vấn để lấy các sự kiện cho khoa của sinh viên
$sql = "SELECT e.event_id, e.event_name, e.submission_start_date, e.submission_end_date
        FROM events e
        INNER JOIN faculties f ON e.faculty_name = f.faculty_name
        INNER JOIN users u ON u.faculty_name = f.faculty_name
        WHERE u.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Index</title>
    <!-- Add your CSS links here -->
    <style>

body{
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg'); /* Thay đổi 'background_image.jpg' thành đường dẫn tới hình ảnh nền của bạn */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}
main {
    padding: 20px;
    background-color: #fff;
    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm box-shadow */
    margin: 0 20%; /* Căn giữa với padding 20% ở cả hai bên */
}
main ul li {
    color : #fff;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc; /* Đường viền xung quanh mỗi box */
    border-radius: 5px; /* Bo tròn các góc của box */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm đổ bóng cho mỗi box */
    list-style: none;
    background-color: red;
}
    </style>
</head>
<body>

    <main>
        <h2>Events for Your Faculty</h2>
        <ul>
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Tạo liên kết cho mỗi sự kiện, trỏ đến trang submit_contribution.php và truyền event_id bằng query string
                        echo "<li><a href='submit_contribution.php?event_id={$row['event_id']}'>{$row['event_name']} <br> 
                        Submission period: {$row['submission_start_date']} to {$row['submission_end_date']}</a></li>";
                    }
                } else {
                    echo "<li>No events found for your faculty.</li>";
                }
            ?>
        </ul>
    </main>
</body>
</html>

<?php
mysqli_close($conn);
?>
