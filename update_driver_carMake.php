<?php
session_start();
include('dbConnect.php');
$user_id = $_SESSION['user_id'];
$carMake = $_POST['carMake'];
$sql = "SELECT * FROM Driver WHERE user_id=$user_id";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if ($count == 1) {
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $carId = $row["car_id"];
  $sql = "UPDATE Car SET carMake='$carMake' WHERE id=$carId";
  $result = mysqli_query($link, $sql);
  if (!$result) {
    echo '<div class="alert alert-danger">There was an error updating the car Make in the database!</div>';
  } else {
    $_SESSION['carMake'] = $carMake;
  }
} else {
  echo "There was an error retrieving the driver username and email from the database";
}

?>