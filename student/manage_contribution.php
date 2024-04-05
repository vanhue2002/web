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
    <style>
         body{
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg'); 
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}
        main {
    margin: 20px auto; 
    max-width: 800px; 
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    background-color: #fff;
}

table {
    width: 100%; 
    border-collapse: collapse;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
}

table th,
table td {
    padding: 10px; 
    border: 1px solid #ccc; 
    text-align: left;
}

table th {
    background-color: #f0f0f0; }

table td img {
    max-width: 100px; 
    max-height: 100px;
}

footer {
  position: fixed;
  bottom: 0; 
  width: 100%; 
  background-color: #343a40;
  color: #fff;
  text-align: center;
}

@media screen and (max-width: 800px) {
    body {
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
  min-height: 100vh;
  display: flex; 
  flex-direction: column; 
}
            main {
              flex:1;
              padding: 10px; 
            }
           
        }
        table {
            font-size: .8em;
        }
        table th,
        table td {
            padding: 5px; /* giảm padding trong ô */
        }
        table td img {
            max-width: 50px; /* giảm kích thước hình ảnh */
            max-height: 50px;
        }
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
