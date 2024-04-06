<?php
require_once('authentication.php');
require_once('../login/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <link rel="stylesheet" href="./css/manage_faculty.css">
    <style>
           
    </style>
</head>
<body>
   <main>
   <h2>Faculty Management</h2>
        <tr>
            <th>ID</th>
            <th>Faculty Name</th>
            <th>Action</th>
        </tr>
        <?php
        require_once('../config.php');

        $query = "SELECT * FROM faculties";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['faculty_id'] . "</td>";
            echo "<td>" . $row['faculty_name'] . "</td>";
            echo "<td><a href='view_faculty.php?faculty_id=" . $row['faculty_id'] . "'>View</a> | <a href='delete_faculty.php?faculty_id=" . $row['faculty_id'] . "'>Delete</a> | <a href='update_faculty.php?faculty_id=" . $row['faculty_id'] . "'>Update</a></td>";
            echo "</tr>";
        }

        mysqli_close($conn);
        ?>
    </table>
   </main>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
