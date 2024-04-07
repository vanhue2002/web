<?php
// Kết nối database
require_once('../config.php');
require_once('authentication.php');
require_once('header.php');

// Kiểm tra xem có tham số event_id được truyền vào không
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Kiểm tra xem có dữ liệu được gửi từ biểu mẫu hay không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu và làm sạch dữ liệu
        $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
        $submission_start_date = $_POST['submission_start_date'];
        $submission_end_date = $_POST['submission_end_date'];
        $faculty_name = $_POST['faculty_name'];

        // Truy vấn SQL để cập nhật thông tin sự kiện
        $query = "UPDATE events SET event_name = '$event_name', submission_start_date = '$submission_start_date', submission_end_date = '$submission_end_date', faculty_name = '$faculty_name' WHERE event_id = $event_id";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('The event has been updated successfully!'); window.history.back();</script>";
        } else {
            echo "<script>alert('An error occurred while updating the event: '); window.history.back();</script>" . mysqli_error($conn);
        }
    }

    // Truy vấn để lấy thông tin của sự kiện dựa trên event_id
    $event_query = "SELECT * FROM events WHERE event_id = $event_id";
    $event_result = mysqli_query($conn, $event_query);

    // Hiển thị biểu mẫu để cập nhật thông tin sự kiện
    if (mysqli_num_rows($event_result) == 1) {
        $row = mysqli_fetch_assoc($event_result);
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cập Nhật Sự Kiện</title>
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
                <!-- Đây là một ví dụ đơn giản, bạn có thể sử dụng các phương thức khác để lấy danh sách khoa từ cơ sở dữ liệu -->
                <select id="faculty_name" name="faculty_name">
                    <?php
                        // Truy vấn để lấy danh sách các khoa
                        $query = "SELECT * FROM faculties";
                        $result = mysqli_query($conn, $query);

                        // Hiển thị các tùy chọn cho khoa
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

// Đóng kết nối database
mysqli_close($conn);
?>

