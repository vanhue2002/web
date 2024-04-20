<?php
require_once('../config.php');
include '../header.php';

require_once('authentication.php');

$contributions_query = "SELECT f.faculty_name, COUNT(c.contribution_id) AS total_contributions
                        FROM faculties f
                        LEFT JOIN users u ON f.faculty_name = u.faculty_name
                        LEFT JOIN contributions c ON u.user_id = c.user_id
                        GROUP BY f.faculty_name";

$contributions_result = $conn->query($contributions_query);

$students_query = "SELECT f.faculty_name, 
                          COUNT(u.user_id) AS total_students,
                          SUM(CASE WHEN u.role = 'student' THEN 1 ELSE 0 END) AS students_with_contributions
                   FROM faculties f
                   LEFT JOIN users u ON f.faculty_name = u.faculty_name
                   GROUP BY f.faculty_name";

$students_result = $conn->query($students_query);

$total_contributions_query = "SELECT COUNT(*) AS total_contributions FROM contributions";
$total_contributions_result = $conn->query($total_contributions_query);
$total_contributions_row = $total_contributions_result->fetch_assoc();
$total_contributions = $total_contributions_row['total_contributions'];

$data = array();

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

$sql_students = "SELECT faculty_name, COUNT(user_id) AS num_students
                 FROM users
                 WHERE role = 'student'
                 GROUP BY faculty_name";

$result_students = $conn->query($sql_students);


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
         @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
  {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Quicksand', sans-serif;
}
body 
{
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #000;
}
section 
{
  position: absolute;
  width: 100vw;
  height: 100vh;
  justify-content: center;
  align-items: center;
  gap: 2px;
  flex-wrap: wrap;
}
section::before 
{
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(#000,#0f0,#000);
  animation: animate 5s linear infinite;
}
@keyframes animate 
{
  0%
  {
    transform: translateY(-100%);
  }
  100%
  {
    transform: translateY(100%);
  }
}
section span 
{
  position: relative;
  display: block;
  width: calc(6.25vw - 2px);
  height: calc(6.25vw - 2px);
  z-index: 2;
  transition: 1.5s;
}
section span:hover 
{
  background: #0f0;
  transition: 0s;
}
section .signin
{
  position: relative;

  width: 80%;
  background: #222;  
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  border-radius: 14px;
  box-shadow: 0 15px 35px rgba(0,0,0,9);
  margin-left:100px;
  margin-top:100px;
}
section .signin .content 
{
  position: relative;

  width: 100%;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 40px;
}
section .signin .content h2 
{
  font-size: 2em;
  color: #0f0;
  text-transform: uppercase;
}
  main {
      margin: 20px auto;
      max-width: 800px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      border-radius: 4px;
  }
  
  .contribution strong {
      font-size: 1.4em;
      display: block;
      margin-bottom: 10px;
      color: #333;
  }
  
  .contribution {
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #f0f0f0;
      border-radius: 4px;
      background: #f9f9f9;
  }
  
  .pagination {
      display: flex;
      justify-content: center;
      margin: 20px 0;
  }
  
  .pagination a {
      margin: 0 10px;
      text-decoration: none;
      color: #333;
  }
  
   
    </style>
</head>
<body>
<section>
        <div class="signin">
            <div class="content">
            <main>
    <h2>Total Contributions: <?php echo $total_contributions; ?></h2>
    <div style="width: 40%">
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
    </main>
            </div>
        </div>
    </section>
    
    <script>
        const facultyData = <?php echo json_encode($data); ?>;

        const labels = Object.keys(facultyData);
        const contributions = labels.map(label => facultyData[label].total_contributions);

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


