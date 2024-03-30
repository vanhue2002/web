<?php
// Kết nối đến cơ sở dữ liệu
require_once('config.php');

// Truy vấn để lấy dữ liệu từ cơ sở dữ liệu
$query = "SELECT faculty_name, COUNT(*) AS total_contributions FROM contributions GROUP BY faculty_name";
$result = mysqli_query($conn, $query);

// Chuyển đổi dữ liệu thành mảng để sử dụng trong JavaScript
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($data);

// Đóng kết nối
mysqli_close($conn);
?>
