<h3>
    Mit dem Aktivieren der Checkbox akzeptierst du, dass dein Sub öffentlich abrufbar wird.
    By activating the checkbox you accept, sharing your subscripting publicly.
</h3>
<br>
<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.04.18
 * Time: 22:22
 */
if (!isset($_GET['pw'])) die("ERROR");
include("config.php");
include("twitchCommunication.php");
$conn = new mysqli($address . ":" . $port, $dbusername, $dbpassword, $database);
$password = $conn->escape_string($_GET['pw']);
if ($conn->connect_error) {
    die("error while connecting to database");
}
$sql = "SELECT username, allow, token FROM users WHERE password='$password'";
$sqlResult = $conn->query($sql);
if ($sqlResult->num_rows !== 1) {
    die("Wrong password try again (if you believe this is an error, contact server administrator.");
}
$username = $sqlResult->fetch_array()['username'];
$allow = $sqlResult->fetch_array()['allow'];
if (isset($_GET['allow'])) {
    $allow = $_GET['allow'];
    if ($allow == "on"){
        $allow = 1;
    }else{
        $allow = 0;
    }
    $sql = "UPDATE users SET allow='$allow' WHERE password='$password'";
    $conn->query($sql);
}
/**Not working... Sets username to 0
if (isset($_GET['refresh']) && $_GET['refresh'] == "on"){
    $userData = twitchCommunication::getUserInfo($sqlResult->fetch_array()['token']);
    $username = $userData['username'];
    $profilePicture = $userData['profilePicture'];
    $sql = "UPDATE users SET username='$username' AND profilePicture='$profilePicture' WHERE password='$password'";
    $conn->query($sql);
    echo "<div class='hintBox'>Refreshed!</div>";
}
*/
if ($allow == 1) {
    $allow = "checked";
} else {
    $allow = "";
}
echo "Welcome, $username!<br>";
echo "<form action='settings.php' method='get'>
      <label for='allowCheckbox'>Allow publishing subscription to $channelSub publicly (together with your name, profile picture usw.)</label><input type='checkbox' id='allowCheckbox' name='allow' $allow><br>
      <label for='refreshCheckbox'>Refresh username/profilePicture</label><input type='checkbox' id='refreshCheckbox' name='refresh'>
      <input type='password' name='pw' value='$password' hidden><br>
      <input type='submit' value='submit'></form>";


$conn->close();
?>
<style type="text/css">
    body{
        text-align: center;
    }
    .hintBox{
        border: solid red 2px;
        background: lightcoral;
        width: 100%;
        animation-name: "hintBox_out";
        -webkit-animation-delay: 2s;
        -moz-animation-delay: 2s;
        -o-animation-delay: 2s;
        animation-delay: 2s;
        animation-duration: 2s;
    }
    /*Does not work now!*/
    @keyframes hintBox_out {
        0%, 100% {
            margin-top: -200px
        }
        10%, 90% {
            margin-top: 0px
        }
    }
</style>
