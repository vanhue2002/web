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
            margin-bottom:60px
        }
        main {
    margin: 20px auto;
    max-width: 800px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 4px;
}
/* style cho tiêu đề */
.contribution strong {
    font-size: 1.4em;
    display: block;
    margin-bottom: 10px;
    color: #333;
}

/* style cho nội dung */
.contribution {
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #f0f0f0;
    border-radius: 4px;
    background: #f9f9f9;
}

/* Khung phân trang */
.pagination {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

/* Liên kết phân trang */
.pagination a {
    margin: 0 10px;
    text-decoration: none;
    color: #333;
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
<main>
<div class="container">
     

<?php



if (isset($_SESSION['faculty_name'])) {
    $faculty_name = $_SESSION['faculty_name'];
    
    // Định nghĩa trang hiện tại và số đóng góp trên mỗi trang
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;
    
    // Lấy thời điểm hiện tại
    $current_time = time();

    // Thực hiện truy vấn để lấy thông tin về các đóng góp từ sinh viên trong cùng khoa
    $sql = "SELECT c.contribution_id, c.title, c.content, c.file_path, c.status, c.created_at, c.updated_at, 
                   u.user_id, u.username, u.email, u.faculty_name
            FROM contributions c
            INNER JOIN users u ON c.user_id = u.user_id
            WHERE u.faculty_name = '$faculty_name'
            ORDER BY c.created_at DESC
            LIMIT $offset, $items_per_page";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Duyệt qua từng hàng kết quả
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='contribution'>";
            // Hiển thị thông tin của mỗi đóng góp và sinh viên
            echo "<strong>Contribution ID:</strong> " . $row['contribution_id'] . "<br>";
            echo "<strong>Title:</strong> " . $row['title'] . "<br>";
            echo "<strong>Content:</strong> " . $row['content'] . "<br>";
            // Kiểm tra loại tệp tin
            $file_path = $row['file_path'];
            if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                // Nếu là file zip, hiển thị tên file và tạo liên kết tải xuống
                echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";
            } else {
                // Nếu là hình ảnh, hiển thị hình ảnh
                echo "<strong>Image:</strong> <img src='../student/" . $row['file_path'] . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
            }
            echo "<strong>Status:</strong> " . $row['status'] . "<br>";
            echo "<strong>Created At:</strong> " . $row['created_at'] . "<br>";
            echo "<strong>Updated At:</strong> " . $row['updated_at'] . "<br>";
            echo "<strong>User ID:</strong> " . $row['user_id'] . "<br>";
            echo "<strong>Username: </strong>" . $row['username'] . "<br>";
            echo "<strong>Email:</strong> " . $row['email'] . "<br>";
            echo "<strong>Faculty:</strong>" . $row['faculty_name'] . "<br>";

            // Hiển thị form để thêm hoặc cập nhật bình luận
            echo "<form method='post' action='add_update_comment.php'>";
            echo "<input type='hidden' name='contribution_id' value='" . $row['contribution_id'] . "'>";
            echo "<textarea name='comment_content' placeholder='Nhập nội dung bình luận'></textarea><br>";
            echo "<button type='submit' name='submit_comment'>Gửi bình luận</button>";
            echo "</form>";
            
            // Hiển thị các bình luận cho đóng góp
            $contribution_id = $row['contribution_id'];
            $sql_comments = "SELECT * FROM comments WHERE contribution_id = $contribution_id";
            $result_comments = mysqli_query($conn, $sql_comments);
            while ($comment_row = mysqli_fetch_assoc($result_comments)) {
                // Lấy tên người dùng từ ID người dùng
                $user_id = $comment_row['user_id'];
                $sql_username = "SELECT username FROM users WHERE user_id = $user_id";
                $result_username = mysqli_query($conn, $sql_username);
                $row_username = mysqli_fetch_assoc($result_username);
                $username = $row_username['username'];

                // Hiển thị thông tin bình luận với tên người dùng thay vì ID người dùng
                echo "<p><strong>Username:</strong> " . $username . "</p>";
                echo "<p><strong>Nội dung:</strong> " . $comment_row['content'] . "</p>";
                echo "<p><strong>Ngày tạo:</strong> " . $comment_row['created_at'] . "</p>";
            }
            
            // Chọn để xuất bản
            echo "<form method='post' action='publish_contribution.php'>";
            echo "<input type='hidden' name='contribution_id' value='" . $row['contribution_id'] . "'>";
            echo "<button type='submit' name='publish_contribution'>Xuất bản</button>";
            echo "</form>";
            echo "</div>";
            echo "<hr>"; // Tạo đường kẻ ngang để phân biệt giữa các đóng góp
        }
        
        // Đếm tổng số đóng góp
        $sql_count = "SELECT COUNT(*) AS total_contributions FROM contributions c INNER JOIN users u ON c.user_id = u.user_id WHERE u.faculty_name = '$faculty_name'";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        $total_contributions = $row_count['total_contributions'];

        // Tính toán tổng số trang
        $total_pages = ceil($total_contributions / $items_per_page);

        // Hiển thị các liên kết đến các trang kế tiếp
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

// Đóng kết nối
mysqli_close($conn);
?>
  </main>
  <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>


</body>
</html>