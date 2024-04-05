<?php
session_start();
require_once('../config.php');
require_once('../send_notification.php'); 
if (isset($_SESSION['user_id'])) {
    $title = $_POST['title'];
    $contribution = $_POST['contribution'];
    $user_id = $_SESSION['user_id'];

    $event_id = $_SESSION['selected_event_id'];
    $get_submission_end_date_query = "SELECT submission_end_date FROM events WHERE event_id = $event_id";
    $result = mysqli_query($conn, $get_submission_end_date_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $submission_end_date = strtotime($row['submission_end_date']);
        $current_date = time();

        if ($current_date > $submission_end_date) {
            echo "Bạn không thể nộp đóng góp sau ngày đóng cửa.";
        } else {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); 
            }

            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if ($_FILES["file"]["size"] > 500000000) {
                echo "Tệp quá lớn.";
                $uploadOk = 0;
            }

            $imageFileExtensions = array("jpg", "jpeg", "png", "gif");
            if (!in_array($imageFileType, $imageFileExtensions) && $imageFileType != "zip") {
                echo "Chỉ chấp nhận các tệp JPG, JPEG, PNG, GIF hoặc ZIP.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Có lỗi xảy ra khi tải lên.";
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được tải lên thành công.";

                    $event_id = $_SESSION['selected_event_id'];
                    $sql = "INSERT INTO contributions (event_id, user_id, title, content, file_path, status, created_at, updated_at) 
                            VALUES ('$event_id', '$user_id', '$title', '$contribution', '$target_file', 'submitted', NOW(), NOW())";

                    if (mysqli_query($conn, $sql)) {
      echo "<script type='text/javascript'>alert('Ghi đóng góp vào cơ sở dữ liệu thành công.'); window.location.href='./manage_contribution.php';</script>";


                        

                    } else {
                        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    $subject = "New contribution submitted";
                    $message = "A new contribution has been submitted by a student. Please review it in the coordinator dashboard.";
                    sendEmailToCoordinator($_SESSION['email'], $subject, $message);
                } else {
                    echo "Có lỗi xảy ra khi tải lên.";
                }
            }
        }
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
} else {
    echo "Phiên đăng nhập chưa được bắt đầu hoặc biến 'user_id' không tồn tại trong phiên.";
}

mysqli_close($conn);
?>
