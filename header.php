<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role']; 
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
</head>
<body>
    <header>
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
                    echo '<a class="active" href="index.php" >Home</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
                elseif($role == 'marketing_coordinator'){

                    echo '<a class="" href="index.php" >Home</a>';
                    echo '<a href="manager_dashboard.php">Student Contribution</a>';
                    echo '<a href="manage_faculty.php">Statistics</a>';
                    if(isset($_SESSION['username'])) {
                        echo '<a>Welcome, '. $_SESSION['username'] .'!</a>';
                        echo '<a href="../login/logout.php">Logout</a>';
                    }
                }
            
            ?>
      </div>
            
            
           
       
    </header>
  
