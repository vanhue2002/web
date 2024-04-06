<?php
require_once('../login/header.php');
?>
<!-- register_admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Admin</title>
    <link rel="stylesheet" href="../../login/css/login.css">
    <link rel="stylesheet" href="./css/register_admin.css">

<style>
  
</style>
</head>
<body>
<div id="handmaid" class="book">
    <div class="gloss"></div>
    <img class="cover" src="https://raw.githubusercontent.com/robole/artifice/main/shiny-book-reveal/img/cover.png">
    <div class="description">
    <h1>Đăng ký tài khoản cho Admin</h1>
    
   <div>
   
    
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
    </div>
       
    </div>
   
  </div>
  <h1>The Handmaid's Tale</h1>
        <div class="rating">
    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
  </div>
   <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
