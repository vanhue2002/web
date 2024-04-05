<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title> 
    <style>
       body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}
.content {
  padding: 20px;
  background-color: #fff;
    display: flex;
    justify-content: center; /* căn giữa nội dung */
    align-items: center; /* căn giữa nội dung theo chiều dọc */
    flex-direction: column; /* hiển thị mỗi hàng là một nội dung */
    margin-bottom: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  .content div {
    width: 60%;
    border-radius: 50px;
    text-align: center;
    background-color: #007bff;
  }

  .content div a {
    text-decoration: none;
    color: #fff;
    font-size: 60px;
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
</head>

<body>

<div>
    <div class="content">
      <div>
      <a href="manage_event.php">Manage Events</a>
      </div>
    </div>

    <div class="content">
      <div>
      <a href="create_faculty.php">Create Faculties</a>
      </div>
    </div>
    <div class="content">
        <div>
        <a href="create_event.php">Create Events</a>
        </div>
    </div>
    <div class="content">
      <div>
      <a href="manage_faculty.php">Manage Faculties</a>

      </div>
    </div>
    </div>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>

</body>
</html>