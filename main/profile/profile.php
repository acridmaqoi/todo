<?php 
require '../../controllers/auth.php';
require '../db_utils.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav class="navtop">

    </nav>
    <div class="content">
        <p>Your account details are below:</p>
        <table>
            <tr>
                <td>Username:</td>
                <td><?= get_username() ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?= get_email() ?></td>
            </tr>
        </table>

        <p>Change email address:</p>
        <form action="change_email.php" method="post" autocomplete="off">
            <input type="email" name="email" placeholder="Email" id="email" required>
            <input type="email" name="email_confirm" placeholder="Confirm email" id="email" required>
            <input type="submit" value="Confirm">
        </form>
    </div>

</body>

</html>