<?php

require __DIR__ . '/autoloader.php';
require __DIR__ . '/util/account/auth.php';
require __DIR__ . '/lib/Facebook/facebook_api.php';
require __DIR__ . '/util/account/thirdparty/facebook_login.php';

auth(false);

if (isset($_GET['state']) && FB_APP_STATE == $_GET['state']) {
    facebook_login($_GET);
    header('location: http://localhost/project-1/main/list.php');
}

if (isset($_SESSION['logged_in'])) {
    echo "logged in";
    header('Location: http://localhost/project-1/main/list.php');
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
    <script src="https://apis.google.com/js/api:client.js"></script>

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
                <div class="login-checkbox">
                    <input id="remember" type="checkbox" style="float: left; margin-top: 1.8px;"></input>
                    <div style="margin-left: 25px;">Stay logged-in</div>
                </div>
                <div class="login-button login-item">
                    <button id="btn-submit" class="btn btn-primary form-block" type="submit">Confirm</button>
                </div>

                <div class="g-signin2" data-redirecturi="http://localhost/main/list.php" data-onsuccess="onSignIn"></div>

                <div id="form-messages" class="form-messages"></div>



                <div class="flex justify-center items-center mb-6">
                    <a href="<?php echo get_facebook_login_url(); ?>">
                        <div class="">
                            <style>
                                .facebookButt {
                                    background-color: #1877F2;
                                }

                                .facebookButt:hover {
                                    background-color: #1E6CD2;
                                }

                                .facebookSvg:hover,
                                .facebookButt:hover .facebookSvg {
                                    fill: #1E6CD2;
                                }
                            </style>
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="#1877F2" xmlns="http://www.w3.org/2000/svg" class="facebookSvg cursor-pointer">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40 20.122C40 9.01 31.046 0 20 0S0 9.009 0 20.122C0 30.166 7.314 38.49 16.875 40V25.939h-5.078v-5.817h5.078V15.69c0-5.043 2.986-7.829 7.554-7.829 2.189 0 4.477.393 4.477.393v4.952h-2.522c-2.484 0-3.259 1.551-3.259 3.143v3.774h5.547l-.887 5.817h-4.66V40C32.686 38.49 40 30.166 40 20.122z"></path>
                            </svg>
                        </div>
                    </a>

                    <div id="google-signin" style="cursor: pointer" class="ml-4">
                        <style>
                            .googleButt {
                                background-color: #1877F2;

                            }

                            .googleButt:hover {
                                background-color: #bdbdbd;
                            }

                            .googleSvg:hover,
                            .googleButt:hover .googleSvg {
                                fill: #bdbdbd;
                            }
                        </style>

                        <svg width="40" height="40" viewBox="0 0 40 40" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" class="googleSvg cursor-pointer">
                            <circle cx="50%" cy="50%" r="20" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20 13.867c1.878 0 3.145.81 3.867 1.489l2.822-2.756C24.956 10.989 22.7 10 20 10a9.993 9.993 0 00-8.933 5.511l3.233 2.511c.811-2.41 3.056-4.155 5.7-4.155z" fill="#EA4335" stroke="none"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M29.6 20.222c0-.822-.067-1.422-.211-2.044H20v3.71h5.511c-.111.923-.711 2.312-2.044 3.245l3.155 2.445c1.89-1.745 2.978-4.311 2.978-7.356z" fill="#4285F4" stroke="none"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.311 21.978A6.156 6.156 0 0113.978 20c0-.689.122-1.355.322-1.978l-3.233-2.51A10.009 10.009 0 0010 20c0 1.611.389 3.133 1.067 4.489l3.244-2.511z" fill="#FBBC05" stroke="none"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20 30c2.7 0 4.967-.889 6.622-2.422l-3.155-2.445c-.845.59-1.978 1-3.467 1-2.645 0-4.889-1.744-5.689-4.155l-3.233 2.51C12.722 27.757 16.088 30 20 30z" fill="#34A853" stroke="none"></path>
                        </svg>
                    </div>
                </div>


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
        gapi.load('auth2', function() {
            // Retrieve the singleton for the GoogleAuth library and set up the client.
            auth2 = gapi.auth2.init({
                client_id: '415251980402-68khrcjsbsmncrutho9fismb3k09965i.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin',
                // Request scopes in addition to 'profile' and 'email'
                //scope: 'additional_scope'
            });
            attachSignin(document.getElementById('google-signin'));
        });

        function attachSignin(element) {
            console.log(element.id);
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                    onSignIn(googleUser);
                },
            );
        }

        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            var id_token = googleUser.getAuthResponse().id_token;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'util/account/thirdparty/google_login.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Signed in as: ' + xhr.responseText);
            };
            xhr.send('idtoken=' + id_token);

            xhr.onload = () => {
                location.href = 'main/list.php';
            }

        }
    </script>

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