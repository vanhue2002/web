<?php  
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASM4 - Annual School Magazine</title>
  <style>
    body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}
      header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f0f0f0;
            margin-bottom:60px
        }
        main {
  display: flex;
  justify-content: center;
  align-items: center;
}

.container {
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  border-radius: 10px;
  background-color: #fff;
  text-align: center;
}

.container h2 {
  margin-bottom: 10px;
}

.container p {
  margin-bottom: 20px;
}

.container a {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.container a:hover {
  background-color: #0056b3;
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
