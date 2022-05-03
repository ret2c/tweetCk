<?php

require_once "api.php";
require_once "banned.php";
require_once "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

if(!empty($_REQUEST['submission']) && !empty($_REQUEST['uname'])) {
    $submission = $_REQUEST['submission'];
    $uname = htmlentities($_REQUEST['uname']);
    $tweet = "$submission - @$uname";
    // Banned word check
    $check = false;
    foreach ($bannedWords as $word) {
        if (strpos(strtolower($tweet), $word) !== false) {
            $check = true;
        }
    }
    if($check == true) {
        unset($submission); unset($uname);
        ?>
            <head><title>tweet</title><style>body {padding-top: 200px;padding-left: 200px;padding-right:200px;background-color: black;color: white;} div.b {word-wrap: break-word;color: red;}a {color: white;}a:hover {background-color: red;}a:visited {text-decoration: none;color: white;}</style></head>
            <body>
                <center>
                    <!-- Recovery -->
                    <p><div class="b"><b>Your submission contains a banned word.</div></b><br><a href="index.php">Try Again</a></p>
                </center>
            </body>
            <?php
    } else {
        // Post to Twitter with Abraham\TwitterOAuth
        // Define Keys,
        define('CONSUMER_KEY', $apiKey);
        define('CONSUMER_SECRET', $apiKeySecret);
        define('ACCESS_TOKEN', $accessToken);
        define('ACCESS_TOKEN_SECRET', $accessTokenSecret);
        // Make Connection & Tweet
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
        $result = $connection->post("statuses/update", ["status" => $tweet]);
        if($connection->getLastHttpCode() != 200) {
            // HTTP Error
            ?>
            <head><title>Unexpected Error</title><style>body {padding-top: 200px;padding-left: 200px;padding-right:200px;background-color: black;color: white;} div.b {word-wrap: break-word;color: red;}a {color: white;}a:hover {background-color: red;}a:visited {text-decoration: none;color: white;}</style></head>
            <body>
                <center>
                    <!-- Recovery -->
                    <p>An unrecoverable error has occured.<br>If you're a regular user, please DM me on <a href="https://twitter.com:443/">Twitter</a> with the following error code:<br><div class="b">ERROR NO. <?php echo base64_encode($result->errors[0]->message);?></div><br><br><?php die("\nPHP terminated."); unset($submission); unset($uname);?></p><br><br>
                </center>
            </body>
            <?php
        } else {
            // Success
            ?>
            <head><title>tweet</title><style>body {;padding-top: 200px;padding-left: 200px;padding-right:200px;background-color: black;color: white;}div.a {color: #32CD32}a {color: white;}a:hover {background-color: red;}a:visited {text-decoration: none;color: white;}</style></head>
            <body>
            <center>
                <p><div class="a"><b>Successfully posted to Twitter!</div><br><a href="https://twitter.com/">Checkout your tweet here</a></b></p>
                <?php unset($submission); unset($uname); unset($tweet); ?>
                <p><a href="index.php">Post Another?</a></p>
            </center>
            </body>
            <?php die(); ?>
            <?php
        }
    }
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>tweet</title>
    <style>
        body {padding-top: 200px;background-color: black;color: white;}
    </style>
</head>
<body>
<center>
    <h3>##### Enter Your Tweet #####</h3>
    <p>todo: make website look pretty :)</p>

    <form method="POST">
    <p><b>Input submission:</b><br>max character length: <b>263</b></p>
    <textarea type="text" rows="5" cols="60" name="submission" maxlength="263" required></textarea>
    <p><b>Input Twitter username:</b><br>no special characters allowed</p>
    <input type="text" name="uname" value="" placeholder="twitterUsername" pattern="[a-zA-Z0-9]+" minlength="4" maxlength="15" required>
    <br><br>
    <input type="submit" name="submit" value="Submit">
    </form>
</center>
<?php
}
?>
</body>
</html>
