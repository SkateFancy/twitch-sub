<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 24.04.18
 * Time: 20:33
 */
include("config.php");
$conn = new mysqli($address . ":" . $port, $dbusername, $dbpassword, $database);
if ($conn->connect_error){
    die("error while connecting to database");
}
$sql = "CREATE TABLE `sub`.`users` ( `username` TEXT NOT NULL , `token` TEXT NOT NULL , `password` TEXT NOT NULL , `allow` BOOLEAN NOT NULL ) ENGINE = InnoDB;";
$conn->query($sql);
$conn->close();
?>
<h1>delete setup.php</h1>
