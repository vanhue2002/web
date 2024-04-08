<?php


require_once('authentication.php');
include '../header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create event</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>


        section .signin .container h2 {
  font-size: 2em;
  color: #0f0;
  text-transform: uppercase;
  
}

/* CSS cho thẻ label */
section .signin .container form label {
  color: #fff;
}

/* CSS cho các trường nhập liệu input và select */
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

/* CSS cho nút gửi dữ liệu input[type="submit"] */
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
/* CSS cho nền của input[type="submit"] khi được nhấn */
input[type="submit"]:active {
  opacity: 0.6;
}
    </style>

    <link rel="stylesheet" href="./css/create_event.css">

</head>
<body>
    <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 
    <div class="signin">
<div class="container">
    <h2>CREATE NEW EVENT</h2>
    <form action="create_event_process.php" method="POST">
        <label for="event_name">Event name:</label>
        <input type="text" id="event_name" name="event_name" required >

        <label for="start_date">Start date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <label for="faculty_name">Faculty:</label>
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
        </select>

        <input type="submit" value="Create">
    </form>
</div>
</div>
</section>
</body>
</html>
