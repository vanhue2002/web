<?php
require_once('../login/header.php');
?>
<!-- register_admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản cho Admin</title>
    <link rel="stylesheet" href="../../login/css/login.css">

<style>
    /*Hover to reveal a description of the book */

/* Source code:
https://github.com/robole/artifice
*/

@import url('https://fonts.googleapis.com/css2?family=Pontano+Sans&family=Stint+Ultra+Expanded&display=swap');

:root{
  --perspective: 1000px;
  --link-color:#010790;
}

* {
	box-sizing: border-box;
}

body{
  background-image: url('https://img.lovepik.com/photo/40150/9846.jpg_wh860.jpg'); /* Thay đổi 'background_image.jpg' thành đường dẫn tới hình ảnh nền của bạn */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  font-family: 'Pontano Sans', sans-serif;
  font-size: calc(0.65em + .05vw);
}

a{
  color:var(--link-color);
  font-weight:bold;
}

h1{
  font-family: 'Stint Ultra Expanded', cursive;
  font-size: 1.5em;
  text-align: center;
}

.book {
  display: block;
  position: relative;
  width: 320px;
	height:453px;
  margin:0 auto;
	margin-top: 5rem;
}

.gloss{
  position: absolute;
  top:0;
	z-index:200;
  overflow: hidden;
  width:20%;
  height:100%;
  opacity:0.5;
  background: linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,0.2), rgba(255,255,255,0));
  transition:all .5s;
  transform: translateX(-50%) rotateY(0deg);
  transform-origin: left center;
}

.cover {
	position: absolute;
  width:100%;
	z-index:100;
  transition:transform .5s;
  transform: translateX(0);
  transform-origin: left center;
  backface-visibility: hidden;
}

.description{
  position: absolute;
  left:0;
  top:0;
  width:inherit;
  height:inherit;
	border: solid 1px grey;
	background:white;
	transition: all 1s;
	padding: 10% 10%;
  padding-top:5%;
  z-index:1;
}

.description h1{
  font-family: 'Pontano Sans', sans-serif;
	font-size: calc(0.75em + .1vw);
  text-align: center;
  line-height: 1.25em;
}

.book:hover{
		cursor: pointer;
}

.book:hover .cover {
    transform: perspective(var(--perspective)) rotateY(-80deg);
}

.book:hover .gloss {
    transform: perspective(var(--perspective)) rotateY(-80deg) translateX(100%) scaleX(5);
}

.book:hover .description {
    transform: translateX(20%);
}

.rating {
  unicode-bidi: bidi-override;
  direction: rtl;
  text-align: center;
  height:2em;
  margin:0 auto;
  color:grey;
}

.rating > span {
  display: inline-block;
  position: relative;
  font-size: 1.75em;
  margin-right:.2em;
}

.rating > span ~ span:before {
   content: "\2605";
   position: absolute;
   color:#8d2a06;
}
form {
  margin-top: 20px;
  width: 300px;
  margin: 0 auto;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
input[type="username"],

input[type="text"],
input[type="password"],
input[type="email"],
select {
    width: 80%;
    padding: 10px;
    border: none;
    background-color: #f5f5f5;
    font-family: 'Pontano Sans', sans-serif;
    font-size: 1em;
    color: #333;
    border-radius: 5px;
    transition: background-color .3s ease;
}
input[type="username"],
input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
select:focus {
    background-color: #e4e4e4;
    outline: none;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 80%;
    font-family: 'Pontano Sans', sans-serif;
    font-size: 1em;
    transition: background-color .3s ease;
}

button[type="submit"]:hover {
    background-color: #45a049;
}
.error {
  color: red;
}
footer {
    position: fixed; /* Đặt vị trí của footer */
    bottom: 0; /* Đặt ở dưới cùng */
    width: 100%; /* Chiều rộng tương đương với phần nội dung */
    background-color: #343a40;
    color: #fff;
    text-align: center;
  } 
</style>
</head>
<body>
<div id="handmaid" class="book">
    <div class="gloss"></div>
    <img class="cover" src="https://raw.githubusercontent.com/robole/artifice/main/shiny-book-reveal/img/cover.png">
    <div class="description">
    <h2>Đăng ký tài khoản cho Khách hàng</h2>
    
   <div>
   
    

    <form action="register_guest_process.php" method="POST">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Đăng ký</button>
    </form>
    </div>
       
    </div>
   
  </div>
  <h1>The Handmaid's Tale</h1>
        <div class="rating">
    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
  </div>
   <footer>
    <p>&copy; <?php echo date("Y"); ?> ASM4 Team</p>
  </footer>
</body>
</html>
