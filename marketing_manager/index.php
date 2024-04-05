<?php  
require_once('../login/header.php');
require_once('authentication.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing Manager</title>
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
}body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
  margin: 0;
  padding: 0;
}

  .content {
    display: flex;
    justify-content: center; 
    align-items: center;
    flex-direction: column;
    margin-bottom: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding-bottom: 50px;


  }

  .content div {
    width: 60%;
    padding: 20px;
    border-radius: 50px;
    margin-bottom: 20px;
    text-align: center;
    background-color: #007bff;
  }

  .content div a {
    text-decoration: none;
    color: #fff;
    font-size: 60px;
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
      <a href="view_contribution.php">Student Contributions</a>

      </div>
    </div>

    <div class="content">
      <div>
      <a href="statistics.html">Statistics</a>

      </div>
    </div>
    </div>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>


</body>
</html>