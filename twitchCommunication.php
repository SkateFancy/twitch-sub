<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 23.04.18
 * Time: 20:40
 */

class twitchCommunication
{
    public static function isSub($token, $username, $clientId, $channel){
        //DEPRECATED (API Endpoint will be removed end of 2018)
        $Api = 'https://api.twitch.tv/kraken/users/';
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                'Authorization: OAuth ' . $token,
                'Client-ID: ' . $clientId
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $Api . $username . "/subscriptions/$channel"
        ));

        $responseSubscriptions = curl_exec($ch);
        curl_close($ch);
        if (strpos($responseSubscriptions, '404') == false) {
            return true;
        }
        return false;
    }
    public static function getUserInfo($token){
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
        $returnValue = [];
        foreach ($jsonIterator as $key => $val) {
            if(!is_array($val)) {
                if ($key == "display_name"){
                    $returnValue['username'] = $val;
                }else if($key == "profile_image_url"){
                    $returnValue['profilePicture'] = $val;
                }
            }
        }
        return $returnValue;
    }
}
