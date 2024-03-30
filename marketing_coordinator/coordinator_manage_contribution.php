<?php
session_start(); // Bắt đầu hoặc khởi tạo phiên
require_once('../config.php');
require_once('../login/header.php');

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
            // Hiển thị thông tin của mỗi đóng góp và sinh viên
            echo "Contribution ID: " . $row['contribution_id'] . "<br>";
            echo "Title: " . $row['title'] . "<br>";
            echo "Content: " . $row['content'] . "<br>";
            // Kiểm tra loại tệp tin
            $file_path = $row['file_path'];
            if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                // Nếu là file zip, hiển thị tên file và tạo liên kết tải xuống
                echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";
            } else {
                // Nếu là hình ảnh, hiển thị hình ảnh
                echo "Image: <img src='../student/" . $row['file_path'] . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
            }
            echo "Status: " . $row['status'] . "<br>";
            echo "Created At: " . $row['created_at'] . "<br>";
            echo "Updated At: " . $row['updated_at'] . "<br>";
            echo "User ID: " . $row['user_id'] . "<br>";
            echo "Username: " . $row['username'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Faculty: " . $row['faculty_name'] . "<br>";

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
