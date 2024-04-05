<?php
session_start(); // Bắt đầu phiên đăng nhập

require_once('../config.php');
require_once('authentication.php');

// Kiểm tra phiên đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "Phiên đăng nhập chưa được bắt đầu hoặc biến 'user_id' không tồn tại trong phiên.";
    exit();
}

// Tiếp tục xử lý dữ liệu đóng góp
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $contribution = $_POST['contribution'];
    $user_id = $_SESSION['user_id'];
    $event_id = $_SESSION['selected_event_id'];

    // Kiểm tra ngày đóng cửa của sự kiện
    $get_submission_end_date_query = "SELECT submission_end_date FROM events WHERE event_id = ?";
    $stmt_submission_end_date = $conn->prepare($get_submission_end_date_query);
    $stmt_submission_end_date->bind_param("i", $event_id);
    $stmt_submission_end_date->execute();
    $stmt_submission_end_date->store_result();

    if ($stmt_submission_end_date->num_rows > 0) {
        $stmt_submission_end_date->bind_result($submission_end_date);
        $stmt_submission_end_date->fetch();

        // Kiểm tra ngày hiện tại có vượt quá ngày đóng cửa không
        if (strtotime($submission_end_date) < time()) {
            echo "Bạn không thể nộp đóng góp sau ngày đóng cửa.";
            exit();
        }
    } else {
        echo "Không tìm thấy sự kiện.";
        exit();
    }

    // Lấy tên sự kiện từ cơ sở dữ liệu và lưu vào session
    $get_event_name_query = "SELECT event_name FROM events WHERE event_id = ?";
    $stmt_event_name = $conn->prepare($get_event_name_query);
    $stmt_event_name->bind_param("i", $event_id);
    $stmt_event_name->execute();
    $stmt_event_name->store_result();

    if ($stmt_event_name->num_rows > 0) {
        $stmt_event_name->bind_result($selected_event_name);
        $stmt_event_name->fetch();
        $_SESSION['selected_event_name'] = $selected_event_name;
    } else {
        echo "Không tìm thấy thông tin về sự kiện.";
        exit();
    }

    // Xử lý tệp tải lên
    $target_dir = "uploads/";

    // Kiểm tra xem thư mục có tồn tại không
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $uploadOk = 1;

    // Khởi tạo mảng để lưu trữ đường dẫn các tệp tải lên
    $file_paths = array();

    // Lặp qua từng file được tải lên
    foreach ($_FILES["file"]["tmp_name"] as $index => $tmp_name) {
        $target_file = $target_dir . basename($_FILES["file"]["name"][$index]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["file"]["size"][$index] > 500000000) {
            echo "Tệp quá lớn.";
            $uploadOk = 0;
            continue; // Chuyển sang file tiếp theo
        }

        $imageFileExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $imageFileExtensions) && $imageFileType != "zip") {
            
            $uploadOk = 0;
            continue; // Chuyển sang file tiếp theo
        }

        if ($uploadOk == 0) {
            echo "Có lỗi xảy ra khi tải lên.";
        } else {
            if (move_uploaded_file($tmp_name, $target_file)) {
                echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được tải lên thành công.";
                $file_paths[] = $target_file; // Lưu đường dẫn tệp vào mảng
            } else {
                echo "Có lỗi xảy ra khi tải lên.";
            }
        }
    }

    // Thêm thông tin đóng góp vào cơ sở dữ liệu
    $status = "submitted";
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Chuyển mảng đường dẫn thành một chuỗi để lưu vào trường file_path
    $file_paths_str = implode(',', $file_paths);

    $sql = "INSERT INTO contributions (event_id, user_id, title, content, file_path, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW(), updated_at)";
    $stmt_insert_contribution = $conn->prepare($sql);
    $stmt_insert_contribution->bind_param("iissss", $event_id, $user_id, $title, $contribution, $file_paths_str, $status);



    if ($stmt_insert_contribution->execute()) {
        echo "Ghi đóng góp vào cơ sở dữ liệu thành công.";

        // Lấy thông tin người gửi và tiếp tục xử lý email
        // Lấy thông tin người gửi
        $get_sender_info_query = "SELECT username, email, faculty_name FROM users WHERE user_id = ?";
        $stmt_sender_info = $conn->prepare($get_sender_info_query);
        $stmt_sender_info->bind_param("i", $user_id);
        $stmt_sender_info->execute();
        $stmt_sender_info->store_result();

        if ($stmt_sender_info->num_rows > 0) {
            $stmt_sender_info->bind_result($sender_username, $sender_email, $sender_faculty_name);
            $stmt_sender_info->fetch();
        }

        // Lấy thông tin người nhận (chủ khoa của khoa của sinh viên)
        $get_marketing_coordinator_info_query = "SELECT email FROM users WHERE role = 'Marketing Coordinator' AND faculty_name = ?";
        $stmt_marketing_coordinator_info = $conn->prepare($get_marketing_coordinator_info_query);
        $stmt_marketing_coordinator_info->bind_param("s", $sender_faculty_name);
        $stmt_marketing_coordinator_info->execute();
        $stmt_marketing_coordinator_info->store_result();

        if ($stmt_marketing_coordinator_info->num_rows > 0) {
            $stmt_marketing_coordinator_info->bind_result($marketing_coordinator_email);
            $stmt_marketing_coordinator_info->fetch();

            // Gửi email thông báo
            require '../send_email.php';
        } else {
            echo "Không tìm thấy chủ khoa cho khoa " . $sender_faculty_name;
        }
    } else {
        echo "Lỗi khi thêm đóng góp vào cơ sở dữ liệu: " . $stmt_insert_contribution->error;
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
