<?php
// Bắt đầu phiên đăng nhập nếu chưa tồn tại
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load các file cần thiết của PHPMailer
require 'vendor/autoload.php';
require 'config.php'; // File cấu hình kết nối cơ sở dữ liệu

// Kiểm tra xem user_id có tồn tại trong phiên không
if (!isset($_SESSION['user_id'])) {
    echo "Phiên đăng nhập chưa được bắt đầu hoặc biến 'user_id' không tồn tại trong phiên.";
    exit();
}

// Khởi tạo đối tượng PHPMailer
$mail = new PHPMailer(true);

try {
    // Lấy user_id của sinh viên đang đăng nhập
    $student_id = $_SESSION['user_id'];

    // Truy vấn để lấy email của chủ khoa
    $get_coordinator_query = "SELECT username, email FROM users WHERE role = 'Marketing Coordinator' AND faculty_name = (SELECT faculty_name FROM users WHERE user_id = ?)";
    $stmt_coordinator = $conn->prepare($get_coordinator_query);
    $stmt_coordinator->bind_param("i", $student_id);
    $stmt_coordinator->execute();
    $result_coordinator = $stmt_coordinator->get_result();

    // Kiểm tra xem có chủ khoa nào được tìm thấy không
    if ($result_coordinator->num_rows > 0) {
        $coordinator_data = $result_coordinator->fetch_assoc();

        // Lấy thông tin người gửi (sinh viên)
        $get_sender_info_query = "SELECT username, email FROM users WHERE user_id = ?";
        $stmt_sender_info = $conn->prepare($get_sender_info_query);
        $stmt_sender_info->bind_param("i", $student_id);
        $stmt_sender_info->execute();
        $stmt_sender_info->store_result();

        if ($stmt_sender_info->num_rows > 0) {
            $stmt_sender_info->bind_result($sender_username, $sender_email);
            $stmt_sender_info->fetch();
        }

        // Lấy tiêu đề của đóng góp
        $title = $_POST['title'];

        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Đổi host tùy theo dịch vụ email của bạn
        $mail->SMTPAuth = true;
        $mail->Username = 'nguyenhue260502@gmail.com'; // Thay bằng địa chỉ email của bạn
        $mail->Password = 'ufct xgoq gzzt qfoa'; // Thay bằng mật khẩu email của bạn
        $mail->SMTPSecure = 'ssl'; // Hoặc 'ssl' tùy theo cấu hình SMTP của bạn
        $mail->Port = 465; // Đối với TLS, sử dụng cổng 587; đối với SSL, sử dụng cổng 465

        // Thiết lập thông tin người gửi và người nhận
        $mail->setFrom($coordinator_data['email'], 'School Marketing Contribution Portal');
        $mail->addAddress($coordinator_data['email'], 'student');

        // Tiêu đề và nội dung email
        $mail->Subject = 'Submission Notification';

        // Tạo nội dung email
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

        // Gửi email
        $mail->send();
        echo 'Email has been sent successfully!';
    } else {
        echo "No coordinator found for the student.";
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>


