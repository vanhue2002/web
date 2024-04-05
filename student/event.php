<?php
require_once('../config.php');
require_once('../login/header.php');
require_once('authentication.php');

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy user_id của sinh viên từ session
$user_id = $_SESSION['user_id'];

// Truy vấn để lấy các sự kiện cho khoa của sinh viên
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
    <!-- Add your CSS links here -->
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    </header>
    <main>
        <h2>Events for Your Faculty</h2>
        <ul>
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Tạo liên kết cho mỗi sự kiện, trỏ đến trang submit_contribution.php và truyền event_id bằng query string
                        echo "<li><a href='submit_contribution.php?event_id={$row['event_id']}'>{$row['event_name']} - Submission period: {$row['submission_start_date']} to {$row['submission_end_date']}</a></li>";
                    }
                } else {
                    echo "<li>No events found for your faculty.</li>";
                }
            ?>
        </ul>
    </main>
</body>
</html>

<?php
mysqli_close($conn);
?>
