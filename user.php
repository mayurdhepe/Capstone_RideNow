<?php
session_start();
class User
{
    private $username;
    private $email;
    private $password;

    private $activation;

    private $activation2;

    // function __construct()
    // {
    // }

    function __construct($username, $email, $password, $activation, $activation2)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->activation = $activation;
        $this->activation2 = $activation2;
    }

    function set_username($username)
    {
        $this->username = $username;
    }
    function get_username()
    {
        return $this->username;
    }

    function set_email($email)
    {
        $this->email = $email;
    }
    function get_email()
    {
        return $this->email;
    }

    function set_password($password)
    {
        $this->password = $password;
    }
    function get_password()
    {
        return $this->password;
    }

    function set_activation($activation)
    {
        $this->activation = $activation;
    }
    function get_activation()
    {
        return $this->activation;
    }

    function set_activation2($activation2)
    {
        $this->activation2 = $activation2;
    }
    function get_activation2()
    {
        return $this->activation2;
    }

}
?>