<?php
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Admin</title>
    <link rel="stylesheet" href="../../login/css/login.css">
    <link rel="stylesheet" href="./css/register_guest.css">

<style>
   

</style>
</head>
<body>
<div id="handmaid" class="book">
    <div class="gloss"></div>
    <img class="cover" src="https://raw.githubusercontent.com/robole/artifice/main/shiny-book-reveal/img/cover.png">
    <div class="description">
    <h2>Đăng ký tài khoản cho Khách hàng</h2>
    
   <div>
   
    

    <form action="register_guest_process.php" method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
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
