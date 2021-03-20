<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/form.css">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <div class="form">
        <label>
            <input id="username" placeholder="Username" spellcheck="false">
        </label>
        <label>
            <input id="password" placeholder="Password" type='password'>
        </label>

        <button id="btn-submit" type="submit" >Confirm</button>
        <a id="form-messages"></a>
        
        <?php 
        if (isset($_GET["verify_email"])) {
            echo "Check your email for a verification link";
        }
        if (isset($_GET["password_reset"])) {
            echo "Your password has now been reset you can now login";
        }
        ?>

    </div>
    
    <br>
    <a href="register.html">Create Account</a>
    <a href="reset_password.html">Forgot password?</a>

    <script>
         // allows enter button to be used when submitting form
         document.querySelector("#password").addEventListener("keyup", event => {
                if(event.key !== "Enter") return;
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
    

</body>

</html>