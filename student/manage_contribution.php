<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('../config.php');
include '../header.php';
require_once('authentication.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM contributions WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contributions</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
*
{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Quicksand', sans-serif;
}
body 
{
  display: flex;
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
  display: flex;
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
  background: #181818;
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
  width: 80%;
  background: #222;  
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  border-radius: 14px;
  box-shadow: 0 15px 35px rgba(0,0,0,9);
  margin-top:100px;
}
section .signin .content 
{
  position: relative;
  width: 100%;
  display: flex;
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
section .signin .content .form 
{
  width: 100%;
  margin-top:-45px;  
  overflow: auto;
}
section .signin .content .form .inputBox
{
  position: relative;
  width: 100%;
}
section .signin .content .form .inputBox input 
{
  position: relative;
  width: 100%;
  background: #333;
  border: none;
  outline: none;
  padding: 25px 10px 7.5px;
  border-radius: 4px;
  color: #fff;
  font-weight: 500;
  font-size: 1em;
}
section .signin .content .form .inputBox i 
{
  position: absolute;
  left: 0;
  padding: 15px 10px;
  font-style: normal;
  color: #aaa;
  transition: 0.5s;
  pointer-events: none;
}
.signin .content .form .inputBox input:focus ~ i,
.signin .content .form .inputBox input:valid ~ i
{
  transform: translateY(-7.5px);
  font-size: 0.8em;
  color: #fff;
}
.signin .content .form .links 
{
  position: relative;
  width: 100%;
  display: flex;
  justify-content: space-between;
}
.signin .content .form .links a 
{
  color: #fff;
  text-decoration: none;
}
.signin .content .form .links a:nth-child(2)
{
  color: #0f0;
  font-weight: 600;
}
.signin .content .form .inputBox input[type="submit"]
{
  padding: 10px;
  background: #0f0;
  color: #000;
  font-weight: 600;
  font-size: 1.35em;
  letter-spacing: 0.05em;
  cursor: pointer;
}
input[type="submit"]:active
{
  opacity: 0.6;
}
@media (max-width: 900px)
{
  section span 
  {
    width: calc(10vw - 2px);
    height: calc(10vw - 2px);
  }
}
@media (max-width: 600px)
{
  section span 
  {
    width: calc(20vw - 2px);
    height: calc(20vw - 2px);
  }
}
.signin .content .links a {
  color: #0f0; 
  text-decoration: none; 
  transition: color 0.3s ease; 
}

.signin .content .links a:hover {
  color: #0f0; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #f2f2f2; 
}

table th, table td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #dddddd;
}

table tr:nth-child(even) {
    background-color: #ffffff; 
}

table tr:hover {
    background-color: #f0f0f0; 
}

img {
    display: block;
    margin: auto;
    max-width: 200px;
    max-height: 200px;
}


    </style>
</head>
<body>
    
    

    <section>
        <div class="signin">

            <div class=" content">
            <h2>Manage Your Contributions</h2>

                <div class="form">
                <table>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Title</th><th>Content</th><th>File/Image</th><th>Status</th><th>Actions</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['content']}</td>";
                echo "<td>";
                $file_paths = explode(',', $row['file_path']);
$imageDisplayed = false; 
foreach ($file_paths as $file_path) {
    $extension = pathinfo($file_path, PATHINFO_EXTENSION);

    if (in_array($extension, array("jpg", "jpeg", "png", "gif"))) {
        if (!$imageDisplayed) {
            echo "Image:<br>"; 
            $imageDisplayed = true;
        }
        echo "<img src='../student/" . $file_path . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
    } else {
        // Xử lý file Word, PDF, Excel và ZIP
        if (in_array($extension, array("doc", "docx", "pdf", "xls", "xlsx", "zip"))) {
            echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";;
        } else {
            // Xử lý các định dạng tệp khác
            echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";
        }
    }
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
    </table>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

<?php
mysqli_close($conn);
?>
