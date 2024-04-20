<?php
session_start();
require_once('../config.php');

// Truy vấn để lấy các contributions đã được chọn
$query = "
    SELECT c.title, c.content, e.event_name, f.faculty_name, c.created_at
    FROM contributions c
    JOIN events e ON c.event_id = e.event_id
    JOIN faculties f ON e.faculty_name = f.faculty_name
    WHERE c.is_selected = 1
    ORDER BY c.created_at DESC
";

$result = $conn->query($query);


// Chuẩn bị dữ liệu cho biểu đồ
$events = [];
$colors = [
    'red',
    'blue',
    'green',
    'purple',
    'orange',
    'teal',
    'pink',
    'yellow',
];

while ($row = $result->fetch_assoc()) {
    $event_name = $row['event_name'];
    
    // Nếu sự kiện chưa tồn tại trong mảng, thêm vào và khởi tạo số lượng
    if (!array_key_exists($event_name, $events)) {
        $events[$event_name] = [
            'count' => 0,
            'color' => $colors[count($events) % count($colors)]
        ];
    }
    // Tăng số lượng cho sự kiện
    $events[$event_name]['count']++;
}

// Chuyển đổi dữ liệu sang định dạng JSON để sử dụng trong JavaScript
$eventNamesJson = json_encode(array_keys($events));
$datasetsJson = json_encode(array_values($events));

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biểu đồ thống kê báo cáo</title>
    <!-- Thêm thư viện Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Biểu đồ thống kê báo cáo đã được published theo sự kiện</h1>
    <canvas id="myChart" width="400" height="200"></canvas>
    
    <script>
    // Lấy dữ liệu JSON từ PHP
    const eventNames = <?php echo $eventNamesJson; ?>;
    const datasetsData = <?php echo $datasetsJson; ?>;

    // Chuẩn bị datasets cho biểu đồ
    const datasets = datasetsData.map((event, index) => ({
        label: eventNames[index],
        data: [event.count],
        backgroundColor: event.color,
        borderColor: event.color,
        borderWidth: 1
    }));

    // Vẽ biểu đồ bằng Chart.js
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Contribution'],
            datasets: datasets
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    </script>
</body>
</html>
