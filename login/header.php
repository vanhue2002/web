<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <!-- Add your CSS links here -->
    <style>
        .topnav {
  background-color: #333;
  overflow: hidden;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #04AA6D;
  color: white;
}
    </style>
</head>
<body>
    <header>
        <h1>Your Website Header</h1>
        <div class="topnav">
        <a class="active" href="#home">Home</a>
            <a href="../admin/create_event.php">Admin Dashboard</a>
            <a href="#contact">Contact</a>
            <a href="#about">About</a>
            <?php if(isset($_SESSION['username'])): ?>
                <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
                <a href="../login/logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </header>
    <!-- Other content of your website -->
