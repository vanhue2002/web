<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<?php
// Kết nối database
require_once('../config.php');

// Kiểm tra xem có tham số faculty_id được truyền vào không
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Kiểm tra xem có dữ liệu được gửi từ biểu mẫu hay không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu và làm sạch dữ liệu
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        // Truy vấn SQL để cập nhật thông tin khoa
        $query = "UPDATE faculties SET faculty_name = '$faculty_name' WHERE faculty_id = $faculty_id";

        if (mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'>alert('Faculty edited successfully!'); window.location.href='./manage_faculty.php';</script>";
         
        } else {
            echo "Error occurred while updating faculty: " . mysqli_error($conn);
        }
    }

    // Truy vấn để lấy thông tin của khoa dựa trên faculty_id
    $faculty_query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $faculty_result = mysqli_query($conn, $faculty_query);

    // Hiển thị biểu mẫu để cập nhật thông tin khoa
    if (mysqli_num_rows($faculty_result) == 1) {
        $row = mysqli_fetch_assoc($faculty_result);
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Faculty</title>
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
            <h2>Edit Faculty</h2>
            <div class="container">
            <form method="post">
                <label for="faculty_name">Tên Khoa:</label><br>
                <input type="text" id="faculty_name" name="faculty_name" value="<?php echo $row['faculty_name']; ?>"><br><br>
                <input type="submit" value="Cập Nhật">
            </form>
            </div>
        </body>
        </html>
<?php
    } else {
        echo "Khoa không tồn tại.";
    }
} else {
    echo "ID khoa không được cung cấp.";
}

// Đóng kết nối database
mysqli_close($conn);
?>
