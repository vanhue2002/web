<!-- register_guest.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Khách hàng</title>
</head>
<body>
    <h2>Đăng ký tài khoản cho Khách hàng</h2>
    <form action="register_guest_process.php" method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="faculty">Khoa:</label>
        <select id="faculty" name="faculty" required>
            <?php
            // Kết nối database và truy vấn danh sách các khoa
            require_once('../config.php');
            $query = "SELECT * FROM faculties";
            $result = mysqli_query($conn, $query);

            // Hiển thị danh sách các khoa trong dropdown menu
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
