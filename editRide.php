<?php
session_start();
include('dbConnect.php');
$missingdeparture = '<p><strong>Please enter your start location</strong></p>';
$invaliddeparture = '<p><strong>Please enter a valid start location</strong></p>';
$missingdestination = '<p><strong>Please enter your destination!</strong></p>';
$invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';
$missingprice = '<p><strong>Please choose a price per seat!</strong></p>';
$invalidprice = '<p><strong>Please choose a valid price per seat using numbers only!!</strong></p>';
$missingseatsavailable = '<p><strong>Please select the number of available seats!</strong></p>';
$invalidseatsavailable = '<p><strong>The number of available seats should contain digits only!</strong></p>';
$missingfrequency = '<p><strong>Please select a frequency!</strong></p>';
$missingdays = '<p><strong>Please select at least one weekday!</strong></p>';
$missingdate = '<p><strong>Please choose a date for your trip!</strong></p>';
$missingtime = '<p><strong>Please choose a time for your trip!</strong></p>';

//Get inputs:
$ride_id = $_POST["ride_id"];
$departure = $_POST["departure2"];
$destination = $_POST["destination2"];
$price = $_POST["price2"];
// $seatsavailable = $_POST["seatsavailable2"];
$date = $_POST["date2"];
$time = $_POST["time2"];
$dist = $_POST["distance"];

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

// if (!$seatsavailable) {
//     $errors .= $missingseatsavailable;
// } elseif (
//     preg_match('/\D/', $seatsavailable)
// ) {
//     $errors .= $invalidseatsavailable;
// } else {
//     $seatsavailable = filter_var($seatsavailable, FILTER_SANITIZE_STRING);
// }

if (!$date) {
    $errors .= $missingdate;
}
if (!$time) {
    $errors .= $missingtime;
}


//if there is an error print error message
if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
} else {

    $departure = mysqli_real_escape_string($link, $departure);
    $destination = mysqli_real_escape_string($link, $destination);
    $sql = "UPDATE Rides SET `startlocation`= '$departure',`destination`='$destination',`price`='$price', `date`='$date', `time`='$time', `distance`='$dist'  WHERE `ride_id`='$ride_id'";
    $results = mysqli_query($link, $sql);

    $sql = "SELECT email from users WHERE user_id IN (SELECT rider_id FROM RideRiders WHERE ride_id ='" . $_POST['ride_id'] . "')";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $email = $row['email'];
        $message = "Driver modified the ride, please check.";
        mail($email, 'Your ride has been updated', $message, 'From:' . 'gradproj@grad-project.host20.uk');
    }

    if (!$results) {
        echo '<div class=" alert alert-danger">There was an error! The ride could not be updated!</div>';
    }
}

?>