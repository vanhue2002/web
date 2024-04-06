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
    <link rel="stylesheet" href="./css/index.css">
    <style>
      
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