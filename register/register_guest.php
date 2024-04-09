<!-- register_guest.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest register</title>
    <link rel="stylesheet" href="../login/css/style.css">
    <style>
       
    

        h2 {
            font-size: 2em;
            color: #0f0;
            text-transform: uppercase;
            text-align: center;
            padding: 40px;
        }

        

        form label {
            color: #fff;
            margin-bottom: 10px; 
        }
        form input[type="text"],
        form input[type="password"],
        form select {
            width: 100%;
            background: #333;
            border: none;
            outline: none;
            padding: 15px 10px; 
            border-radius: 4px;
            color: #fff;
            font-weight: 500;
            font-size: 1em;
            margin-bottom: 20px; 
        }

        form select {
            appearance: none;
        }

        form button[type="submit"] {
            padding: 10px;
            background: #0f0;
            color: #000;
            font-weight: 600;
            font-size: 1.35em;
            letter-spacing: 0.05em;
            cursor: pointer;
        }

        form button[type="submit"]:active {
            opacity: 0.6;
        }
    </style>
</head>
<body>
    
    
    <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
        <div class="signin">
            <div class="content">
            
    <form action="register_guest_process.php" method="POST">
    <h2>GUEST REGISTER</h2>
        <label for="username">Username:</label><br><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="faculty">Faculty:</label><br><br>
        <select id="faculty" name="faculty" required>
            <?php
            require_once('../config.php');
            $query = "SELECT * FROM faculties";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['faculty_name'] . "'>" . $row['faculty_name'] . "</option>";
            }

            mysqli_close($conn);
            ?>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
                </div>
            </div>
        </div>
    </section>
    

    
</body>
</html>
