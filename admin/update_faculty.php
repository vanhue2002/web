<?php
require_once('../config.php');
require_once('authentication.php');
include '../header.php';


if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        mysqli_begin_transaction($conn);

        $query = "UPDATE faculties SET faculty_name = '$faculty_name' WHERE faculty_id = $faculty_id";

        if (mysqli_query($conn, $query)) {
            $update_events_query = "UPDATE events SET faculty_name = '$faculty_name' WHERE faculty_name = (SELECT faculty_name FROM faculties WHERE faculty_id = $faculty_id)";
            mysqli_query($conn, $update_events_query);

            $update_users_query = "UPDATE users SET faculty_name = '$faculty_name' WHERE faculty_name = (SELECT faculty_name FROM faculties WHERE faculty_id = $faculty_id)";
            mysqli_query($conn, $update_users_query);

            mysqli_commit($conn);
            echo "<script>alert('The faculty has been updated successfully!'); window.history.back();</script>";
        } else {
            mysqli_rollback($conn);
            echo "<script>alert('An error occurred while updating the faculty: '); window.history.back();</script>" . mysqli_error($conn);
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
            <title>Cập Nhật Khoa</title>
        </head>
        <body>
            <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 
            <div class="signin">
        <div class="container">
            <h2>UPDATE FACULTY</h2>
            <form method="post">
                <label for="faculty_name">Faculty name:</label><br>
                <input type="text" id="faculty_name" name="faculty_name" value="<?php echo $row['faculty_name']; ?>"><br><br>
                <input type="submit" value="Update">
            </form>
        </div>
        </div>
        </section>
        </body>
        </html>
<?php
    } else {
        echo "Faculty does not exist.";
    }
} else {
    echo "Faculty ID not provided.";
}

mysqli_close($conn);
?>

