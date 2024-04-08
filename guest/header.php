<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
        <h1>Guest</h1>
        <div class="topnav">
        <a class="active" href="#home">Home</a>
            <a href="../guest/index.php">Guest Dashboard</a>
            <a href="../guest/list_publish_contribution.php">List Contribution</a>            
            <?php if(isset($_SESSION['username'])): ?>
                <a>Welcome, <?php echo $_SESSION['username']; ?>!</a>
                <a href="../login/logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </header>
