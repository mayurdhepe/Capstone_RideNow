<?php
$link = mysqli_connect("localhost", "gradproj_RideNowDB", "123", "gradproj_RideNowDB");
if (mysqli_connect_error()) {
    die('Unable to connect:' . mysqli_connect_error());
}
?>