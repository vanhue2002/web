<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Sự Kiện</title>
</head>
<body>
    <h2>Tạo Sự Kiện Mới</h2>
    <form action="create_event_process.php" method="POST">
        <label for="event_name">Tên Sự Kiện:</label><br>
        <input type="text" id="event_name" name="event_name" ><br><br>

        <label for="start_date">Ngày Bắt Đầu:</label><br>
        <input type="date" id="start_date" name="start_date" ><br><br>

        <label for="end_date">Ngày Kết Thúc:</label><br>
        <input type="date" id="end_date" name="end_date" ><br><br>

        <label for="faculty_name">Khoa:</label><br>
        <select id="faculty_name" name="faculty_name">
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
</body>
</html>
