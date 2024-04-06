<?php
session_start(); // Bắt đầu hoặc khởi tạo phiên

require_once('../login/header.php');
require_once('../config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/coordinator_manage_contribution.css">
    <style>
              </style>
</head>
<body>
<main>
<div class="container">
     

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
          echo "<div class='contribution'>";
            echo "<strong>Contribution ID:</strong> " . $row['contribution_id'] . "<br>";
            echo "<strong>Title:</strong> " . $row['title'] . "<br>";
            echo "<strong>Content:</strong> " . $row['content'] . "<br>";
            $file_path = $row['file_path'];
            if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";
            } else {
                echo "<strong>Image:</strong> <img src='../student/" . $row['file_path'] . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
            }
            echo "<strong>Status:</strong> " . $row['status'] . "<br>";
            echo "<strong>Created At:</strong> " . $row['created_at'] . "<br>";
            echo "<strong>Updated At:</strong> " . $row['updated_at'] . "<br>";
            echo "<strong>User ID:</strong> " . $row['user_id'] . "<br>";
            echo "<strong>Username: </strong>" . $row['username'] . "<br>";
            echo "<strong>Email:</strong> " . $row['email'] . "<br>";
            echo "<strong>Faculty:</strong>" . $row['faculty_name'] . "<br>";

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
            echo "</div>";
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
        echo "No contributions found.";
    }
    
} else {
    echo "Session hasn't been started or 'faculty_name' does not exist in the current session.";
}

mysqli_close($conn);
?>
  </main>
  <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>


</body>
</html>