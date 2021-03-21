<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/login.css">
    <title>Login</title>
</head>

<body class="background">
    <div class="welcome-box">
        <div class="welcome-panel" style="display: block;">
            <ul class="welcome-hud">
                <li>
                    <a href="">Login</a>
                </li>
                <li>
                    <a href="">Third-party</a>
                </li>
            </ul>
            <div class="login-form">
                <div class="login-item">
                    <label for="user" class="item-label"><i class="icon icon-user"></i></label>
                    <input id="username" class="input" spellcheck="false" placeholder="Username">
                </div>
                <div class="login-item">
                    <label for="user" class="item-label"><i class="icon icon-user"></i></label>
                    <input id="password" class="input" type='password' placeholder="Password">
                </div>
                <div class="login-button">
                    <button id="btn-submit" class="btn btn-primary form-block" type="submit">Confirm</button>
                </div>
                <div id="form-messages" class="form-messages"></div>
                <div class="login-options">
                    <a href="register.html">Create Account</a>
                    |
                    <a href="reset_password.html">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>
        
    <script>
        // allows enter button to be used when submitting form
        document.querySelector("#password").addEventListener("keyup", event => {
            if (event.key !== "Enter") return;
            document.querySelector("#btn-submit").click();
            event.preventDefault();
        });

        const form = {
            username: document.getElementById('username'),
            password: document.getElementById('password'),
            submit: document.getElementById('btn-submit'),
            messages: document.getElementById('form-messages')
        };

        form.submit.addEventListener('click', () => {
            const request = new XMLHttpRequest();

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

            const requestData = `username=${form.username.value}&password=${form.password.value}`;

            // send to server
            request.open('post', 'util/account/login.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(requestData);
        });

        function handleResponse(responseObject) {
            //prevents duplicate messages
            while (form.messages.firstChild) {
                form.messages.removeChild(form.messages.firstChild);
            }

            if (responseObject.ok) {
                location.href = 'main/list.php'
            } else {
                // user entered incorrect details
                responseObject.messages.forEach((message) => {
                    // const li = document.createElement('p');
                    // console.log(message)
                    // li.textContent = message;
                    // form.messages.appendChild(li);

                    $("#form-messages").append(message);
                });
            }
        }

        </script>


        <?php
        if (isset($_GET["verify_email"])) { ?>
            <script>$("#form-messages").append("Check your email for a verification link");</script>    
        <?php }
        if (isset($_GET["password_reset"])) { ?>
            <script>$("#form-messages").append("Your password has now been reset you can now login");</script>
        <?php } ?>

    

    </div>




</body>

</html>





