<?php  
require_once('../login/header.php');
require_once('authentication.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="./css/index.css">
    <style>
   body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
  min-height: 100vh; 
  display: flex; 
  flex-direction: column;
}
.content {
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
  margin-bottom: 20px; 
  background-color: #fff;
}
footer {
  position: fixed;
  bottom: 0;
  width: 100%;
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
        <a href="event.php">Events</a>
      </div>
    </div>

    <div class="content">
      <div>
        <a href="manage_contribution.php">Contributions</a>
      </div>
    </div>
    </div>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>