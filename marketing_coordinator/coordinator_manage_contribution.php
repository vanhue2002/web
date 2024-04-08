<?php
session_start(); 
require_once('../config.php');
require_once('header.php');
require_once('authentication.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
  margin-top:160px;
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
   <section>
    <div class="signin">
        <div class="content">
           <main>
           <?php
if (isset($_SESSION['faculty_name'])) {
    $faculty_name = $_SESSION['faculty_name'];
    
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;
    
    $current_time = time();

    $sql = "SELECT c.contribution_id, c.title, c.content, c.file_path, c.status, c.created_at, c.updated_at, 
                   u.user_id, u.username, u.email, u.faculty_name
            FROM contributions c
            INNER JOIN users u ON c.user_id = u.user_id
            WHERE u.faculty_name = '$faculty_name'
            ORDER BY c.created_at DESC
            LIMIT $offset, $items_per_page";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Contribution ID: " . $row['contribution_id'] . "<br>";
            echo "Title: " . $row['title'] . "<br>";
            echo "Content: " . $row['content'] . "<br>";
            
            $file_paths = explode(',', $row['file_path']);
            $imageDisplayed = false; 
            foreach ($file_paths as $file_path) {
                if (in_array(pathinfo($file_path, PATHINFO_EXTENSION), array("jpg", "jpeg", "png", "gif"))) {
                    if (!$imageDisplayed) {
                        echo "Image:<br>"; 
                        $imageDisplayed = true;
                    }
                    echo "<img src='../student/" . $file_path . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
                } else {
                    echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";
                }
            }

            echo "Status: " . $row['status'] . "<br>";
            echo "Created At: " . $row['created_at'] . "<br>";
            echo "Updated At: " . $row['updated_at'] . "<br>";
            echo "User ID: " . $row['user_id'] . "<br>";
            echo "Username: " . $row['username'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            
            echo "<form method='post' action='add_update_comment.php'>";
            echo "<input type='hidden' name='contribution_id' value='" . $row['contribution_id'] . "'>";
            echo "<textarea name='comment_content' placeholder='Nhập nội dung bình luận'></textarea><br>";
            echo "<button type='submit' name='submit_comment'>Gửi bình luận</button>";
            echo "</form>";
            
            $contribution_id = $row['contribution_id'];
            $sql_comments = "SELECT * FROM comments WHERE contribution_id = $contribution_id";
            $result_comments = mysqli_query($conn, $sql_comments);
            while ($comment_row = mysqli_fetch_assoc($result_comments)) {
                $user_id = $comment_row['user_id'];
                $sql_username = "SELECT username FROM users WHERE user_id = $user_id";
                $result_username = mysqli_query($conn, $sql_username);
                $row_username = mysqli_fetch_assoc($result_username);
                $username = $row_username['username'];

                echo "<p><strong>Username:</strong> " . $username . "</p>";
                echo "<p><strong>Nội dung:</strong> " . $comment_row['content'] . "</p>";
                echo "<p><strong>Ngày tạo:</strong> " . $comment_row['created_at'] . "</p>";
            }
            
            echo "<form method='post' action='publish_contribution.php'>";
            echo "<input type='hidden' name='contribution_id' value='" . $row['contribution_id'] . "'>";
            echo "<button type='submit' name='publish_contribution'>Xuất bản</button>";
            echo "</form>";

            echo "<hr>"; 
        }
        
        $sql_count = "SELECT COUNT(*) AS total_contributions FROM contributions c INNER JOIN users u ON c.user_id = u.user_id WHERE u.faculty_name = '$faculty_name'";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        $total_contributions = $row_count['total_contributions'];

        $total_pages = ceil($total_contributions / $items_per_page);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='coordinator_manage_contribution.php?page=$i'>$i</a> ";
        }
        echo "</div>";
    } else {
        echo "Không có đóng góp nào được tìm thấy.";
    }
    
} else {
    echo "Phiên đăng nhập chưa được bắt đầu hoặc biến 'faculty_name' không tồn tại trong phiên.";
}
?>  
           </main>
        </div>
    </div>
   </section>
</body>
</html>
<?php

// Đóng kết nối
mysqli_close($conn);
?>

