<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/view_faculty.css">
    <style>
          

    </style>
</head>
<body>
    <main>
    <?php
require_once('../config.php');

if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    $query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "ID: " . $row['faculty_id'] . "<br>";
        echo "Faculty Name: " . $row['faculty_name'] . "<br>";
    } else {
        echo "Faculty doesn't exist.";
    }
} else {
    echo "Faculty ID not provided.";
}

mysqli_close($conn);
?>
    </main>

 <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>