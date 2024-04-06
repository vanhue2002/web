    <?php
    require_once('../login/header.php');
    require_once('../config.php');

    $faculty_id = isset($_SESSION['selected_faculty_id']) ? $_SESSION['selected_faculty_id'] : '';

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
        <link rel="stylesheet" href="./css/submit_contribution.css">
        <style>
           

        </style>
        <script>
            function showNotification() {
                alert("Email đã được gửi đi thành công!");
            }
        </script>
    </head>
    <body>
    
        <form action="submit_contribution_process.php" method="POST" enctype="multipart/form-data">
        <h2>Nộp đóng góp</h2>    
        <label for="title">Tiêu đề:</label><br>
            <input type="text" id="title" name="title" required><br><br>
            <label for="contribution">Đóng góp:</label><br>
            <textarea id="contribution" name="contribution" rows="4" cols="50" required></textarea><br><br>
            <label for="file">Hình ảnh hoặc tệp đính kèm:</label><br>
            <input type="file" id="file" name="file" accept="image/*,.zip" ><br><br>
            <label for="agree">Tôi đồng ý với <a href="#">Điều khoản và Điều kiện</a>:     
                <input type="checkbox" id="agree" name="agree" required></label>
    <br><br>
            <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
            <button type="submit">Nộp đóng góp</button>
        </form>
        <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
    </body>
    </html>

