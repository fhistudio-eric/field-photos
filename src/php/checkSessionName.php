<?php
require("db_connect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['sessionName'])) {
    $sessionName = $_POST['sessionName'];
} else {
    $sessionName = "SKIPPED";
}

$nRows = $dbh->query("select count(*) from `fieldphotos` WHERE `sessionName` = '$sessionName'")->fetchColumn();

if ($nRows == 0) {
    echo "NOT Found";
} else {
    echo "Found";
}
?>