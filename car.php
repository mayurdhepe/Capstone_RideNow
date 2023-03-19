<?php
session_start();
class Car
{
    private $carMake;
    private $carModel;
    private $seats;

    function __construct($carMake, $carModel, $seats)
    {
        $this->carMake = $carMake;
        $this->carModel = $carModel;
        $this->seats = $seats;
    }

    function set_carMake($carMake)
    {
        $this->carMake = $carMake;
    }
    function get_carMake()
    {
        return $this->carMake;
    }

    function set_carModel($carModel)
    {
        $this->carModel = $carModel;
    }
    function get_carModel()
    {
        return $this->carModel;
    }

    function set_seats($seats)
    {
        $this->seats = $seats;
    }
    function get_seats()
    {
        return $this->seats;
    }

}
?>