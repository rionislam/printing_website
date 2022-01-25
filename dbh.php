<?php

$serverName = 'localhost';
$dbUsername = 'me';
$dbPassword = 'rtytrtyt';
$dbName = 'order';

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if(!$conn)
{
    die('Connection Failed : '. mysqli_connect_error());
}