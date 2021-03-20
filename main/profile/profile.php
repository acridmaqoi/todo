<?php
require '../../controllers/auth.php';
require_once '../../util/account/get_account_details.php';

$acc = new GetAccountDetails($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$acc->get_username()?> - profile</title>
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
                <td><?=$acc->get_username()?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?=$acc->get_email()?></td>
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
            <button id="add_btn" type="submit">Confirm</button>
            <ul id="password-form-messages"></ul>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $("#new_password_confirm").on("keypress", function(e) {
                if (e.keyCode == 13) {
                    $("#add_btn").click(); // allow enter button to be used
                }
            });

             $("#add_btn").on("click", function(e) {
                e.preventDefault();

                var email = "<?php echo $acc->get_email() ?>"

                $.ajax({
                    url: "../../util/account/change_password.php",
                    type: "POST",
                    data: {
                        email: email
                    },
                    success: function(data) {
                        $("#password-form-messages").empty();
                        // get response
                        parsed_data = jQuery.parseJSON(data);
                        parsed_data.messages.forEach((message) => {
                            // display error messages
                            $("#password-form-messages").append(message);
                            // $(this).parent().find("#form-messages").append(message);
                        });
                    }
                });
            });
        </script>

    </div>

</body>

</html>