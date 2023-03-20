<?php
session_start();
include('dbConnect.php');
include('userDao.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Activation</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1 {
            color: purple;
        }

        .contactForm {
            border: 1px solid #7c73f6;
            margin-top: 50px;
            border-radius: 15px;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">RideNow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Login
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a href="#loginModal" class="dropdown-item" data-toggle="modal">Rider Login</a>
                <a href="#loginModalDriver" class="dropdown-item" data-toggle="modal">Driver Login</a>
            </div>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Sign Up
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <a href="#signupModalRider" class="dropdown-item" data-toggle="modal">Rider Sign Up</a>
                <a href="#signupModalDriver" class="dropdown-item" data-toggle="modal">Driver Sign Up</a>
            </div>
            </li>

        </ul>
        
        </div>
  </nav>
    <div style="margin-left: 10rem; margin-top:3rem;" class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10 contactForm" style="border: none;">
                <h1 style="margin-bottom: 2rem; color: black">Account Activation</h1>
                <?php

                if (!isset($_GET['email']) || !isset($_GET['key'])) {
                    echo '<div class="alert alert-danger">There was an error. Please click on the activation link you received by email.</div>';
                    exit;
                }

                $email = $_GET['email'];
                $key = $_GET['key'];

                $email = mysqli_real_escape_string($link, $email);
                $key = mysqli_real_escape_string($link, $key);

                $userDao = new UserDao();
                $result = $userDao->activate($link, $email, $key);


                if (mysqli_affected_rows($link) == 1) {
                    echo '<div class="alert alert-success">Your account has been activated.</div>';
                    echo '<a href="index.php" type="button" class="btn-lg btn-sucess logIn">Log in<a/>';

                } else {

                    echo '<div class="alert alert-danger">Your account could not be activated. Please try again later.</div>';

                }
                ?>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>