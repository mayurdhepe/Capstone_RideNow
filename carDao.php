<?php
session_start();
include('car.php');

class CarDao
{
    function __construct()
    {
    }

    function save($link, Car $car)
    {
        $carMake = $car->get_carMake();
        $carModel = $car->get_carModel();
        $seats = $car->get_seats();
        $sql = "INSERT INTO Car (`carMake`, `carModel`, `seats`) VALUES ('$carMake', '$carModel', '$seats')";
        return mysqli_query($link, $sql);
    }

}
?>