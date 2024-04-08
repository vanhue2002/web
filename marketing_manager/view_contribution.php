<?php
session_start();
require_once('../config.php');
include '../header.php';

require_once('authentication.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy user_id của người dùng từ session
$user_id = $_SESSION['user_id'];

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] !== 'Marketing Manager') {
    // Nếu không phải là Marketing Manager, chuyển hướng người dùng đến trang không có quyền truy cập
    header("Location: access_denied.php");
    exit();
}


// Định nghĩa trang hiện tại và số đóng góp trên mỗi trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

// Truy vấn để lấy tất cả các đóng góp từ tất cả các khoa
$sql = "SELECT * FROM contributions LIMIT $offset, $items_per_page";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contributions</title>
    <link rel="stylesheet" href="./css/view_contribution.css">
    <!-- Add your CSS links here -->
    <style>
      /* body {
    background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    font-family: 'Pontano Sans', sans-serif;
    font-size: calc(0.65em + .05vw);
  }    */
  @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
  {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Quicksand', sans-serif;
}
body 
{
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
  justify-content: center;
  align-items: center;
  gap: 2px;
  flex-wrap: wrap;
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
  position: relative;

  width: 80%;
  background: #222;  
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  border-radius: 14px;
  box-shadow: 0 15px 35px rgba(0,0,0,9);
  margin-left:100px;
  margin-top:100px;
}
section .signin .content 
{
  position: relative;

  width: 100%;
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
  main {
      margin: 20px auto;
      max-width: 800px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      border-radius: 4px;
  }
  
  .contribution strong {
      font-size: 1.4em;
      display: block;
      margin-bottom: 10px;
      color: #333;
  }
  
  .contribution {
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #f0f0f0;
      border-radius: 4px;
      background: #f9f9f9;
  }
  
  .pagination {
      display: flex;
      justify-content: center;
      margin: 20px 0;
  }
  
  .pagination a {
      margin: 0 10px;
      text-decoration: none;
      color: #333;
  }
  
   
    </style>
</head>
<body>
    <header>
        <h2>View All Contributions</h2>
        <?php  
include '../header.php';
        
        ?>
    </header>
    <section>
        <div class="signin">
            <div class="content">
            <main>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Hiển thị thông tin của mỗi đóng góp
                echo "<strong>Title:</strong> " . $row['title'] . "<br>";
                echo "<strong>Content:</strong> " . $row['content'] . "<br>";
                // Kiểm tra loại tệp tin
                $file_path = $row['file_path'];
                if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                    // Nếu là file zip, hiển thị tên file và tạo liên kết tải xuống
                    echo "<strong>File:</strong> <a href='$file_path' download>" . basename($file_path) . "</a><br>";
                } else {
                    // Nếu là hình ảnh, hiển thị hình ảnh
                    echo "<strong>Image:</strong> <img src='../student/" . $row['file_path'] . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
                }
                echo "<strong>Status:</strong> " . $row['status'] . "<br>";
                echo "<strong>Created At:</strong> " . $row['created_at'] . "<br>";
                echo "<strong>Updated At:</strong> " . $row['updated_at'] . "<br>";
                echo "<strong>Student ID:</strong> " . $row['user_id'] . "<br>";
                
                echo "<hr>"; // Tạo đường kẻ ngang để phân biệt giữa các đóng góp
            }
        } else {
            echo "<p>No contributions found.</p>";
        }
        ?>
        <!-- Hiển thị các liên kết đến các trang kế tiếp -->
        <?php
        $sql_count = "SELECT COUNT(*) AS total_contributions FROM contributions";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        $total_contributions = $row_count['total_contributions'];
        $total_pages = ceil($total_contributions / $items_per_page);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='view_contribution.php?page=$i'>$i</a> ";
        }
        echo "</div>";
        ?>
    </main>
            </div>
        </div>
    </section>
   
</body>
</html>

<?php
mysqli_close($conn);
?>
