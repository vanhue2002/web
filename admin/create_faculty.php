<?php
require_once('../login/header.php');

require_once('authentication.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Khoa Mới</title>
    <link rel="stylesheet" href="./css/create_faculty.css">
</head>
<body>
    <h2>Tạo Khoa Mới</h2>
    <form action="create_faculty_process.php" method="POST">
        <label for="faculty_name">Tên Khoa:</label><br>
        <input type="text" id="faculty_name" name="faculty_name"><br><br>

        <input type="submit" value="Tạo Khoa">
    </form>
</body>
</html>
