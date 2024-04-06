<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<?php
require_once('../config.php');

if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        $query = "UPDATE faculties SET faculty_name = '$faculty_name' WHERE faculty_id = $faculty_id";

        if (mysqli_query($conn, $query)) {
         
        } else {
            echo "Error occurred while updating faculty: " . mysqli_error($conn);
        }
    }

    $faculty_query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $faculty_result = mysqli_query($conn, $faculty_query);

    if (mysqli_num_rows($faculty_result) == 1) {
        $row = mysqli_fetch_assoc($faculty_result);
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Faculty</title>
            <link rel="stylesheet" href="./css/update_faculty.css">
            <style>
               
            </style>
        </head>
        <body>
            <h2>Edit Faculty</h2>
            <div class="container">
            <form method="post">
                <label for="faculty_name">Tên Khoa:</label><br>
                <input type="text" id="faculty_name" name="faculty_name" value="<?php echo $row['faculty_name']; ?>"><br><br>
                <input type="submit" value="Cập Nhật">
            </form>
            </div>
        </body>
        </html>
<?php
    } else {
        echo "Khoa không tồn tại.";
    }
} else {
    echo "ID khoa không được cung cấp.";
}

mysqli_close($conn);
?>
