<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Sự Kiện</title>
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
</head>
<body>
    <div class="container">
    <form action="create_event_process.php" method="POST">
    <h2>Tạo Sự Kiện Mới</h2>

        <label for="event_name">Tên Sự Kiện:</label><br>
        <input type="text" id="event_name" name="event_name" required ><br><br>

        <label for="start_date">Ngày Bắt Đầu:</label><br>
        <input type="date" id="start_date" name="start_date"required ><br><br>

        <label for="end_date">Ngày Kết Thúc:</label><br>
        <input type="date" id="end_date" name="end_date" required><br><br>

        <label for="faculty_name">Khoa:</label><br>
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

        <input type="submit" value="Tạo Sự Kiện">
    </form>
    </div>
</body>
</html>
