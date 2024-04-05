<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <style>
       
body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #f0f0f0;
  margin-bottom:60px;
}
.container {
    display: flex;
    justify-content: center;
    align-items: center;
}

form {
    padding: 25px;
    border: 1px solid #ccc;
    box-shadow: 4px 4px 5px rgba(0,0,0,0.2);
    width: 60%;
    background: white;
}

form input[type="text"], form input[type="date"], form select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
}

form input[type="submit"] {
    background-color: #7986CB;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
  
</style>
    </style>
</head>
<body>
<?php
require_once('../config.php');

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $submission_start_date = $_POST['submission_start_date'];
        $submission_end_date = $_POST['submission_end_date'];
        $faculty_name = $_POST['faculty_name'];

        $query = "UPDATE events SET event_name = '$event_name', submission_start_date = '$submission_start_date', submission_end_date = '$submission_end_date', faculty_name = '$faculty_name' WHERE event_id = $event_id";

        if (mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'>alert('Event edited successfully!'); window.location.href='./manage_event.php';</script>";
        } else {
            echo "Error occurred while updating event: " . mysqli_error($conn);
        }
    }

    $event_query = "SELECT * FROM events WHERE event_id = $event_id";
    $event_result = mysqli_query($conn, $event_query);

    if (mysqli_num_rows($event_result) == 1) {
        $row = mysqli_fetch_assoc($event_result);
?>
        
          
           <div class="container">
    
           <form method="post">
           <h2>Edit Event</h2>
                <label for="event_name">Event Name:</label><br>
                <input type="text" id="event_name" name="event_name" value="<?php echo $row['event_name']; ?>"><br>
                <label for="submission_start_date">Start Date:</label><br>
                <input type="date" id="submission_start_date" name="submission_start_date" value="<?php echo $row['submission_start_date']; ?>"><br>
                <label for="submission_end_date">Deadline:</label><br>
                <input type="date" id="submission_end_date" name="submission_end_date" value="<?php echo $row['submission_end_date']; ?>"><br>
                <label for="faculty_name">Faculty:</label><br>
                <select id="faculty_name" name="faculty_name">
                    <?php
                        $query = "SELECT * FROM faculties";
                        $result = mysqli_query($conn, $query);

                        // Hiển thị các tùy chọn cho khoa
                        while ($faculty_row = mysqli_fetch_assoc($result)) {
                            $selected = ($faculty_row['faculty_name'] == $row['faculty_name']) ? 'selected' : '';
                            echo "<option value='" . $faculty_row['faculty_name'] . "' $selected>" . $faculty_row['faculty_name'] . "</option>";
                        }
                    ?>
                </select><br><br>
                <input type="submit" value="Edit">
            </form>
           </div>
                        
<?php
    } else {
        echo "Event doesn't exist.";
    }
} else {
    echo "Event ID is not provided.";
}

mysqli_close($conn);
?>

</body>
</html>