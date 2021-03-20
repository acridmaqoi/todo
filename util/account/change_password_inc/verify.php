<?php

require_once '../../../config/db.php';

if(!isset($_GET['vkey'])) {
    die("no vkey provided");
}

$vkey = $_GET['vkey'];

if ($stmt = $con->prepare('SELECT id, email FROM accounts WHERE password_code = (?) LIMIT 1')) {
    $stmt->bind_param('s', $vkey);
    
    $stmt->execute();
    $stmt->store_result();
} else {
    die('db error');
}

if ($stmt->num_rows > 0) {
    $stmt->bind_result($_SESSION['id'], $email);
    $stmt->fetch();
    echo 'Change password for '.$email;
} else {
    die('invalid vkey');
}




?>

<div class="form">
    <input id="password" placeholder="Password" type="password">
    <input id="password_confirm" placeholder="Confirm password" type='password'>

    <button id="btn-submit" type="submit">Confirm</button>
    <ul id="form-messages"></ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $("#password_confirm").on("keypress", function(e) {
        if (e.keyCode == 13) {
            $("#btn-submit").click(); // allow enter button to be used
        }
    });

    $("#btn-submit").on("click", function(e) {
        e.preventDefault();

        var password = $("#password").val();
        var password_confirm = $("#password_confirm").val();

        $.ajax({
            url: "set_password.php",
            type: "POST",
            data: {
                new_password: password,
                new_password_confirm: password_confirm
            },
            success: function(data) {
                $("#form-messages").empty();
                // get response
                parsed_data = jQuery.parseJSON(data);
                
                if (parsed_data.ok) {
                    location.href = '../../../index.php?password_reset'
                } else {
                    parsed_data.messages.forEach((message) => {
                        // display error messages
                        $("#form-messages").append(message);
                    });    
                }
            }
        });
    });    
</script>



