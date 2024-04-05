<?php
require_once('../config.php');
require_once('../login/header.php');
require_once('authentication.php');

// Truy vấn để lấy số lượng đóng góp của từng khoa
$contributions_query = "SELECT f.faculty_name, COUNT(c.contribution_id) AS total_contributions
                        FROM faculties f
                        LEFT JOIN users u ON f.faculty_name = u.faculty_name
                        LEFT JOIN contributions c ON u.user_id = c.user_id
                        GROUP BY f.faculty_name";

$contributions_result = $conn->query($contributions_query);

// Truy vấn để tính số lượng sinh viên và số lượng sinh viên đã nộp bài của mỗi khoa
$students_query = "SELECT f.faculty_name, 
                          COUNT(u.user_id) AS total_students,
                          SUM(CASE WHEN u.role = 'student' THEN 1 ELSE 0 END) AS students_with_contributions
                   FROM faculties f
                   LEFT JOIN users u ON f.faculty_name = u.faculty_name
                   GROUP BY f.faculty_name";

$students_result = $conn->query($students_query);

// Lấy tổng số lượng đóng góp
$total_contributions_query = "SELECT COUNT(*) AS total_contributions FROM contributions";
$total_contributions_result = $conn->query($total_contributions_query);
$total_contributions_row = $total_contributions_result->fetch_assoc();
$total_contributions = $total_contributions_row['total_contributions'];

// Tạo mảng để lưu trữ dữ liệu
$data = array();

// Lặp qua kết quả và đưa vào mảng dữ liệu
while ($row = $contributions_result->fetch_assoc()) {
    $faculty_name = $row['faculty_name'];
    $data[$row['faculty_name']]['total_contributions'] = $row['total_contributions'];
}

while ($row = $students_result->fetch_assoc()) {
    $faculty_name = $row['faculty_name'];
    $data[$row['faculty_name']]['total_students'] = $row['total_students'];
    $data[$row['faculty_name']]['students_with_contributions'] = $row['students_with_contributions'];
}

$sql = "SELECT f.faculty_name,
               COUNT(c.contribution_id) AS contribution_count,
               COUNT(DISTINCT u.user_id) AS total_students,
               CONCAT(COUNT(c.contribution_id), '/', COUNT(DISTINCT u.user_id)) AS submission_progress
        FROM contributions c
        JOIN users u ON c.user_id = u.user_id
        JOIN faculties f ON u.faculty_name = f.faculty_name
        GROUP BY f.faculty_name";

$result = $conn->query($sql);

$sql_contributions = "SELECT f.faculty_name, COUNT(c.contribution_id) AS num_contributions
                      FROM faculties f
                      LEFT JOIN users u ON f.faculty_name = u.faculty_name
                      LEFT JOIN contributions c ON u.user_id = c.user_id
                      GROUP BY f.faculty_name";

$result_contributions = $conn->query($sql_contributions);

// Truy vấn SQL để tính tổng số sinh viên của mỗi khoa
$sql_students = "SELECT faculty_name, COUNT(user_id) AS num_students
                 FROM users
                 WHERE role = 'student'
                 GROUP BY faculty_name";

$result_students = $conn->query($sql_students);


// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution Overview</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            overflow: hidden;
        }
        .progress {
            height: 100%;
            background-color: #4caf50;
        }
    </style>
</head>
<body>
    <h2>Total Contributions: <?php echo $total_contributions; ?></h2>
    <div style="width: 20%">
        <canvas id="facultyChart"></canvas>
    </div>

    <h2>Faculty Contributions and Submission Progress</h2>
    <table border="1">
        <tr>
            <th>Faculty</th>
            <th>Total Contributions</th>
            <th>Total Students</th>
            <th>Students with Contributions</th>
            <th>Submission Progress</th>
        </tr>
        <?php
        foreach ($data as $faculty => $faculty_data) {
            $total_contributions = isset($faculty_data['total_contributions']) ? $faculty_data['total_contributions'] : 0;
            $total_students = isset($faculty_data['total_students']) ? $faculty_data['total_students'] : 0;
            $students_with_contributions = isset($faculty_data['students_with_contributions']) ? $faculty_data['students_with_contributions'] : 0;
            $submission_progress = $students_with_contributions > 0 ? round(($students_with_contributions / $total_students) * 100, 2) : 0;
            $submission_text = "$students_with_contributions / $total_students";
            echo "<tr>
                    <td>$faculty</td>
                    <td>$total_contributions</td>
                    <td>$total_students</td>
                    <td>$students_with_contributions</td>
                    <td>
                        <div class='progress-bar'>
                            <div class='progress' style='width: $submission_progress%'></div>
                        </div>
                        <span title='$submission_text'>$submission_progress%</span>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    
    <script>
        // Lấy dữ liệu từ PHP và chuyển thành JavaScript
        const facultyData = <?php echo json_encode($data); ?>;

        // Tạo mảng dữ liệu cho biểu đồ
        const labels = Object.keys(facultyData);
        const contributions = labels.map(label => facultyData[label].total_contributions);

        // Tạo biểu đồ
        const facultyChart = new Chart(document.getElementById('facultyChart'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Contributions',
                    data: contributions,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>


