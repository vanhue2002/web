<?php
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASM4 - Login</title>
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <header>
    <h1>ASM4 - Login</h1>
  </header>
  <main>
    <div class="container">
      <h2>Login</h2>
      <?php
        // Show any error messages if login fails
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
  </main>
</body>
</html>
