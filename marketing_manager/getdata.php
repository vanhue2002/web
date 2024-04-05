<?php
require_once('config.php');

$query = "SELECT faculty_name, COUNT(*) AS total_contributions FROM contributions GROUP BY faculty_name";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);


mysqli_close($conn);
?>
