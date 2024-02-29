<?php
include('authentication.php');
include('../admin/config/dbconn.php');

date_default_timezone_set("Asia/Manila");

use Twilio\Rest\Client;

require '../vendor/autoload.php';

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = 'ACbdf3dc11c57501403d6281b5cfa6f125';
$token = '54247ab3b179896c8e6854bddc6a39b0';
$twilio = new Client($sid, $token);

$message = $twilio->messages
    ->create(
        "", // to
        [
            "body" => "This is the ship that made the Kessel Run in fourteen parsecs?",
            "from" => '+17249481433',
        ]
    );

if ($message) {
    echo 'Message sent';
} else {
    echo 'something went wrong';
}
