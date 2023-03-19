<?php
session_start();
include('user.php');

class UserDao
{
    function __construct()
    {
    }

    function save($link, User $newUser)
    {
        $username = $newUser->get_username();
        $email = $newUser->get_email();
        $password = $newUser->get_password();
        $activation = $newUser->get_activation();
        $activation2 = $newUser->get_activation2();
        $sql = "INSERT INTO users (`username`, `email`, `password`, `activation`, `activation2`) VALUES ('$username', '$email', '$password', '$activation', '$activation2')";
        return mysqli_query($link, $sql);
    }

    function findByUsername($link, $username)
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        return mysqli_query($link, $sql);
    }

    function findByEmail($link, $email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        return mysqli_query($link, $sql);
    }

    function login($link, $email, $password)
    {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND activation='activated'";
        return mysqli_query($link, $sql);
    }

    function activate($link, $email, $key)
    {
        $sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
        return mysqli_query($link, $sql);
    }

    function updatePass($link, $password, $user_id)
    {
        $sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
        return mysqli_query($link, $sql);
    }

}
?>