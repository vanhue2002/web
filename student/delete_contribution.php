<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../config.php');
require_once('authentication.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['contribution_id'])) {
    echo "Contribution ID không hợp lệ.";
    exit();
}

$contribution_id = $_GET['contribution_id'];

// Kiểm tra sự tồn tại của đóng góp
$sql = "SELECT * FROM contributions WHERE contribution_id = '$contribution_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Không tìm thấy đóng góp.";
    exit();
}

$row = mysqli_fetch_assoc($result);

// Kiểm tra quyền truy cập
if ($_SESSION['user_id'] != $row['user_id']) {
    echo "Bạn không có quyền truy cập vào đóng góp này.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi liên quan trong bảng 'comments'
        $delete_comments_query = "DELETE FROM comments WHERE contribution_id = ?";
        $stmt = $conn->prepare($delete_comments_query);
        $stmt->bind_param('i', $contribution_id);
        $stmt->execute();

        // Xóa bản ghi trong bảng 'contributions'
        $delete_sql = "DELETE FROM contributions WHERE contribution_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param('i', $contribution_id);
        $stmt->execute();

        // Nếu tất cả các thao tác thành công, hoàn tất giao dịch
        $conn->commit();

        // Chuyển hướng đến trang quản lý đóng góp
        header("Location: manage_contribution.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // Nếu có lỗi, hủy giao dịch và thông báo lỗi
        $conn->rollback();
        echo "Lỗi: " . addslashes($e->getMessage());
    }

    // Đóng truy vấn và kết nối
    $stmt->close();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
