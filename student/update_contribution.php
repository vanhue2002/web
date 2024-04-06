<?php
session_start();
require_once('../config.php');
require_once('../login/header.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['contribution_id'])) {
    echo "Contribution ID không hợp lệ.";
    exit();
}

$contribution_id = $_GET['contribution_id'];

$sql = "SELECT * FROM contributions WHERE contribution_id = '$contribution_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Không tìm thấy đóng góp.";
    exit();
}

$row = mysqli_fetch_assoc($result);
$title = $row['title'];
$content = $row['content'];
$file_path = $row['file_path'];

if ($_SESSION['user_id'] != $row['user_id']) {
    echo "Bạn không có quyền truy cập vào đóng góp này.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_content = $_POST['content'];
    $file_changed = false;

    if ($_FILES["file"]["size"] > 0) {
        unlink($file_path);
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["file"]["size"] > 5000000) {
            echo "Tệp quá lớn.";
            $uploadOk = 0;
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Chỉ chấp nhận các tệp JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Có lỗi xảy ra khi tải lên.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $file_path = $target_file;
                $file_changed = true;
                echo "Tệp " . htmlspecialchars(basename($target_file)) . " đã được tải lên thành công.";
            } else {
                echo "Có lỗi xảy ra khi tải lên.";
            }
        }
    }

    $update_sql = "UPDATE contributions SET title = '$new_title', content = '$new_content'";
    if ($file_changed) {
        $update_sql .= ", file_path = '$file_path'";
    }
    $update_sql .= ", updated_at = NOW() WHERE contribution_id = '$contribution_id'";
    if (mysqli_query($conn, $update_sql)) {
      echo "<script type='text/javascript'>alert('Contribution cập nhật thành công!'); window.location.href='./manage_contribution.php';</script>";

    } else {
        echo "Lỗi: " . $update_sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật đóng góp</title>
    <link rel="stylesheet" href="./css/update_contribution.css">
    <style>
          
    </style>
</head>
<body>
    <h2>Cập nhật đóng góp</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?contribution_id=' . $contribution_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Tiêu đề:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required><br><br>
        <label for="content">Nội dung:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required><?php echo $content; ?></textarea><br><br>
        <label for="file">Tệp đính kèm:</label><br>
        <input type="file" id="file" name="file" accept="image/*"><br><br>
        <button type="submit">Cập nhật</button>
    </form>
    <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
