<?php
require_once 'config.php'; 

function sendEmailToCoordinator($student_email, $subject, $message) {
    global $conn;

    $query = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $student_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_email = $row['email']; 
        $sent = sendEmail($student_email, $_SESSION['email'], $subject, $message); 
        if ($sent) {
            echo "Email đã được gửi đi thành công!";
        } else {
            echo "Gửi email thất bại!";
        }
    } else {
        echo "Không tìm thấy thông tin người dùng.";
    }
}

function sendEmail($to, $from, $subject, $message) {
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Content-type: text/html\r\n";

    return mail($to, $subject, $message, $headers);
}

$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
sendEmailToCoordinator($_SESSION['email'], $subject, $message);
?>
