<?php

function facebook_login($get)
{
    require __DIR__ . '../../../../autoloader.php';
    require __DIR__ . '../../../db.php';

    if (isset($get['error'])) {
        $message = $get['error_description'];
        return;
    }

    $access_token_info = get_access_token($get['code']);

    if ($access_token_info['has_errors']) {
        $message = $access_token_info['error_message'];
        return;
    }

    $fb_access_token = $access_token_info['fb_response']['access_token'];

    $response = get_facebook_user_info($fb_access_token);

    if (
        !$response['has_errors'] && !empty($response['fb_response']['id'])
        && !empty($response['fb_response']['email'])
    ) {

        $fb_user_info = $response['fb_response'];

        $user_id = $fb_user_info['id'];
        $email = $fb_user_info['email'];

        if ($stmt = $con->prepare('SELECT id FROM accounts WHERE email = (?)')) {
            $stmt->bind_param('s', $email);

            $stmt->bind_result($user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->fetch();

            echo 'here';

            if ($stmt->num_rows() == 1) {
                // user already registered, login
                login_user($user_id, true);
            } else {
                // register user
                register_user($email, null, $email, true);
            }
        }
    }
}
