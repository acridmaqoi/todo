<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/login.css">

    <title>Login</title>
</head>

<body class="background">
    <div class="login-box">
        <div class="login-panel" style="display: block;">
            <div class="form">
                <h1>Login</h1>
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
                <div id="form-messages" class="form-messages">
                    <?php
                    if (isset($_GET["verify_email"])) {
                        echo "Check your email for a verification link";
                    }
                    if (isset($_GET["password_reset"])) {
                        echo "Your password has now been reset you can now login";
                    }
                    ?>
                </div>
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
                    const li = document.createElement('p');
                    console.log(message)
                    li.textContent = message;
                    form.messages.appendChild(li);
                });
            }
        }
    </script>

    </div>




</body>

</html>