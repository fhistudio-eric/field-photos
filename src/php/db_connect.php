<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$hostname='mysql.fhistudio-apps.com';
$username='webhosting';
$password='Deadrock#01';
$database='fhistudio_apps';


try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$database",$username,$password);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    // echo $e->getMessage();
    }
?>