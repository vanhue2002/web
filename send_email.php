<?php
// Bắt đầu phiên đăng nhập nếu chưa tồn tại
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
require 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    echo "Phiên đăng nhập chưa được bắt đầu hoặc biến 'user_id' không tồn tại trong phiên.";
    exit();
}

$mail = new PHPMailer(true);

try {
    $student_id = $_SESSION['user_id'];

    $get_coordinator_query = "SELECT username, email FROM users WHERE role = 'Marketing Coordinator' AND faculty_name = (SELECT faculty_name FROM users WHERE user_id = ?)";
    $stmt_coordinator = $conn->prepare($get_coordinator_query);
    $stmt_coordinator->bind_param("i", $student_id);
    $stmt_coordinator->execute();
    $result_coordinator = $stmt_coordinator->get_result();

    if ($result_coordinator->num_rows > 0) {
        $coordinator_data = $result_coordinator->fetch_assoc();

        $get_sender_info_query = "SELECT username, email FROM users WHERE user_id = ?";
        $stmt_sender_info = $conn->prepare($get_sender_info_query);
        $stmt_sender_info->bind_param("i", $student_id);
        $stmt_sender_info->execute();
        $stmt_sender_info->store_result();

        if ($stmt_sender_info->num_rows > 0) {
            $stmt_sender_info->bind_result($sender_username, $sender_email);
            $stmt_sender_info->fetch();
        }

        $title = $_POST['title'];

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'nguyenhue260502@gmail.com'; 
        $mail->Password = 'ufct xgoq gzzt qfoa'; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465; 

        $mail->setFrom($coordinator_data['email'], 'School Marketing Contribution Portal');
        $mail->addAddress($coordinator_data['email'], 'student');

        $mail->Subject = 'Submission Notification';

        $message = "Xin chào " . $coordinator_data['username'] . ",\n\n";
        $message .= "Một sinh viên đã nộp bài cho sự kiện " . $_SESSION['selected_event_name'] . ".\n\n";
        $message .= "Thông tin sinh viên:\n";
        $message .= "Tên: " . $sender_username . "\n";
        $message .= "Email: " . $sender_email . "\n\n";
        $message .= "Tiêu đề bài viết: " . $title . "\n";
        $message .= "Nội dung bài viết: " . $contribution . "\n\n";
        $message .= "Xin vui lòng kiểm tra và xác nhận.\n\n";
        $message .= "Trân trọng,\n";
        $message .= "Ban quản trị";

        $mail->Body = $message;

        $mail->send();
        echo 'Email has been sent successfully!';
    } else {
        echo "No coordinator found for the student.";
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>


