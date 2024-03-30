<!-- register_admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Admin</title>
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
            <option value="student">Student</option>
            <option value="Marketing Coordinator">Marketing Coordinator</option>       
        </select><br><br>
        <label for="faculty_name">Chọn khoa:</label>
    <select name="faculty_name" id="faculty_name">
        <?php
        // Kết nối database
        require_once('../config.php');

        // Truy vấn để lấy danh sách các khoa
        $query = "SELECT * FROM faculties";
        $result = mysqli_query($conn, $query);

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
