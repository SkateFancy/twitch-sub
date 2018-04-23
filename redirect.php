<?php
include("config.php");
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.04.18
 * Time: 12:32
 */
if ($_GET['access_token'] != null){
    $token = $_GET['access_token'];
    $username = twitchCommunication::getUsername($token);

    if (twitchCommunication::isSub($token, $username, $clientId, $channelSub)) {
        echo 'subscribed';
        //Started Data Input
        $conn = new mysqli($address . ":" . $port, $dbusername, $dbpassword, $database);
        if ($conn->connect_error){
            die("error while connecting to database");
        }
        $sqlCheck = "SELECT * FROM users WHERE username='$username'";
        if ($conn->query($sqlCheck)->num_rows < 1){
            $password = generateRandomString(20);
            $sql = "INSERT INTO users (username, token, password) VALUES ('$username', '$token', '$password')";
        }else{
            $sqlGet = "SELECT password FROM users WHERE username='$username'";
            $pwResult = $conn->query($sqlGet);
            $password = $pwResult->fetch_array()['password'];
        }
        header("Location:settings.php?pw=" . $password);


        $conn->close();
    }else{
        echo 'not subscribed';
    }

}