<?php
session_start();
require_once('../config.php');
require_once('../login/header.php');


// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Kiểm tra xem contribution_id đã được truyền qua query string không
if (!isset($_GET['contribution_id'])) {
    echo "Contribution ID không hợp lệ.";
    exit();
}

// Lấy contribution_id từ query string
$contribution_id = $_GET['contribution_id'];

// Truy vấn để lấy thông tin về contribution dựa trên contribution_id
$sql = "SELECT * FROM contributions WHERE contribution_id = '$contribution_id'";
$result = mysqli_query($conn, $sql);

// Kiểm tra xem contribution có tồn tại không
if (mysqli_num_rows($result) == 0) {
    echo "Không tìm thấy đóng góp.";
    exit();
}

// Lấy thông tin về contribution
$row = mysqli_fetch_assoc($result);
$title = $row['title'];
$content = $row['content'];
$file_path = $row['file_path'];

// Kiểm tra quyền truy cập: chỉ cho phép cập nhật nếu user_id của contribution giống với user_id của người đăng nhập
if ($_SESSION['user_id'] != $row['user_id']) {
    echo "Bạn không có quyền truy cập vào đóng góp này.";
    exit();
}

// Xử lý form cập nhật contribution
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $new_title = $_POST['title'];
    $new_content = $_POST['content'];
    $file_changed = false;

    // Kiểm tra xem có tệp mới được tải lên không
    if ($_FILES["file"]["size"] > 0) {
        // Xóa tệp cũ
        unlink($file_path);
        // Tạo tên tệp mới
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra kích thước của tệp và các định dạng hợp lệ
        if ($_FILES["file"]["size"] > 5000000) {
            echo "Tệp quá lớn.";
            $uploadOk = 0;
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Chỉ chấp nhận các tệp JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Có lỗi xảy ra khi tải lên.";
        } else {
            // Di chuyển tệp mới vào thư mục uploads
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $file_path = $target_file;
                $file_changed = true;
                echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được tải lên thành công.";
            } else {
                echo "Có lỗi xảy ra khi tải lên.";
            }
        }
    }

    // Cập nhật contribution trong cơ sở dữ liệu
    $update_sql = "UPDATE contributions SET title = '$new_title', content = '$new_content'";
    if ($file_changed) {
        $update_sql .= ", file_path = '$file_path'";
    }
    $update_sql .= ", updated_at = NOW() WHERE contribution_id = '$contribution_id'";
    if (mysqli_query($conn, $update_sql)) {
      echo "<script type='text/javascript'>alert('Contribution cập nhật thành công!'); window.location.href='./manage_contribution.php';</script>";

    } else {
        echo "Lỗi: " . $update_sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật đóng góp</title>
    <style>
           body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}

form {
  max-width: 80%;
  margin: 0 auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  background-color: rgba(255, 255, 255, 0.9); /* Thêm màu nền với độ trong suốt */
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
</head>
<body>
    <h2>Cập nhật đóng góp</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?contribution_id=' . $contribution_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Tiêu đề:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required><br><br>
        <label for="content">Nội dung:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required><?php echo $content; ?></textarea><br><br>
        <label for="file">Tệp đính kèm:</label><br>
        <input type="file" id="file" name="file" accept="image/*"><br><br>
        <button type="submit">Cập nhật</button>
    </form>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
