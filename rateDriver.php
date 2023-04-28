<?php
session_start();
include('dbConnect.php');
// update driver rating in RideRiders table
$sql = "UPDATE RideRiders SET driverRating='" . $_POST['rating'] . "' WHERE ride_id='" . $_POST['ride_id'] . "' AND rider_id='" . $_POST['rider_id'] . "'";
// echo $sql;
$result = mysqli_query($link, $sql);

// get driver id from Rides table using ride id
$sql2 = "SELECT user_id FROM Rides WHERE ride_id='" . $_POST['ride_id'] . "'";
$result2 = mysqli_query($link, $sql2);
$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
$user_id = $row2["user_id"];

// calculate average driver rating of the driver
$sql3 = "SELECT AVG(driverRating) FROM RideRiders WHERE ride_id IN (SELECT ride_id FROM Rides WHERE user_id=$user_id)";
$result3 = mysqli_query($link, $sql3);
$row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
$rating = round($row3["AVG(driverRating)"], 1);

// store driver id and avg driver rating in Metrics table
$sql4 = "SELECT COUNT(driver_id) FROM Metrics WHERE driver_id=$user_id";
$result4 = mysqli_query($link, $sql4);
$row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
if($row4["COUNT(driver_id)"] == 0) {
    $sql5 = "INSERT INTO Metrics (`driver_id`,`rating`) VALUES ('$user_id', '$rating')";
    $result5 = mysqli_query($link, $sql5);
} else {
    $sql6 = "UPDATE Metrics set rating='$rating' where driver_id=$user_id";
    $result6 = mysqli_query($link, $sql6);
}

?>