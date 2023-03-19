<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RideNow</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/app.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
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
          <a class="nav-link" href="#">About</a>
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

  <div class="jumbotron" id="myContainer">

    <div class="motivationDiv">
        <h3 class="aboutustitle">Motivation</h3>
        <p class="aboutustxt">Traditional taxi services do not allow users to find fellow riders or drivers who are
            heading to the same destinations or sharing the same route i.e. the allocation of drivers
            is purely random, based on availability of taxis/cabs at that particular time. They do not
            take into consideration an individual’s overall travel experience and safety. Nor do they
            allow rides to be planned in advance.
        </p>
    

        <p class="aboutustxt">
            Our objective is to create a ride sharing platform wherein drivers of rideshare vehicles
            can share the car with riders heading to the same destination thereby making the travel
            more affordable and help create a more enjoyable travel experience.
        </p>
    </div>

    <p:divider>
        <div class="p-d-inline-flex p-ai-center">
            <i class="pi pi-circle-on"></i>
        </div>
    </p:divider>

    <div class="impToSolveDiv">
        <h3 class="aboutustitle">Why Is It Important To Solve?</h3>
        <p class="aboutustxt">Ride sharing has many advantages for both riders and drivers. They make travel more
            affordable (since the cost gets divided between the riders sharing the ride) and make
            travel time seem faster and enjoyable. They allow riders to choose drivers (and vice-a-
            versa) they would be more comfortable with increasing a sense of safety.
            Also, practicing ride sharing would mean fewer cars on the road which would help
            reduce CO2 emission.
        </p>
    </div>

    <p:divider>
        <div class="p-d-inline-flex p-ai-center">
            <i class="pi pi-circle-on"></i>

        </div>
    </p:divider>

    <div class="Creators">
        <h3 class="aboutustitle">Creators</h3>
        <p class="aboutustxt">This application has been created by Mayur Dhepe, Shantanu Deore, Aditya Sarin and Aman Saraf as a part
            of the course Capstone Project (CS5934), under the guidance of Dr. Sally Hamouda.
        </p>
    </div>

  </div>


  <div class="footer">
    <div class="container">
      <p>Fantastic-4 Copyright &copy;
        <?php $dt = date("Y");
        echo $dt ?>.
      </p>
    </div>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="app.js"></script>
</body>

</html>