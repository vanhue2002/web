<?php
require_once('../config.php');
require_once('../login/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.event_id, e.event_name, e.submission_start_date, e.submission_end_date
        FROM events e
        INNER JOIN faculties f ON e.faculty_name = f.faculty_name
        INNER JOIN users u ON u.faculty_name = f.faculty_name
        WHERE u.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Index</title>
    <style>

body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
  min-height: 100vh; 
  display: flex; 
  flex-direction: column; 
}
main {
    padding: 20px;
    background-color: #fff;
    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 0 20%; 
}
main ul li {
    color : #fff;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc; 
    border-radius: 5px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    list-style: none;
    background-color: red;
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
        <h2>Events for Your Faculty</h2>
        <ul>
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li><a href='submit_contribution.php?event_id={$row['event_id']}'>{$row['event_name']} <br> 
                        Submission period: {$row['submission_start_date']} to {$row['submission_end_date']}</a></li>";
                    }
                } else {
                    echo "<li>No events found for your faculty.</li>";
                }
            ?>
        </ul>
    </main>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
