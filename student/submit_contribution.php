<?php
require_once('../login/header.php');
require_once('../config.php');
require_once('authentication.php');

// Kiểm tra xem biến session đã tồn tại và có giá trị không
$faculty_id = isset($_SESSION['selected_faculty_id']) ? $_SESSION['selected_faculty_id'] : '';

// Lấy event_id từ query string nếu có
if(isset($_GET['event_id'])) {
    $_SESSION['selected_event_id'] = $_GET['event_id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp đóng góp</title>
</head>
<body>
    <h2>Nộp đóng góp</h2>
    <form action="submit_contribution_process.php" method="POST" enctype="multipart/form-data">
        <label for="title">Tiêu đề:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        <label for="contribution">Đóng góp:</label><br>
        <textarea id="contribution" name="contribution" rows="4" cols="50" required></textarea><br><br>
        <label for="file">Hình ảnh hoặc tệp đính kèm:</label><br>
        <input type="file" id="file" name="file[]" accept="image/*,.zip" multiple><br><br>
        <label for="agree">Tôi đồng ý với <a href="#">Điều khoản và Điều kiện</a>:</label>
        <input type="checkbox" id="agree" name="agree" required><br><br>
        <!-- Sử dụng biến faculty_id đã được kiểm tra -->
        <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
        <button type="submit" onclick="showNotification()">Nộp đóng góp</button>
    </form>
</body>
</html>

