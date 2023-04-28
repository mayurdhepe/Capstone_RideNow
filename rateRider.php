<?php
session_start();
include('dbConnect.php');

$sql = "UPDATE RideRiders SET riderRating='" . $_POST['rating'] . "' WHERE ride_id='" . $_POST['ride_id'] . "' AND rider_id='" . $_POST['rider_id'] . "'";
// echo $sql;
$result = mysqli_query($link, $sql);
?>