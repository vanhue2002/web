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
        main {
    padding: 20px;
    background-color: #fff;
    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm box-shadow */
    margin: 0 20%; /* Căn giữa với padding 20% ở cả hai bên */
}

     
footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  background-color: #343a40;
  color: #fff;
  text-align: center;
}

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