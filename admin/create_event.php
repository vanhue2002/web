<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="./css/create_event.css">
    <style>
       
    </style>
</head>
<body>
    <div class="container">
    <form action="create_event_process.php" method="POST">
    <h2>Create New Event</h2>

        <label for="event_name">Event Name:</label><br>
        <input type="text" id="event_name" name="event_name" required ><br><br>

        <label for="start_date">Start Date:</label><br>
        <input type="date" id="start_date" name="start_date"required ><br><br>

        <label for="end_date">Deadline:</label><br>
        <input type="date" id="end_date" name="end_date" required><br><br>

        <label for="faculty_name">Faculty:</label><br>
        <select id="faculty_name" name="faculty_name" required>
            <?php
                require_once('../config.php');
                $query = "SELECT * FROM faculties";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['faculty_name'] . "'>" . $row['faculty_name'] . "</option>";
                }
                mysqli_close($conn);
            ?>
        </select><br><br>

        <input type="submit" value="Create">
    </form>
    </div>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
