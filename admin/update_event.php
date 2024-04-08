<?php
require_once('../config.php');
require_once('authentication.php');
include '../header.php';


if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $submission_start_date = $_POST['submission_start_date'];
        $submission_end_date = $_POST['submission_end_date'];
        $faculty_name = $_POST['faculty_name'];

        $query = "UPDATE events SET event_name = '$event_name', submission_start_date = '$submission_start_date', submission_end_date = '$submission_end_date', faculty_name = '$faculty_name' WHERE event_id = $event_id";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('The event has been updated successfully!'); window.history.back();</script>";
        } else {
            echo "<script>alert('An error occurred while updating the event: '); window.history.back();</script>" . mysqli_error($conn);
        }
    }

    $event_query = "SELECT * FROM events WHERE event_id = $event_id";
    $event_result = mysqli_query($conn, $event_query);

    if (mysqli_num_rows($event_result) == 1) {
        $row = mysqli_fetch_assoc($event_result);
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cập Nhật Sự Kiện</title>
            <link rel="stylesheet" href="./css/style.css">
            <style>
                

        section .signin .container h2 {
  font-size: 2em;
  color: #0f0;
  text-transform: uppercase;
  
}

section .signin .container form label {
  color: #fff;
}

section .signin .container form input[type="text"],
section .signin .container form input[type="date"],
section .signin .container form select {
  width: 100%;
  background: #333;
  border: none;
  outline: none;
  padding: 15px 10px;
  border-radius: 4px;
  color: #fff;
  font-weight: 500;
  font-size: 1em;
  text-align: center;
}

section .signin .container form input[type="submit"] {
  padding: 10px;
  background: #0f0;
  color: #000;
  font-weight: 600;
  font-size: 1.35em;
  letter-spacing: 0.05em;
  cursor: pointer;
}
section .signin .container form {
  text-align: center;
}
input[type="submit"]:active {
  opacity: 0.6;
}
            </style>
        </head>
        <body>
            <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
            <div class="signin">
        <div class="container">
            <h2>UPDATE EVENT</h2><br>
            <form method="post">
                <label for="event_name">Event name:</label><br>
                <input type="text" id="event_name" name="event_name" value="<?php echo $row['event_name']; ?>"><br><br>
                <label for="submission_start_date">Start date:</label><br>
                <input type="date" id="submission_start_date" name="submission_start_date" value="<?php echo $row['submission_start_date']; ?>"><br><br>
                <label for="submission_end_date">End date:</label><br>
                <input type="date" id="submission_end_date" name="submission_end_date" value="<?php echo $row['submission_end_date']; ?>"><br><br>
                <label for="faculty_name">Faculty:</label><br>
                <select id="faculty_name" name="faculty_name">
                    <?php
                        $query = "SELECT * FROM faculties";
                        $result = mysqli_query($conn, $query);

                        while ($faculty_row = mysqli_fetch_assoc($result)) {
                            $selected = ($faculty_row['faculty_name'] == $row['faculty_name']) ? 'selected' : '';
                            echo "<option value='" . $faculty_row['faculty_name'] . "' $selected>" . $faculty_row['faculty_name'] . "</option>";
                        }
                    ?>
                </select><br><br>
                <input type="submit" value="Update">
            </form>
        </div>
        </div>
        </section>
        </body>
        </html>
<?php
    } else {
        echo "Event does not exist.";
    }
} else {
    echo "Event ID not provided.";
}

mysqli_close($conn);
?>

