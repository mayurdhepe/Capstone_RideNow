<?php
session_start();
include('driver.php');

class DriverDao
{
    function __construct()
    {
    }

    function save($link, Driver $newDriver)
    {
        $username = $newDriver->get_username();
        $email = $newDriver->get_email();
        $password = $newDriver->get_password();
        $activation = $newDriver->get_activation();
        $activation2 = $newDriver->get_activation2();
        $carId = $newDriver->get_carId();
        $sql = "INSERT INTO Driver (`username`, `email`, `password`, `activation`, `activation2`, `car_id`) VALUES ('$username', '$email', '$password', '$activation', '$activation2', $carId)";
        return mysqli_query($link, $sql);
    }

    function findByUsername($link, $username)
    {
        $sql = "SELECT * FROM Driver WHERE username = '$username'";
        return mysqli_query($link, $sql);
    }

    function findByEmail($link, $email)
    {
        $sql = "SELECT * FROM Driver WHERE email = '$email'";
        return mysqli_query($link, $sql);
    }

    function activateAccount($link, $email, $key)
    {
        $sql = "UPDATE Driver SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
        return mysqli_query($link, $sql);
    }

    function login($link, $email, $password)
    {
        $sql = "SELECT * FROM Driver WHERE email='$email' AND password='$password' AND activation='activated'";
        return mysqli_query($link, $sql);
    }

    function updatePass($link, $password, $user_id)
    {
        $sql = "UPDATE Driver SET password='$password' WHERE user_id='$user_id'";
        return mysqli_query($link, $sql);
    }

}
?>