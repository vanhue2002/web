<?php
session_start();
require_once('../config.php');
require_once('authentication.php');
include '../header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List contributions</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        section .signin {            
            width: 1000px;           
        }
        h2{
            text-align: center;
            color: white;
        }
    </style>
</head>
<body>
    <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
        <div class="signin"> 
            <div class="container"> 
                <h2>LIST CONTRIBUTIONS</h2>
                <br>
                <?php
                    if(isset($_SESSION['faculty_name'])) {
                        $faculty_name = $_SESSION['faculty_name'];
                        
                        $sql = "SELECT c.title, c.content, c.file_path, c.created_at, u.username 
                                FROM contributions c 
                                INNER JOIN users u ON c.user_id = u.user_id 
                                INNER JOIN events e ON c.event_id = e.event_id 
                                WHERE e.faculty_name = '$faculty_name' AND c.status = 'published'";
                        
                        $result = mysqli_query($conn, $sql);
                        
                        if(mysqli_num_rows($result) > 0) {
                            
                            echo "<table border='1'>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Image/File</th>
                                    <th>Publication date</th>
                                    <th>Student</th>
                                </tr>";
                            
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['content'] . "</td>";
                                echo "<td>";
                                if (!empty($row['file_path'])) {
                                    
                    
                    
                                    $file_paths = explode(',', $row['file_path']);
                                    $imageDisplayed = false; 
                                    foreach ($file_paths as $file_path) {
                                        if (in_array(pathinfo($file_path, PATHINFO_EXTENSION), array("jpg", "jpeg", "png", "gif"))) {
                                            if (!$imageDisplayed) {
                                                echo "Image:<br>"; 
                                                $imageDisplayed = true;
                                            }
                                            echo "<img src='../student/" . $file_path . "' alt='Contribution Image' style='max-width: 200px; max-height: 200px;'><br>";
                                        } else {
                                            echo "File: <a href='$file_path' download>" . basename($file_path) . "</a><br>";
                                        }
                                    }
                    
                    
                                } else {
                                    echo "Không có hình ảnh hoặc file";
                                }
                                echo "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "</tr>";
                            }
                            
                            echo "</table>";
                        } else {
                            echo "Không có đóng góp nào được xuất bản.";
                        }
                    } else {
                        echo "Vui lòng đăng nhập để truy cập trang này.";
                    }
                    mysqli_close($conn);
                    ?>
                

                    
                
            </div> 
        </div> 
    </section>
</body>
</html>
