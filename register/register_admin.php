<!-- register_admin.php -->
<?php
// Kết nối database
require_once('../config.php');
require_once('authentication.php');

// Truy vấn SQL để lấy danh sách các role
$query_roles = "SELECT DISTINCT role FROM users WHERE role <> 'admin'";
$result_roles = mysqli_query($conn, $query_roles);

// Truy vấn để lấy danh sách các khoa
$query = "SELECT * FROM faculties";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h2>Đăng ký tài khoản cho Admin</h2>
    <form action="register_admin_process.php" method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="username" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="role">Vai trò:</label>
        <select name="role" id="role">
            <?php
            // Đổ dữ liệu từ kết quả truy vấn vào danh sách dropdown
            while ($row = mysqli_fetch_assoc($result_roles)) {
                echo "<option value='" . $row['role'] . "'>" . $row['role'] . "</option>";
            }
            ?>
        </select><br><br>
        <label for="faculty_name">Chọn khoa:</label>
        <select name="faculty_name" id="faculty_name">
            <?php
            

            // Hiển thị các tùy chọn cho khoa
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['faculty_name'] . "'>" . $row['faculty_name'] . "</option>";
            }

            // Đóng kết nối database
            mysqli_close($conn);
            ?>
        </select><br><br>
        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
