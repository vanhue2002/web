<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Faculty</title>
    <link rel="stylesheet" href="./css/create_faculty.css">
    <style>
        
    </style>

</head>
<body>

    <div class="container">
    <form action="create_faculty_process.php" method="POST">
    <h2>Create New Faculty</h2>
        <label for="faculty_name">Faculty Name:</label><br>
        <input type="text" id="faculty_name" name="faculty_name" required><br><br>

        <input type="submit" value="Create">
    </form></div>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
