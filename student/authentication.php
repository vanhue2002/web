<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    $previous_page = $_SERVER['HTTP_REFERER'];

    if ($previous_page === '' || !isset($previous_page)) {
        $previous_page = '../login/login.php';
    }

    echo "<script>alert('Bạn không có quyền truy cập trang này!'); window.history.back();</script>";
    exit(); 

?>