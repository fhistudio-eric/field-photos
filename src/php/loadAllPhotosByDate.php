<?php
require("db_connect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dateOperator = $_POST['dateOperator'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];


if ($dateOperator == 'from') {
    $nRows = $dbh->query("select count(*) from `fieldphotos` WHERE `sessionDate` = '$startDate'")->fetchColumn();
    $query = $dbh->query("SELECT * FROM `fieldphotos` WHERE `sessionDate` = '$startDate' ORDER BY `id` ASC ");
} else if ($dateOperator == 'before') {
    $nRows = $dbh->query("select count(*) from `fieldphotos` WHERE `sessionDate` < '$startDate'")->fetchColumn();
    $query = $dbh->query("SELECT * FROM `fieldphotos` WHERE `sessionDate` < '$startDate' ORDER BY `id` ASC ");
} else if ($dateOperator == 'after') {
    $nRows = $dbh->query("select count(*) from `fieldphotos` WHERE `sessionDate` > '$startDate'")->fetchColumn();
    $query = $dbh->query("SELECT * FROM `fieldphotos` WHERE `sessionDate` > '$startDate' ORDER BY `id` ASC ");
} else if ($dateOperator == 'between') {
    $nRows = $dbh->query("select count(*) from `fieldphotos` WHERE `sessionDate` >= '$startDate' AND  `sessionDate` <= '$endDate'")->fetchColumn();
    $query = $dbh->query("SELECT * FROM `fieldphotos` WHERE `sessionDate` >= '$startDate'  AND  `sessionDate` <= '$endDate' ORDER BY `id` ASC ");
}

if ($nRows == 0) {
    echo "NONE";
} else {

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
}
