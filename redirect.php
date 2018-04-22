<?php
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

    $Api = 'https://api.twitch.tv/helix/users/';
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $token,
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $Api
    ));

    $responseUsername = curl_exec($ch);
    curl_close($ch);

    $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($responseUsername, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);
    $username = "dummy";
    $userID = "1234";
    foreach ($jsonIterator as $key => $val) {
        if(!is_array($val)) {
            if ($key == "display_name"){
                $username = $val;
            }
        }
    }
    //DEPRECATED
    $Api = 'https://api.twitch.tv/kraken/users/';
    $clientId = '0e3j4no7rk76ja8ibzkghumfnh110g';
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_HTTPHEADER => array(
            'Authorization: OAuth ' . $token,
            'Client-ID: ' . $clientId
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $Api . $username . "/subscriptions/skate702"
    ));

    $responseSubscriptions = curl_exec($ch);
    curl_close($ch);
    if (strpos($responseSubscriptions, '404') == false) {
        echo 'subscribed';
        //Started Data Input
        include("config.php");
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