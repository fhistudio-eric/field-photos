<?php
require("db_connect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// var_dump($_POST);



$query = $dbh->query("SELECT * FROM `fieldphotos` ORDER BY `id` ASC ");

$return_data = array();
$data = array();

foreach ($query as $row) {

    $data['id'] = $row['id'];
    $data['fileName'] = $row['fileName'];
    $data['sessionName'] = $row['sessionName'];
    $data['userName'] = $row['userName'];
    $data['sessionNotes'] = $row['sessionNotes'];
    $data['sessionDate'] = $row['sessionDate'];
    $data['photoNotes'] = $row['photoNotes'];
    $data['uploadTime'] = $row['uploadTime'];
    $data['lat'] = $row['lat'];
    $data['lng'] = $row['lng'];

    array_push($return_data, $data);
}


$json = json_encode($return_data);

echo ($json);
