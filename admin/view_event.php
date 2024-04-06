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
    <link rel="stylesheet" href="./css/view_event.css">
    <style>
          
    </style>
</head>
<body>
<main>
<?php
require_once('../config.php');

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $query = "SELECT events.*, faculties.faculty_name 
              FROM events 
              LEFT JOIN faculties ON events.faculty_name = faculties.faculty_name 
              WHERE event_id = $event_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "ID: " . $row['event_id'] . "<br>";
        echo "Event Name: " . $row['event_name'] . "<br>";
        echo "Start Date: " . $row['submission_start_date'] . "<br>";
        echo "Deadline: " . $row['submission_end_date'] . "<br>";
        echo "Faculty: " . $row['faculty_name'] . "<br>";
    } else {
        echo "Event doesn't exist.";
    }
} else {
    echo "Event ID not provided.";
}

mysqli_close($conn);
?>
</main>
 <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>