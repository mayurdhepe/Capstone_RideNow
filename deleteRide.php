<?php
session_start();
include('dbConnect.php');

$sql = "SELECT email from users WHERE user_id IN (SELECT rider_id FROM RideRiders WHERE ride_id='" . $_POST['ride_id'] . "')";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
    $message = "Driver cancelled the ride, please find another ride.";
    mail($email, 'The driver has cancelled the ride', $message, 'From:' . 'gradproj@grad-project.host20.uk');
}

$sql = "DELETE FROM Rides WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

$sql = "DELETE FROM RideRiders WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

//email riders

?>