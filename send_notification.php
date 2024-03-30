<?php
require_once 'config.php'; // Kết nối CSDL

// Hàm gửi email từ email của người đăng nhập hiện tại đến chủ khoa tương ứng
function sendEmailToCoordinator($student_email, $subject, $message) {
    global $conn;

    // Truy vấn để lấy email của sinh viên từ cơ sở dữ liệu
    $query = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $student_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra xem có kết quả trả về hay không
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_email = $row['email']; // Lấy địa chỉ email từ kết quả truy vấn

        // Gửi email tới chủ khoa
        $sent = sendEmail($student_email, $_SESSION['email'], $subject, $message); // Gọi hàm gửi email
        if ($sent) {
            echo "Email đã được gửi đi thành công!";
        } else {
            echo "Gửi email thất bại!";
        }
    } else {
        echo "Không tìm thấy thông tin người dùng.";
    }
}

// Hàm gửi email sử dụng PHP's mail() function
function sendEmail($to, $from, $subject, $message) {
    // Tạo header của email
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "Content-type: text/html\r\n";

    // Gửi email
    return mail($to, $subject, $message, $headers);
}

// Sử dụng hàm sendEmailToCoordinator để gửi email tới chủ khoa từ email của người đăng nhập
// $student_email là email của người đăng nhập, $subject là tiêu đề email, $message là nội dung email
// Cần chú ý rằng, $student_email được truyền từ session
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
sendEmailToCoordinator($_SESSION['email'], $subject, $message);
?>
