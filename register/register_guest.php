<!-- register_guest.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Khách hàng</title>
    <style>
       
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to bottom, #000, #0f0, #000);
            background-size: 100% 200%; 
            animation: animateBackground 5s linear infinite;
        }

        @keyframes animateBackground {
            0% {
                background-position: 0% 0%; 
            }
            100% {
                background-position: 0% 100%; 
            }
        }

        h2 {
            font-size: 2em;
            color: #0f0;
            text-transform: uppercase;
            text-align: center;
            padding: 40px;
        }

        form {
            width: 400px;
            background: #222;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.9);
            flex-direction: column; 
        }

        form label {
            color: #fff;
            margin-bottom: 10px; 

        form input[type="text"],
        form input[type="password"],
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
            appearance: none;
        }

        form button[type="submit"] {
            padding: 10px;
            background: #0f0;
            color: #000;
            font-weight: 600;
            font-size: 1.35em;
            letter-spacing: 0.05em;
            cursor: pointer;
        }

        form button[type="submit"]:active {
            opacity: 0.6;
        }
    </style>
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
            require_once('../config.php');
            $query = "SELECT * FROM faculties";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['faculty_name'] . "'>" . $row['faculty_name'] . "</option>";
            }

            mysqli_close($conn);
            ?>
        </select><br><br>
        <button type="submit">Đăng ký</button>
    </form>

    

    
</body>
</html>
