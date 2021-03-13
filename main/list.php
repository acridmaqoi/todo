<?php

require_once '../config/db.php';
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
    <nav class="navtop">
        <a href="profile/profile.php"><?php echo get_username() ?></a>
        <a href="logout.php">登出</a>
    </nav>

    <h1>清单</h1>

    <div class="form">
        <input id="title" type="text" placeholder="标题...">
        <button id="btn-submit" type="submit" class="addBtn">加</button>
        <ul id="form-messages"></ul>
    </div>

    <script>
        // allows enter button to be used when submitting form
        document.querySelector("#title").addEventListener("keyup", event => {
            if (event.key !== "Enter") return;
            document.querySelector("#btn-submit").click();
            event.preventDefault();
        });

        const form = {
            title: document.getElementById('title'),
            submit: document.getElementById('btn-submit'),
            messages: document.getElementById('form-messages')
        };

        form.submit.addEventListener('click', () => {
            const request = new XMLHttpRequest();
            const requestData = `title=${form.title.value}`;

            request.onload = () => {
                let responseObject = null;

                try {
                    // response json from server
                    responseObject = JSON.parse(request.responseText)
                } catch (e) {
                    console.error('Could not parse JSON!')
                }

                if (responseObject) {
                    handleResponse(responseObject)
                }
            };

            // send to server
            request.open('post', '../account/add_task.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(requestData);
        });

        function handleResponse(responseObject) {
            //prevents duplicate messages
            while (form.messages.firstChild) {
                form.messages.removeChild(form.messages.firstChild);
            }

            if (!responseObject.ok) {
                responseObject.messages.forEach((message) => {
                    const li = document.createElement('p');
                    console.log(message)
                    li.textContent = message;
                    form.messages.appendChild(li);
                });
            }
        }
    </script>



    <div class="list">

        <ul id="myUL">

            <?php

            $tasks = mysqli_query($con, "SELECT * FROM tasks WHERE user_id = " . $_SESSION["id"]);

            $i = 1;
            while ($row = mysqli_fetch_array($tasks)) {

            
            ?>

                <li><?php echo $i; ?></li>
                <!-- <li class="checked">Pay bills</li>
                <li>Meet George</li>
                <li>Buy eggs</li>
                <li>Read a book</li>
                <li>Organize office</li> -->
        </ul>
    <?php $i++;
            } ?>

    <script defer src="list.js"></script>
    </div>
</body>

</html>