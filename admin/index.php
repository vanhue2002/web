<?php
require_once('authentication.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
      /* Import CSS từ Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

/* Thiết lập CSS cơ bản */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Quicksand', sans-serif;
}

/* Thiết lập body */
body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #000;
  padding-top: 160px; /* Dịch chuyển nội dung trang xuống dưới header */
}

/* Thiết lập section */
section {
  position: absolute;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 2px;
  flex-wrap: wrap;
  overflow: visible;
}

/* Thiết lập animation */
section::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(#000,#0f0,#000);
  animation: animate 5s linear infinite;
}

/* Thiết lập animation keyframes */
@keyframes animate {
  0% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(100%);
  }
}

/* Thiết lập các ô vuông */
section span {
  position: relative;
  display: block;
  width: calc(6.25vw - 2px);
  height: calc(6.25vw - 2px);
  background: #181818;
  z-index: 2;
  transition: 1.5s;
}

/* Thiết lập hover cho ô vuông */
section span:hover {
  background: #0f0;
  transition: 0s;
}


.sidebar {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  height: auto;
  width: 200px; 
  background-color: #222;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar ul li {
  margin-bottom: 10px;
}

.sidebar ul li a {
  display: block;
  padding: 10px;
  color: #fff;
  text-decoration: none;
}

/* Thiết lập liên kết "Signup" */
.signin .content .form .links a:nth-child(2) {
  color: #0f0;
  font-weight: 600;
}

/* Thiết lập nút submit */
.signin .content .form .inputBox input[type="submit"] {
  padding: 10px;
  background: #0f0;
  color: #000;
  font-weight: 600;
  font-size: 1.35em;
  letter-spacing: 0.05em;
  cursor: pointer;
}

/* Thiết lập hiệu ứng khi click */
input[type="submit"]:active {
  opacity: 0.6;
}

/* Media query cho màn hình nhỏ */
@media (max-width: 900px) {
  section span {
    width: calc(10vw - 2px);
    height: calc(10vw - 2px);
  }
}

/* Media query cho màn hình rất nhỏ */ 
@media (max-width: 600px) {
  section span {
    width: calc(20vw - 2px);
    height: calc(20vw - 2px);
  }
}
.signin .content .form .links {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .signin .content .form .links .menu-item {
    padding: 15px 25px;
    background-color: #0f0;
    color: #000;
    font-weight: 600;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .signin .content .form .links .menu-item:hover {
    background-color: #090;
  }
  
  /* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
  }
  
  table th, table td {
    padding: 10px;
    border: 1px solid #fff;
    color: #fff;
  }
  
  table th {
    background: rgb(1, 53, 1);
  }
  
  table td {
    background: #333;
  }
  
  /* Link Styles */
  a {
    color: #0f0;
    text-decoration: none;
  }
  
  a:hover {
    color: #fff;
    text-decoration: underline;
  }

    </style>
</head>
<body>
    <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 
    <div class="signin">
  <div class="content">
    <div class="dashboard">
      <h2 class="dashboard-title">ADMIN DASHBOARD</h2>
    </div>
    <div class="form">                  
      <div class="links">
        <button class="menu-item" onclick="location.href='manage_event.php'">Manage Events</button>
        <br>
        <button class="menu-item" onclick="location.href='create_faculty.php'">Create Faculties</button>
        <br>
        <button class="menu-item" onclick="location.href='create_event.php'">Create Events</button>
        <br>
        <button class="menu-item" onclick="location.href='manage_faculty.php'">Manage Faculty</button>
        <br>
        <button class="menu-item" onclick="location.href='../register/register_admin_process.php'">Register</button>
      </div>
    </div>
  </div>
</div>


    </section> 
</body>
</html>