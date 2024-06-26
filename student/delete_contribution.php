<?php
session_start();
require_once('../config.php');

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

// Kiểm tra quyền truy cập: chỉ cho phép xóa nếu user_id của contribution giống với user_id của người đăng nhập
if ($_SESSION['user_id'] != $row['user_id']) {
    echo "Bạn không có quyền truy cập vào đóng góp này.";
    exit();
}

// Xác nhận xóa đóng góp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete_sql = "DELETE FROM contributions WHERE contribution_id = '$contribution_id'";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Xóa đóng góp thành công.";
    } else {
        echo "Lỗi: " . $delete_sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa đóng góp</title>
</head>
<body>
    <h2>Xóa đóng góp</h2>
    <p>Bạn có chắc chắn muốn xóa đóng góp này?</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?contribution_id=' . $contribution_id; ?>" method="POST">
        <button type="submit">Xóa</button>
        <a href="javascript:history.go(-1)">Quay lại</a>
    </form>
</body>
</html>
