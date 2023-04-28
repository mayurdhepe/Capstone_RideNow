<?php
session_start();
include('dbConnect.php');
$sql = "UPDATE Rides SET status = 2 WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

//email riders
$sql = "SELECT email from users WHERE user_id IN (SELECT rider_id FROM RideRiders WHERE ride_id='" . $_POST['ride_id'] . "')";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
    $message = "Your Ride has ended! Please rate your driver. We hope you had a good experience with our platform.";
    mail($email, 'Ride Ended.', $message, 'From:' . 'gradproj@grad-project.host20.uk');

    $message = "You have successfully paid the driver. Don't forget to rate your driver.";
    mail($email, 'Payment processed.', $message, 'From:' . 'gradproj@grad-project.host20.uk');
}

$sql = "SELECT email from Driver WHERE user_id = (SELECT `user_id` FROM Rides WHERE ride_id='" . $_POST['ride_id'] . "')";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
    $message = "Your Ride has ended! Please rate your rider. We hope you had a good experience with our platform.";
    mail($email, 'Ride Ended.', $message, 'From:' . 'gradproj@grad-project.host20.uk');

    $message = "You have been successfully paid by the rider. Don't forget to rate your rider.";
    mail($email, 'Payment processed.', $message, 'From:' . 'gradproj@grad-project.host20.uk');
}

?>