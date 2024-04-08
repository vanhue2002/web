<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../config.php');
require_once('authentication.php');
include '../header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['contribution_id'])) {
    echo "Contribution ID không hợp lệ.";
    exit();
}

$contribution_id = $_GET['contribution_id'];

$sql = "SELECT * FROM contributions WHERE contribution_id = '$contribution_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Không tìm thấy đóng góp.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$title = $row['title'];
$content = $row['content'];
$file_path = $row['file_path'];

if ($_SESSION['user_id'] != $row['user_id']) {
    echo "Bạn không có quyền truy cập vào đóng góp này.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_content = $_POST['content'];
    $file_changed = false;

    if (!empty($_FILES['file']['name'][0])) {
        $file_paths = [];
        $target_dir = "uploads/";
        foreach ($_FILES['file']['name'] as $key => $filename) {
            $target_file = $target_dir . basename($filename);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if ($_FILES["file"]["size"][$key] > 5000000) {
                echo "Tệp quá lớn.";
                $uploadOk = 0;
            } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif", "zip"])) {
                echo "Chỉ chấp nhận các tệp JPG, JPEG, PNG, GIF và ZIP.";
                $uploadOk = 0;
            }
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $target_file)) {
                    $file_paths[] = $target_file;
                    $file_changed = true;
                    echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được tải lên thành công.<br>";
                } else {
                    echo "Có lỗi xảy ra khi tải lên.";
                }
            }
        }
        $file_path = implode(',', $file_paths);
    }

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
       @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
*
{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Quicksand', sans-serif;
}
body 
{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #000;
}
section 
{
  position: absolute;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 2px;
  flex-wrap: wrap;
  overflow: hidden;
}
section::before 
{
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(#000,#0f0,#000);
  animation: animate 5s linear infinite;
}
@keyframes animate 
{
  0%
  {
    transform: translateY(-100%);
  }
  100%
  {
    transform: translateY(100%);
  }
}
section span 
{
  position: relative;
  display: block;
  width: calc(6.25vw - 2px);
  height: calc(6.25vw - 2px);
  background: #181818;
  z-index: 2;
  transition: 1.5s;
}
section span:hover 
{
  background: #0f0;
  transition: 0s;
}

section .signin
{
  position: absolute;
  width: 400px;
  background: #222;  
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  border-radius: 4px;
  box-shadow: 0 15px 35px rgba(0,0,0,9);
}
section .signin .content 
{
  position: relative;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 40px;
}
section .signin .content h2 
{
  font-size: 2em;
  color: #0f0;
  text-transform: uppercase;
}
section .signin .content .form 
{
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 25px;
}
section .signin .content .form .inputBox
{
  position: relative;
  width: 100%;
}
section .signin .content .form .inputBox input 
{
  position: relative;
  width: 100%;
  background: #333;
  border: none;
  outline: none;
  padding: 25px 10px 7.5px;
  border-radius: 4px;
  color: #fff;
  font-weight: 500;
  font-size: 1em;
}
section .signin .content .form .inputBox i 
{
  position: absolute;
  left: 0;
  padding: 15px 10px;
  font-style: normal;
  color: #aaa;
  transition: 0.5s;
  pointer-events: none;
}
.signin .content .form .inputBox input:focus ~ i,
.signin .content .form .inputBox input:valid ~ i
{
  transform: translateY(-7.5px);
  font-size: 0.8em;
  color: #fff;
}
.signin .content .form .links 
{
  position: relative;
  width: 100%;
  display: flex;
  justify-content: space-between;
}
.signin .content .form .links a 
{
  color: #fff;
  text-decoration: none;
}
.signin .content .form .links a:nth-child(2)
{
  color: #0f0;
  font-weight: 600;
}
.signin .content .form .inputBox input[type="submit"]
{
  padding: 10px;
  background: #0f0;
  color: #000;
  font-weight: 600;
  font-size: 1.35em;
  letter-spacing: 0.05em;
  cursor: pointer;
}
input[type="submit"]:active
{
  opacity: 0.6;
}
@media (max-width: 900px)
{
  section span 
  {
    width: calc(10vw - 2px);
    height: calc(10vw - 2px);
  }
}
@media (max-width: 600px)
{
  section span 
  {
    width: calc(20vw - 2px);
    height: calc(20vw - 2px);
  }
}
.signin .content .links a {
  color: #0f0; /* Màu xanh lá cây */
  text-decoration: none; /* Loại bỏ gạch chân */
  transition: color 0.3s ease; /* Hiệu ứng chuyển đổi màu khi di chuột qua */
}

.signin .content .links a:hover {
  color: #0f0; /* Màu xanh lá cây khi di chuột qua */
}

    </style>
</head>
<body>
  <section>
    <div class="signin">
      <div class="content">
    <h2>Cập nhật đóng góp</h2>

        <div class="form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?contribution_id=' . $contribution_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Tiêu đề:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required>
        <label for="content">Nội dung:</label>
        <textarea id="content" name="content" rows="4" cols="50" required><?php echo $content; ?></textarea>
        <label for="file">Hình ảnh hoặc tệp đính kèm:</label>
        <input type="file" id="file" name="file[]" accept="image/*,.zip" multiple>
        <div class="inputBox">
                <input type="submit" onclick="showNotification()" value="Update">
        </div>
    </form>
        </div>
      </div>
    </div>
  </section>
   
</body>
</html>