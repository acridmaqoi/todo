<?php

require_once 'util/account/auth.php';

include_once 'autoloader.php';
auth(false);

if (isset($_GET['code'])) {
	$access_token = get_access_token($_GET['code']);
	echo '<pre>';
	print_r($access_token);
	die();
}

if (isset($_SESSION['logged_in'])) {

    echo "logged in";
    // header('Location: http://localhost/project-1/main/list.php');
} else {
    echo "logged out";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="415251980402-68khrcjsbsmncrutho9fismb3k09965i.apps.googleusercontent.com">

    <script async defer crossorigin="anonymous" 
        src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&autoLogAppEvents=1&version=v10.0&appId=3788291791291201" nonce="ORgkv8Zq"></script>



    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/login.css">

    <title>Login</title>
</head>

<body class="background">
    


    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '{3788291791291201}',
                cookie: true,
                xfbml: true,
                version: '{v10.0}'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

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
                <div class="login-checkbox">
                    <input id="remember" type="checkbox" style="float: left; margin-top: 1.8px;"></input>
                    <div style="margin-left: 25px;">Stay logged-in</div>
                </div>
                <div class="login-button">
                    <button id="btn-submit" class="btn btn-primary form-block" type="submit">Confirm</button>
                </div>

                <div class="g-signin2" data-redirecturi="http://localhost/main/list.php" data-onsuccess="onSignIn"></div>

                <div class="login-item">
                    <a href="<?php echo get_facebook_login_url(); ?>" class="a-fb">
                        <div class="fb-button-container">
                            Login with Facebook
                        </div>
                    </a>
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
    
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

            var id_token = googleUser.getAuthResponse().id_token;

            console.log(id_token);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'util/account/thirdparty/google.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Signed in as: ' + xhr.responseText);
            };
            xhr.send('idtoken=' + id_token);

            xhr.onload = () => {
                location.href = 'main/list.php';
            }

        }


        // allows enter button to be used when submitting form
        document.querySelector("#password").addEventListener("keyup", event => {
            if (event.key !== "Enter") return;
            document.querySelector("#btn-submit").click();
            event.preventDefault();
        });

        const form = {
            username: document.getElementById('username'),
            password: document.getElementById('password'),
            remember: document.getElementById('remember'),
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

            const requestData = `username=${form.username.value}&password=${form.password.value}&remember=${form.remember.checked}`;

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
        <script>
            $("#form-messages").append("Check your email for a verification link");
        </script>
    <?php }
    if (isset($_GET["password_reset"])) { ?>
        <script>
            $("#form-messages").append("Your password has now been reset you can now login");
        </script>
    <?php } ?>



    </div>




</body>

</html>