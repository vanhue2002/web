<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role']; 
if($role == 'admin'){
    $_SESSION['header_title'] = 'Admin Dashboard';
} elseif ($role == 'student') {
    $_SESSION['header_title'] = 'Student Dashboard';
} elseif ($role == 'Marketing Manager') {
    $_SESSION['header_title'] = 'Marketing Manager';
} elseif ($role == 'guest') {
    $_SESSION['header_title'] = 'Guest Dashboard';
}else {
    $_SESSION['header_title'] = 'Marketing Coordinator';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Marketing Contribution Portal</title>
    <link rel="stylesheet" href="../headerstyle.css">
</head>
<body>
    <header>
    <div class="hamburger">
        <div></div>
        <div></div>
        <div></div>
        <div></div>

    </div>
    <h1><?php echo isset($_SESSION['header_title']) ? $_SESSION['header_title'] : 'Default Title'; ?></h1>  
        <div class="topnav">
            <?php 
                if($role == 'admin'){                   
                    echo '<a class="" href="index.php" >Home</a>';
                    echo '<a href="manage_event.php">Manage Events</a>';
                    echo '<a href="manage_faculty.php">Manage Faculties</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }                 
                }
                elseif($role == 'student'){
                    echo '<a class="" href="index.php" >Home</a>';
                    echo '<a class="" href="event.php" >Event</a>';
                    echo '<a class="" href="manage_contribution.php" >Contribution</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
                elseif($role == 'guest'){
                    echo '<a class="" href="index.php" >Home</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
                elseif($role == 'Marketing Manager'){
                    echo '<a class="" href="index.php" >Home</a>';
                    echo '<a href="view_contribution.php">Student Contribution</a>';
                    echo '<a href="manager_dashboard.php">Statistics</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }  
                }
                else {
                    
                    echo '<a class="" href="index.php" >Home</a>';
                    echo '<a href="coordinator_manage_contribution.php">Coordinator Manage</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }              
                }
            
            ?>
      </div>

    </header>
  
