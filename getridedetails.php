<?php
session_start();
include('dbConnect.php');
$sql = "SELECT * FROM Rides WHERE ride_id='" . $_POST['ride_id'] . "'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
$array = array("ride_id" => $row['ride_id'], "departure" => $row['startlocation'], "destination" => $row['destination'], "price" => $row['price'], "seatsavailable" => $row['seatsavailable'], "date" => $row['date'], "time" => $row['time']);
echo json_encode($array);

?>