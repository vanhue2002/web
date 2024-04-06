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
    <style>
        /* register_admin.css */
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Quicksand', sans-serif;
        }

        body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(to bottom, #000, #0f0, #000);
        background-size: 100% 200%; /* Kích thước của gradient là 100% chiều ngang và 200% chiều dọc */
        animation: animateBackground 5s linear infinite;
        }

        @keyframes animateBackground {
            0% {
                background-position: 0% 0%; /* Bắt đầu từ vị trí trên cùng */
            }
            100% {
                background-position: 0% 100%; /* Di chuyển đến vị trí dưới cùng */
            }
        }

        h2 {
        font-size: 2em;
        color: #0f0;
        text-transform: uppercase;
        padding: 40px;
        }

        form {
        width: 400px;
        background: #222;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 40px;
        border-radius: 4px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.9);
        }

        form label {
        color: #fff;
        font-size: 1.2em;
        margin-bottom: 10px;
        }

        form input[type="username"],
        form input[type="password"],
        form input[type="email"],
        form select {
        width: 100%;
        background: #333;
        border: none;
        outline: none;
        padding: 15px 10px;
        border-radius: 4px;
        color: #fff;
        font-weight: 500;
        font-size: 1em;
        margin-bottom: 20px;
        }

        form select {
        cursor: pointer;
        }

        form button {
        padding: 10px;
        background: #0f0;
        color: #000;
        font-weight: 600;
        font-size: 1.2em;
        letter-spacing: 0.05em;
        cursor: pointer;
        border: none;
        outline: none;
        border-radius: 4px;
        }

        form button:active {
        opacity: 0.6;
        }

    </style>

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
