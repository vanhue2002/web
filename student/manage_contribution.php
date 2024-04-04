<?php
session_start();
require_once('../config.php');
require_once('../login/header.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy user_id của sinh viên từ session
$user_id = $_SESSION['user_id'];

// Truy vấn để lấy các đóng góp của sinh viên
$sql = "SELECT * FROM contributions WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contributions</title>
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
    margin: 20px auto; /* Căn giữa nội dung */
    max-width: 800px; /* Đặt chiều rộng tối đa của phần chính */
    padding: 20px; /* Thêm padding */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Thêm box shadow */

    background-color: #fff;
}

table {
    width: 100%; /* Đặt chiều rộng của bảng là 100% */
    border-collapse: collapse; /* Loại bỏ khoảng cách giữa các ô */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Thêm box shadow */
}

table th,
table td {
    padding: 10px; /* Thêm padding cho ô */
    border: 1px solid #ccc; /* Đặt viền cho ô */
    text-align: left; /* Căn lề văn bản sang trái */
}

table th {
    background-color: #f0f0f0; /* Đặt màu nền cho hàng tiêu đề */
}

table td img {
    max-width: 100px; /* Đặt chiều rộng tối đa cho hình ảnh */
    max-height: 100px; /* Đặt chiều cao tối đa cho hình ảnh */
}

footer {
  position: fixed; /* Đặt vị trí của footer */
  bottom: 0; /* Đặt ở dưới cùng */
  width: 100%; /* Chiều rộng tương đương với phần nội dung */
  background-color: #343a40;
  color: #fff;
  text-align: center;
}


    </style>
    <!-- Add your CSS links here -->
</head>
<body>
  
    <main>
        <h2>Quản lý contribution</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Title</th><th>Content</th><th>File/Image</th><th>Status</th><th>Actions</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['content']}</td>";
                echo "<td>";
                // Kiểm tra loại tệp tin
                $file_path = $row['file_path'];
                if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                    // Nếu là file zip, hiển thị tên file và tạo liên kết tải xuống
                    echo "<a href='$file_path' download>" . basename($file_path) . "</a>";
                } else {
                    // Nếu là hình ảnh, hiển thị hình ảnh
                    echo "<img src='$file_path' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'>";
                }
                echo "</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td><a href='update_contribution.php?contribution_id={$row['contribution_id']}'>Edit</a> | <a href='delete_contribution.php?contribution_id={$row['contribution_id']}'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No contributions found.</p>";
        }
        ?>
    </main>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
