<?php
session_start();

class ForgotDriverDao
{
    function __construct()
    {
    }

    function save($link, $user_id, $key, $time, $status)
    {
        $sql = "INSERT INTO DriverForgot (`user_id`, `passkey`, `time`, `status`) VALUES ('$user_id', '$key', '$time', '$status')";
        return mysqli_query($link, $sql);
    }

    function getUser($link, $key, $user_id, $time)
    {
        $sql = "SELECT user_id FROM DriverForgot WHERE passkey='$key' AND user_id='$user_id' AND time > '$time' AND status='pending'";
        return mysqli_query($link, $sql);
    }

    function updatePass($link, $key, $user_id)
    {
        $sql = "UPDATE DriverForgot SET status='used' WHERE passkey='$key' AND user_id='$user_id'";
        return mysqli_query($link, $sql);
    }

}
?>