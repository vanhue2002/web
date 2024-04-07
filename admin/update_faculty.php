<?php
// Kết nối database
require_once('../config.php');
require_once('authentication.php');
require_once('header.php');

// Kiểm tra xem có tham số faculty_id được truyền vào không
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Kiểm tra xem có dữ liệu được gửi từ biểu mẫu hay không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu và làm sạch dữ liệu
        $faculty_name = mysqli_real_escape_string($conn, $_POST['faculty_name']);

        // Bắt đầu một giao dịch
        mysqli_begin_transaction($conn);

        // Truy vấn SQL để cập nhật thông tin khoa
        $query = "UPDATE faculties SET faculty_name = '$faculty_name' WHERE faculty_id = $faculty_id";

        // Thực thi câu lệnh cập nhật trong bảng faculties
        if (mysqli_query($conn, $query)) {
            // Cập nhật trường faculty_name trong bảng events
            $update_events_query = "UPDATE events SET faculty_name = '$faculty_name' WHERE faculty_name = (SELECT faculty_name FROM faculties WHERE faculty_id = $faculty_id)";
            mysqli_query($conn, $update_events_query);

            // Cập nhật trường faculty_name trong bảng users
            $update_users_query = "UPDATE users SET faculty_name = '$faculty_name' WHERE faculty_name = (SELECT faculty_name FROM faculties WHERE faculty_id = $faculty_id)";
            mysqli_query($conn, $update_users_query);

            // Nếu tất cả các câu lệnh đều thành công, hoàn tất giao dịch
            mysqli_commit($conn);
            echo "<script>alert('The faculty has been updated successfully!'); window.history.back();</script>";
        } else {
            // Nếu câu lệnh cập nhật trong bảng faculties thất bại, hủy bỏ giao dịch
            mysqli_rollback($conn);
            echo "<script>alert('An error occurred while updating the faculty: '); window.history.back();</script>" . mysqli_error($conn);
        }
    }

    // Truy vấn để lấy thông tin của khoa dựa trên faculty_id
    $faculty_query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $faculty_result = mysqli_query($conn, $faculty_query);

    // Hiển thị biểu mẫu để cập nhật thông tin khoa
    if (mysqli_num_rows($faculty_result) == 1) {
        $row = mysqli_fetch_assoc($faculty_result);
?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update faculty</title>
            <link rel="stylesheet" href="./css/style.css">
            <style>
                /* CSS cho thẻ h2 */
section .signin .container h2 {
  font-size: 2em;
  color: #0f0;
  text-transform: uppercase;
}

/* CSS cho thẻ label */
section .signin .container form label {
  color: #fff;
}

/* CSS cho các trường nhập liệu input và select */
section .signin .container form input[type="text"],
section .signin .container form input[type="date"],
section .signin .container form select {
  width: 100%;
  background: #333;
  border: none;
  outline: none;
  padding: 15px 10px;
  border-radius: 4px;
  color: #fff;
  font-weight: 500;
  font-size: 1em;
  text-align: center;
}

/* CSS cho nút gửi dữ liệu input[type="submit"] */
section .signin .container form input[type="submit"] {
  padding: 10px;
  background: #0f0;
  color: #000;
  font-weight: 600;
  font-size: 1.35em;
  letter-spacing: 0.05em;
  cursor: pointer;
}
section .signin .container form {
  text-align: center;
}
/* CSS cho nền của input[type="submit"] khi được nhấn */
input[type="submit"]:active {
  opacity: 0.6;
}

            </style>
        </head>
        <body>
            <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 
            <div class="signin">
        <div class="container">
            <h2>UPDATE FACULTY</h2>
            <form method="post">
                <label for="faculty_name">Faculty name:</label><br>
                <input type="text" id="faculty_name" name="faculty_name" value="<?php echo $row['faculty_name']; ?>"><br><br>
                <input type="submit" value="Update">
            </form>
        </div>
        </div>
        </section>
        </body>
        </html>
<?php
    } else {
        echo "Faculty does not exist.";
    }
} else {
    echo "Faculty ID not provided.";
}

// Đóng kết nối database
mysqli_close($conn);
?>

