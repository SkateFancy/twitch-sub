<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.04.18
 * Time: 18:13
 */
if ($_GET['username'] !== null){
    $username = $_GET['username'];
    include("../../config.php");
    $conn = new mysqli($address . ":" . $port, $dbusername, $dbpassword, $database);
    if ($conn->connect_error) {
        die("error while connecting to database");
    }
    $sql = "SELECT token FROM users WHERE username='$username' AND allow='1'";
    $results = $conn->query($sql);
    $token = $results->fetch_array()['token'];
    $sub = twitchCommunication::isSub($token, $username, $clientId, $channelSub);
    echo "
    {
     username: $username
     sub: $sub
    }";
}else{
    echo "{";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT username, token FROM users WHERE allow='1'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resultJsonArray = "";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $username = $row['username'];
            if (twitchCommunication::isSub($row['token'], $username, $clientId, $channelSub)){
                $resultJsonArray = $resultJsonArray . '["username":"' . $username .'"]';
            }
        }
        echo str_replace("][", "], [", $resultJsonArray);
    }
    echo "}";
}