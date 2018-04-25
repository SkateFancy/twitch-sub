<?php
include("config.php");
include("twitchCommunication.php");
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if (isset($_GET['access_token'])){
    $token = $_GET['access_token'];
    $username = twitchCommunication::getUserInfo($token)['username'];

    if (twitchCommunication::isSub($token, $username, $clientId, $channelSub)) {
        echo 'subscribed';
        $conn = new mysqli($address . ":" . $port, $dbusername, $dbpassword, $database);
        $token = $conn->escape_string($token);
        if ($conn->connect_error){
            die("error while connecting to database");
        }
        $sqlCheck = "SELECT * FROM users WHERE username='$username'";
        if ($conn->query($sqlCheck)->num_rows < 1){
            $profilePicture = twitchCommunication::getUserInfo($token)['profilePicture'];
            $password = generateRandomString(20);
            $sql = "INSERT INTO users (username, token, password, profilePicture) VALUES ('$username', '$token', '$password', '$profilePicture')";
            $conn->query($sql);
        }else{
            $sqlGet = "SELECT password FROM users WHERE username='$username'";
            $pwResult = $conn->query($sqlGet);
            $password = $pwResult->fetch_array()['password'];
        }
        header("Location:settings.php?pw=" . $password);


        $conn->close();
    }else{
        echo '<h1>You are not subscribing' . $channelSub . ' </h1>';
    }

}