    <?php
    require_once('../login/header.php');
    require_once('../config.php');

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
        <style>
            body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
  min-height: 100vh; /* new */
  display: flex; /* new */
  flex-direction: column; /* new */
}

form {
  flex:1;
  max-width: 80%;
  margin: 0 auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  background-color: #fff; /* Thêm màu nền với độ trong suốt */
}

h2 {
  text-align: center;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="file"],
textarea {
  width: 100%;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input[type="checkbox"] {
  margin-right: 5px;
}

button {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
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
        <script>
            // Hàm hiển thị thông báo
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
            <!-- Sử dụng biến faculty_id đã được kiểm tra -->
            <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
            <button type="submit">Nộp đóng góp</button>
        </form>
        <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
    </body>
    </html>

