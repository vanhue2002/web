<?php
session_start();
require_once('../config.php');
require_once('../login/header.php');

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
$sql = "SELECT * FROM contributions ORDER BY created_at DESC LIMIT $offset, $items_per_page";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contributions</title>
    <!-- Add your CSS links here -->
    <style>
 body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}   
/* style cho container chính */
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

/* style cho footer */
footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  height: 60px; /* Chỉ định chiều cao cho footer */
  line-height: 60px; /* Đặt height cho text, đảm bảo rằng nó ở giữa footer */
  background-color: #343a40;
  color: #fff;
  text-align: center;
}
</style>
</head>
<body>
    
    <main>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
// All your contribution details here...
echo "<div class='contribution'>";

                // Hiển thị thông tin của mỗi đóng góp
                echo "<strong>Title:</strong> " . $row['title'] . "<br>";
echo "<strong>Student ID:</strong> " . $row['user_id'] . "<br>";

                echo "<strong>Content:</strong> " . $row['content'] . "<br>";
                // Kiểm tra loại tệp tin
               
                echo "<strong>Status:</strong> " . $row['status'] . "<br>";
                echo "<strong>Created At:</strong> " . $row['created_at'] . "<br>";
                echo "<strong>Updated At:</strong> " . $row['updated_at'] . "<br>";

                $file_path = $row['file_path'];
                if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                    // Nếu là file zip, hiển thị tên file và tạo liên kết tải xuống
                    echo "<strong>File:</strong> <a href='$file_path' download>" . basename($file_path) . "</a><br>";
                } else if (!empty($file_path)) {
                    // Nếu là hình ảnh, hiển thị hình ảnh
                    echo "<strong>Image:</strong> <img src='../student/" . $row['file_path'] . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
                }
                echo "</div>";
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
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
