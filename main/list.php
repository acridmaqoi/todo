<?php 
require '../controllers/auth.php';
require 'C:\xampp\htdocs\project-1\main\db_utils.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="list.css">
    <title>清单</title>
</head>

<body>
    <nav class="topnav">
        <div>
            <h1>清单</h1>
            <a href="profile/profile.php"><?php echo get_username() ?></a>
            <a href="logout.php">登出</a>
        </div>
    </nav>
    <div class="content">
        <input type="text" id="myInput" placeholder="标题...">
        <button onclick="newElement()" class="addBtn">加</button>

        <ul id="myUL">
            <li>Hit the gym</li>
            <li class="checked">Pay bills</li>
            <li>Meet George</li>
            <li>Buy eggs</li>
            <li>Read a book</li>
            <li>Organize office</li>
        </ul>

        <script defer src="list.js"></script>
    </div>
</body>

</html>