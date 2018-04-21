<?php
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
    $clientId = '';
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
    }else{
        echo 'not subscribed';
    }
}