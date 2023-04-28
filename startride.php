<?php
session_start();
include('dbConnect.php');
$sql = "UPDATE Rides SET status = 1 WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

$sql = "SELECT email from users WHERE user_id IN (SELECT rider_id FROM RideRiders WHERE ride_id='" . $_POST['ride_id'] . "')";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
    $message = "Your Ride has started! Happy journey!";
    mail($email, 'Ride Started', $message, 'From:' . 'gradproj@grad-project.host20.uk');
}

//email riders

?>