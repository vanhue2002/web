<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="container">
        <a href="manage_event.php">Manage Events</a>
        <br>
        <a href="create_faculty.php">Create Faculties</a>
        <br>
        <a href="create_event.php">Create Events</a>
        <br>
        <a href="manage_faculty.php">Manage Faculty</a>
        <br>
        <a href="../register/register_admin_process.php">Register</a>
    </div>
</body>
</html>
