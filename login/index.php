<?php  
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASM4 - Annual School Magazine</title>
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <header>
    <h1>ASM4 - Annual School Magazine</h1>
  </header>
  <main>
    <div class="container">
      <h2>Welcome!</h2>
      <p>Please log in to access the ASM4 system.</p>
      <a href="login.php">Login</a>
    </div>
  </main>
  <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
