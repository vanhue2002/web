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
    <title>University Magazine</title>
    <style>
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f0f0f0;
            margin-bottom:60px
        }
        .user-info {
            text-align: right;
        }
        .user-info a {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>University Magazine</h1>
        <div class="user-info">
            <?php if(isset($_SESSION['username'])): ?>
                <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
                <a href="../login/logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </header>
</body>
