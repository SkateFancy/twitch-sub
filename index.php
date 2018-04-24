<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Sub Validate</title>
</head>
<body>
<div class="title">
 <h1>Mache deinen Sub öffentlich einsichtlich.</h1>
 <h2>Dies hat nichts mit dem Teilen auf Twitch zu tun.</h2>
 <h3>Achtung: Hiermit ist es theoretisch jedem möglich deinen Sub abzufragen!
</html>
<?php
include("config.php");
/** @noinspection HtmlUnknownTarget */
echo "<a class='publishButton' href='https://id.twitch.tv/oauth2/authorize?client_id=$clientId&redirect_uri=". $websiteURL . "/redirect.html&response_type=token&scope=user_subscriptions'>veröffentlichen</a>"
?>
<!--suppress CssUnusedSymbol -->
<style>
    .publishButton{
        text-decoration: none;
        text-underline: none;
        font-size: 120px;
        border: 5px blue solid;
    }
    body{
        background-color: white;
    }
    .title{
        text-align: center;
        color: purple;
    }
    h3{
        color: red;
    }


</style>