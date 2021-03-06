<?php
require_once __DIR__ . '/../vendor/autoload.php';

use jens1o\smashcast\SmashcastApi;
use jens1o\smashcast\oauth\SmashcastOauthHandler;

SmashcastApi::setAppName(APP_NAME);
SmashcastApi::setAppToken(APP_TOKEN);
SmashcastApi::setAppSecret(APP_SECRET);
if(isset($_GET['authToken'])) {
    // IMPORTANT NOTE: THIS IS VULNERABLE FOR XSS! YOU SHOULD ALWAYS ESCAPE THEM!
    echo 'Auth Token: ' . $_GET['authToken'];
    echo '<br><a href="' . $_SERVER['SCRIPT_NAME'] . '">Refresh!</a>';
} else if(!isset($_GET['request_token'])) {
    // begins auth -> redirects to Smashcast
    $forceAuth = true; // toggle this around and see what happens!
    SmashcastOauthHandler::init($forceAuth, 'somestatevalue');
} else {
    // IMPORTANT NOTE: THIS IS VULNERABLE FOR XSS! YOU SHOULD ALWAYS ESCAPE THEM!
    echo 'Request Token: ' . $_GET['request_token'];
    echo '<br>Auth Token: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . SmashcastOauthHandler::getAuthTokenFromRequestToken($_GET['request_token'], $_GET['state'], 'somestatevalue');
    echo '<br><a href="' . $_SERVER['SCRIPT_NAME'] . '">Refresh!</a>';
}
