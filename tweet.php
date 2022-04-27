<?php

session_start();
require_once "api.php";
require_once "banned.php";

if(!empty($_REQUEST['submission']) && !empty($_REQUEST['uname'])) {
    $submission = $_REQUEST['submission'];
    $uname = $_REQUEST['uname'];
    // Banned word check
    if(in_array($submission, $bannedWords)) {
        unset($submission); unset($uname);
        echo "Your submission contains a banned word. Please try again.";
    } else {
        $submission = htmlentities($_REQUEST['submission']);
        $uname = htmlentities($_REQUEST['uname']);
        $tweet = htmlentities("$submission - @$uname");
        // Post to Twitter with API
        $ch = curl_init();
        $url = "https://api.twitter.com/1.1/statuses/update.json";
        $postfields = array(
            'status' => $tweet
        );
        $headers = array(
            'Authorization: Bearer ' . $bearerToken
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if(!empty($result['errors'])) {
            // HTTP Error
            ?>
            <head><title>Unexpected Error</title><style>body {padding-top: 200px;padding-left: 200px;padding-right:200px;background-color: black;color: white;} div.b {word-wrap: break-word;color: red;}a {color: white;}a:hover {background-color: red;}a:visited {text-decoration: none;color: white;}</style></head>
            <body>
                <center>
                    <!-- Recovery -->
                    <p>An unrecoverable error has occured.<br>If you're a regular user, please DM me on <a href="https://twitter.com:443/">Twitter</a> with the following error code:<br><div class="b">ERROR NO. <?php echo base64_encode($result['errors'][0]['message']);?></div><br><br><?php die("\nDie() called. PHP terminated."); unset($submission); unset($uname)?></p><br><br>
                </center>
            </body>
            <?php
        } else {
            // Success
            ?>
            <head><title>tweetCky</title><style>body {padding-top: 200px;padding-left: 200px;padding-right:200px;background-color: black;color: white;} div.b {word-wrap: break-word;color: red;}a {color: white;}a:hover {background-color: red;}a:visited {text-decoration: none;color: white;}</style></head>
            <body>
            <center>
                <p><b>Successfully posted to Twitter!<br><a href="https://twitter.com:443/">Checkout your tweet here</a></b></p>
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
    <title>tweetCky</title>
    <style>
        body {padding-top: 200px;background-color: black;color: white;}
    </style>
</head>
<body>
<center>
    <h3>##### Enter Your Tweet #####</h3>
    <p>todo: make website look better :)</p>
    <!-- Form -->
    <form method="POST">
    <p><b>Input submission:</b><br>max character length: <b>263</b></p>
    <textarea type="text" rows="5" cols="60" name="submission" maxlength="263" required></textarea>
    <p><b>Input Twitter username:</b><br>no special characters allowed</p>
    <input type="text" name="uname" value="" placeholder="twitterUsername" pattern="[a-zA-Z]+" minlength="4" maxlength="15" required>
    <br><br>
    <input type="submit" name="submit" value="Submit">
    </form>
</center>
<?php
}
?>
</body>
</html>
