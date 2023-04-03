<?php
session_start();
include('dbConnect.php');

$sql = "SELECT seatsavailable FROM Rides WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
echo $row['seatsavailable'];
//     if (mysqli_num_rows($result) > 0) {
//         while ($row = mysqli_fetch_array($result)) {
//             $frequency = "One-off journey.";
//             $time = $row['date'] . " at " . $row['time'] . ".";
$seats = $row['seatsavailable'] - 1;
$sql = "UPDATE Rides SET seatsavailable = '$seats' WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

$sql = "INSERT INTO RideRiders (`ride_id`,`rider_id`) VALUES ('" . $_POST['ride_id'] . "', '" . $_SESSION['user_id'] . "')";
$results = mysqli_query($link, $sql);

if (!$results) {
    echo '<div class=" alert alert-danger">There was an error! The trip could not be added to database!</div>';
}

// Email to Driver and Rider

?>