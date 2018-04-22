<h3>
    Mit dem Aktivieren der Checkbox akzeptierst du, dass dein Sub öffentlich abrufbar wird.
    By activating the checkbox you accept, sharing your subscripting public.
</h3>
<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.04.18
 * Time: 22:22
 */
if ($_GET['pw'] == null) die("ERROR");
$password = $_GET['pw'];
include("config.php");
$conn = new mysqli($address . ":" . $port, $dbusername, $dbpassword, $database);
if ($conn->connect_error) {
    die("error while connecting to database");
}
$sql = "SELECT allow FROM users WHERE password='$password'";
$allowQuery = $conn->query($sql);
$allow = $allowQuery->fetch_array()['allow'];
if ($_GET['allow'] !== null) {
    $allow = $_GET['allow'];
    $sql = "UPDATE users SET allow='$allow' WHERE password='$password'";
    $conn->query($sql);
}

echo "<form action='settings.php' method='get'><input type='checkbox' id='allow' value='$allow'><input type='text' id='pw' value='$password' hidden> <input type='submit' value='submit'></form>";


$conn->close();
