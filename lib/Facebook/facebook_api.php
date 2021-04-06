<?php

function facebook_api_call($endpoint, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint . '?' . http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);

    $fb_response = curl_exec($ch);
    $fb_response = json_decode($fb_response, TRUE);
    curl_close($ch);

    return array(
        'endpoint' => $endpoint,
        'params' => $params,
        'has_errors' => isset($fb_response['error']) ? TRUE : FALSE,
        'error_message' => isset($fb_response['error']) ? $fb_response['error']['message'] : '',
        'fb_response' => $fb_response
    );
}

function get_facebook_login_url()
{

    $endpoint = 'https://www.facebook.com/' . FB_GRAPH_VERSION . '/dialog/oauth';

    $params = array(
        'client_id' => FB_APP_ID,
        'redirect_uri' => FB_REDIRECT_URI,
        'state' => FB_APP_STATE,
        'scope' => 'email',
        'auth_type' => 'rerequest'
    );

    return $endpoint . '?' . http_build_query($params);
}

function get_access_token($code)
{
    $endpoint = 'https://graph.facebook.com/' . FB_GRAPH_VERSION . '/oauth/access_token';

    $params = array(
        'client_id' => FB_APP_ID,
        'client_secret' => FB_APP_SECRET,
        'redirect_uri' => FB_REDIRECT_URI,
        'code' => $code
    );

    return facebook_api_call($endpoint, $params);
}