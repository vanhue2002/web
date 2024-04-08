<?php
require_once('authentication.php');
// require_once('header.php');
include '../header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
*
{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Quicksand', sans-serif;
}

body 
{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #000;
}

section 
{
  position: absolute;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 2px;
  flex-wrap: wrap;
  overflow: hidden;
}

section::before 
{
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(#000,#0f0,#000);
  animation: animate 5s linear infinite;
}

@keyframes animate 
{
  0% { transform: translateY(-100%); }
  100% { transform: translateY(100%); }
}

section span 
{
  position: relative;
  display: block;
  width: calc(6.25vw - 2px);
  height: calc(6.25vw - 2px);
  background: #181818;
  z-index: 2;
  transition: 1.5s;
}

section span:hover 
{
  background: #0f0;
  transition: 0s;
}

/* New CSS for sidebar navigation */
.sidebar {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  height: auto;
  width: 200px; /* Adjust width as needed */
  background-color: #222;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Box shadow */
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

.sidebar ul li a:hover {
  background-color: #0f0;
}

.signin {
  margin-left: 220px; /* Adjust the margin to accommodate the sidebar width */
}

.signin .content {
  /* Your existing content styles */
}

.signin .content > div {
  width: 100%;
  display: flex;
  justify-content: center;
}

.signin .content > div > div {
  margin: 0 10px;
}

.signin .content > div > div a {
  color: #0f0;
  text-decoration: none;
  font-size: 1.5em;
  font-weight: 500;
}

    </style>
</head>
<body>
    <section>
        <div class="signin">
            <div class="content">

            <nav class="sidebar">
            <ul>
              <li><a href="manage_event.php">Manage Events</a></li>
              <li>
              <a href="create_faculty.php">Create Facultys</a>
              </li>
              <li><a href="create_event.php">Create Events</a></li>
              <li><a href="manage_faculty.php">Manage Faculty</a></li>
              <li><a href="../register/register_admin_process.php">Register</a></li>
            </ul>
          </nav>
            


    
            </div>
        </div>
    </section>
</body>
</html>