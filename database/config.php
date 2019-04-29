<?php
global $dbHost,$dbUsername,$dbPassword,$dbName,$baseUrl;

$isOnline = 0;

if($isOnline == 0) {
    $dbHost 	= "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName 	= "genta";
    $baseUrl 	= "http://localhost/genta";
}else {
    $dbHost 	= "localhost";
    $dbUsername = "root";
    $dbPassword = "wJoN7S79crkEEi";
    $dbName 	= "blog";
    $baseUrl = "https://blog.agendakota.id";
}

?>