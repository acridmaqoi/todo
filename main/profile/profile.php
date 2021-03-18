<?php
require '../../controllers/auth.php';
require '../../util/db_utils.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=get_username()?> - profile</title>
</head>

<body>
    <nav class="navtop">
        <a href="../list.php">home</a>
        <a href="../../util/account/logout.php">登出</a>
    </nav>

    <div class="content">
        <p>Your account details are below:</p>
        <table>
            <tr>
                <td>Username:</td>
                <td><?=get_username()?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=get_email()?></td>
            </tr>
        </table>

        <p>Change email address:</p>

        <div class="form">
            <input id="email" placeholder="Email" spellcheck="false">
            <input id="email_confirm" placeholder="Confirm email">
            <button id="btn-submit" type="submit">Confirm</button>
            <ul id="form-messages"></ul>
        </div>
        <script>
            // allows enter button to be used when submitting form
            document.querySelector("#email_confirm").addEventListener("keyup", event => {
                if (event.key !== "Enter") return;
                document.querySelector("#btn-submit").click();
                event.preventDefault();
            });

            const form = {
                email: document.getElementById('email'),
                email_confirm: document.getElementById('email_confirm'),
                submit: document.getElementById('btn-submit'),
                messages: document.getElementById('form-messages')
            };

            form.submit.addEventListener('click', () => {
                console.log('confirming email...')

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

                const requestData = `email=${form.email.value}&email_confirm=${form.email_confirm.value}`;

                // send to server
                request.open('post', '../../util/account/change_email.php');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.send(requestData);
            });

            function handleResponse(responseObject) {
                //prevents duplicate messages
                while (form.messages.firstChild) {
                    form.messages.removeChild(form.messages.firstChild);
                }

                if (responseObject.ok) {
                    const li = document.createElement('p');
                    li.textContent = "Check your email for a verification link";
                    form.messages.append(li);
                } else {
                    responseObject.messages.forEach((message) => {
                        const li = document.createElement('p');
                        console.log(message)
                        li.textContent = message;
                        form.messages.appendChild(li);
                    });
                }
            }
        </script>

        <p>Change password:</p>

        <div class="form">
            <input id="password" placeholder="Password" spellcheck="false">
            <input id="password_confirm" placeholder="Confirm password">
            <button id="btn-submit" type="submit">Confirm</button>
            <ul id="form-messages"></ul>
        </div>
        <script>
            // allows enter button to be used when submitting form
            document.querySelector("#email_confirm").addEventListener("keyup", event => {
                if (event.key !== "Enter") return;
                document.querySelector("#btn-submit").click();
                event.preventDefault();
            });

            const form = {
                password: document.getElementById('email'),
                password_confirm: document.getElementById('password_confirm'),
                submit: document.getElementById('btn-submit'),
                messages: document.getElementById('form-messages')
            };

            form.submit.addEventListener('click', () => {
                console.log('confirming email...')

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

                const requestData = `email=${form.email.value}&email_confirm=${form.email_confirm.value}`;

                // send to server
                request.open('post', '../../account/email/set_validate_email.php');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.send(requestData);
            });

            function handleResponse(responseObject) {
                //prevents duplicate messages
                while (form.messages.firstChild) {
                    form.messages.removeChild(form.messages.firstChild);
                }

                if (responseObject.ok) {
                    const li = document.createElement('p');
                    li.textContent = "Check your email for a verification link";
                    form.messages.append(li);
                } else {
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