<?php
session_start();
include('dbConnect.php');
$sql = "DELETE FROM Rides WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);

?>