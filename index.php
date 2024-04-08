<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
</head>
<body>
    <h1>Xin chào! Vui lòng đăng nhập để tiếp tục.</h1>   
    <button onclick="redirectToLoginPage()">Đăng nhập</button>

    <script>
        function redirectToLoginPage() {
            window.location.href = "login/login.php";
        }
    </script>
    <p>Nếu bạn là Guest, cần phải đăng ký để tiếp tục</p>
    <a href="register">Register</a>
</body>
</html>


