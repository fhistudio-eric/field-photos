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
if (isset($_POST['randomString'])) {
    $randomString = $_POST['randomString'];
} else {
    $randomString = "SKIPPED";
}
if (isset($_POST['userName'])) {
    $userName = $_POST['userName'];
} else {
    $userName = "SKIPPED";
}
if (isset($_POST['sessionNotes'])) {
    $sessionNotes = $_POST['sessionNotes'];
} else {
    $sessionNotes = "SKIPPED";
}
if (isset($_POST['sessionDate'])) {
    $sessionDate = $_POST['sessionDate'];
} else {
    $sessionDate = "SKIPPED";
}
if (isset($_POST['photoNotes'])) {
    $photoNotes = $_POST['photoNotes'];
} else {
    $photoNotes = "SKIPPED";
}
if (isset($_POST['uploadTime'])) {
    $uploadTime = $_POST['uploadTime'];
} else {
    $uploadTime = "SKIPPED";
}
if (isset($_POST['lat'])) {
    $lat = $_POST['lat'];
} else {
    $lat = "SKIPPED";
}
if (isset($_POST['lng'])) {
    $lng = $_POST['lng'];
} else {
    $lng = "SKIPPED";
}


// // File name
$filename = $_FILES['file']['name'];

// Valid file extensions
$valid_extensions = array("jpg", "jpeg", "png", "heic");

// File extension
$extension = pathinfo($filename, PATHINFO_EXTENSION);

// Check extension
if (in_array(strtolower($extension), $valid_extensions)) {

    // Upload file
    if (move_uploaded_file($_FILES['file']['tmp_name'], "../uploads/" .  $randomString . "_" . $filename)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

$statement = $dbh->prepare('INSERT INTO `fieldphotos`(
        fileName,
        sessionName,
        userName,
        sessionNotes,
        sessionDate,
        photoNotes,
        uploadTime,
        lat,
        lng
    )VALUES (
        :fileName,
        :sessionName,
        :userName,
        :sessionNotes,
        :sessionDate,
        :photoNotes,
        :uploadTime,
        :lat,
        :lng
    )');

$statement->execute([
    'fileName' => $randomString . "_" . $filename,
    'sessionName' => $sessionName,
    'userName' => $userName,
    'sessionNotes' => $sessionNotes,
    'sessionDate' => $sessionDate,
    'photoNotes' => $photoNotes,
    'uploadTime' => $uploadTime,
    'lat' => $lat,
    'lng' => $lng
]);



exit;
