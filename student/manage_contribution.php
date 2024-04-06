<?php
session_start();
require_once('../config.php');
require_once('../login/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM contributions WHERE user_id = '$user_id'ORDER BY created_at DESC";    
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contributions</title>
    <link rel="stylesheet" href="./css/manage_contribution.css">
    <style>
        
    </style>
    <!-- Add your CSS links here -->
</head>
<body>
  
    <main>
        <h2>Quản lý contribution</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Title</th><th>Content</th><th>File/Image</th><th>Status</th><th>Actions</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['content']}</td>";
                echo "<td>";
                $file_path = $row['file_path'];
                if (pathinfo($file_path, PATHINFO_EXTENSION) === 'zip') {
                    echo "<a href='$file_path' download>" . basename($file_path) . "</a>";
                } else {
                    echo "<img src='$file_path' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'>";
                }
                echo "</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td><a href='update_contribution.php?contribution_id={$row['contribution_id']}'>Edit</a> | <a href='delete_contribution.php?contribution_id={$row['contribution_id']}'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No contributions found.</p>";
        }
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
