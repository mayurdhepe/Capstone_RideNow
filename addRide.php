<?php

session_start();
include('dbConnect.php');

$missingdeparture = '<p><strong>Please enter your departure!</strong></p>';
$invaliddeparture = '<p><strong>Please enter a valid departure!</strong></p>';
$missingdestination = '<p><strong>Please enter your destination!</strong></p>';
$invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';
$missingprice = '<p><strong>Please choose a price per seat!</strong></p>';
$invalidprice = '<p><strong>Please choose a valid price per seat using numbers only!!</strong></p>';
$missingseatsavailable = '<p><strong>Please select the number of available seats!</strong></p>';
$invalidseatsavailable = '<p><strong>The number of available seats should contain digits only!</strong></p>';
$missingdate = '<p><strong>Please choose a date for your trip!</strong></p>';
$missingtime = '<p><strong>Please choose a time for your trip!</strong></p>';

$departure = $_POST["departure"];
$destination = $_POST["destination"];
$price = $_POST["price"];
$seatsavailable = $_POST["seatsavailable"];
$date = $_POST["date"];
$time = $_POST["time"];

if (!$departure) {
    $errors .= $missingdeparture;
} else {
    $departure = filter_var($departure, FILTER_SANITIZE_STRING);
}

if (!$destination) {
    $errors .= $missingdestination;
} else {
    $destination = filter_var($destination, FILTER_SANITIZE_STRING);
}

if (!$price) {
    $errors .= $missingprice;
} elseif (
    preg_match('/\D/', $price)
) {
    $errors .= $invalidprice;
} else {
    $price = filter_var($price, FILTER_SANITIZE_STRING);
}


if (!$seatsavailable) {
    $errors .= $missingseatsavailable;
} elseif (
    preg_match('/\D/', $seatsavailable)
) {
    $errors .= $invalidseatsavailable;
} else {
    $seatsavailable = filter_var($seatsavailable, FILTER_SANITIZE_STRING);
}


if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
} else {

    $departure = mysqli_real_escape_string($link, $departure);
    $destination = mysqli_real_escape_string($link, $destination);

    $sql = "INSERT INTO Rides (`user_id`,`startlocation`, `destination`, `price`, `seatsavailable`, `date`, `time`) VALUES ('" . $_SESSION['user_id'] . "', '$departure','$destination','$price','$seatsavailable','$date','$time')";
    $results = mysqli_query($link, $sql);

    if (!$results) {
        echo '<div class=" alert alert-danger">There was an error! The trip could not be added to database!</div>';
    }
}

?>