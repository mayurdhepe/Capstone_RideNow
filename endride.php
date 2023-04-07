<?php
session_start();
include('dbConnect.php');
$sql = "UPDATE Rides SET status = 2 WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

//email riders

?>