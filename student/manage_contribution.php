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
    <!-- Add your CSS links here -->
</head>
<body>
    <header>
        <h1>Manage Your Contributions</h1>
    </header>
    <main>
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
</body>
</html>

<?php
mysqli_close($conn);
?>
