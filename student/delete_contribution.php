<?php
session_start();
require_once('../config.php');

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

if ($_SESSION['user_id'] != $row['user_id']) {
    echo "Bạn không có quyền truy cập vào đóng góp này.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delete_sql = "DELETE FROM contributions WHERE contribution_id = '$contribution_id'";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script type='text/javascript'>alert('Xóa thành công!'); window.location.href='./manage_contribution.php';</script>";

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
