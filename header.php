<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role']; // replace 'role' with the actual key you used to store user's role in session
if($role == 'admin'){
    $_SESSION['header_title'] = 'Admin Dashboard';
} elseif ($role == 'student') {
    $_SESSION['header_title'] = 'Student Dashboard';
} elseif ($role == 'manager') {
    $_SESSION['header_title'] = 'Manager Dashboard';
} elseif ($role == 'guest') {
    $_SESSION['header_title'] = 'Guest Dashboard';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Marketing Contribution Portal</title>
    <link rel="stylesheet" href="../headerstyle.css">
    <!-- Add your CSS links here -->
</head>
<body>
    <header>
    <h1><?php echo isset($_SESSION['header_title']) ? $_SESSION['header_title'] : 'Default Title'; ?></h1>  
        <div class="topnav">
            <?php 
                if($role == 'admin'){                   
                    echo '<a class="active" href="index.php" >Home</a>';
                    echo  '<a href="./admin/index.php">Admin Dashboard</a>';
                    echo '<a href="./admin/manage_event.php">Manage Events</a>';
                    echo '<a href="./admin/manage_faculty.php">Manage Faculties</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }             
                }
                elseif($role == 'student'){
                    echo '<a class="active" href="index.php" >Home</a>';
                    echo '<a class="active" href="index.php" >Manage_dashboard</a>';
                    echo '<a class="active" href="index.php" >Contribution</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
                elseif($role == 'guest'){
                    echo '<a class="active" href="index.php" >Home</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
                elseif($role == 'manager'){
                    echo '<a class="active" href="index.php" >Home</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
            
            ?>
      </div>
            
            
           
       
    </header>
  
