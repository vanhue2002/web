<?php
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASM4 - Login</title>
  <link rel="stylesheet" href="./css/login.css">
</head>
<body>
 
  <div id="handmaid" class="book">
    <div class="gloss"></div>
    <img class="cover" src="https://raw.githubusercontent.com/robole/artifice/main/shiny-book-reveal/img/cover.png">
    <div class="description">
      <h1>Login</h1>
   <div>
   <?php
          if (isset($_GET['error'])) {
            echo "<p class='error'>Invalid username or password.</p>";
          }
        ?>
        <form action="login_process.php" method="post">
          <label for="username">Username:</label>
          <input type="text" name="username" id="username" required>
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required>
          <button type="submit">Login</button>
        </form>
   </div>
      
    </div>
   
  </div>
  <h1>University Magazine</h1>
  <div class="rating">
    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
  </div>
  <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
