<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $previous_page = $_SERVER['HTTP_REFERER'];

    if ($previous_page === '' || !isset($previous_page)) {
        $previous_page = '../login/login.php';
    }
    echo "<script>alert('You don't have authorization to access this page!!'); window.history.back();</script>";
    exit();
}
?>