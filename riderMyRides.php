<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
include('getProfilePicture.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RideNow</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUZnI9Gv3hxXe36FroZq9CyzkPAweUm5c&libraries=places"></script>

    <style>
        #container {
            margin-top: 120px;
        }

        .delete {
            display: none;
        }

        .buttons {
            margin-bottom: 20px;
        }

        .ui-datepicker {
            background: #333;
            border: 1px solid #555;
            color: #EEE;
        }

        #googleMap {
            height: 400px;
            width: 400px;
        }

        .pac-container {
            z-index: 10000 !important;
        }

        .preview {
            height: 20px;
            border-radius: 50%;
        }

        .preview2 {
            height: auto;
            max-width: 100%;
            border-radius: 50%;
        }

        #ridelist {
            margin-left: -15rem;
            /* width:90vw; */
        }

        .footer {
            margin-top: 5rem;
            position: fixed;
            bottom: 0px;
        }

        .rating {
            width: 180px;
        }

        .rating__star {
            cursor: pointer;
            color: #dabd18b2;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="loggedIn.php">RideNow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="searchRide.php">Search Rides</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="riderMyRides.php">My Rides</a>
                </li>


            </ul>
            <ul class="navbar-nav">
                <li><a href="#">
                        <?php
                        if (empty($picture)) {
                            echo "<div class='image_preview'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
                        } else {
                            echo "<div class='image_preview'><img class='preview' src='$picture' /></div>";
                        }

                        ?>
                    </a></li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout=1">Log Out</a>
                </li>
            </ul>

        </div>
    </nav>



    <div class="container rideContainer" id="container">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-2">
                <!-- <div class="createRide">
                    <button type="button" class="btn btn-lg" data-target="#rideAddModal" data-toggle="modal">
                        Search A Ride
                    </button>
                </div> -->
                <div id="ridelist" class="rides">

                </div>
            </div>

        </div>
    </div>

    <form method="post" id="formRateDriver">
        <div class="modal" id="rateDriverModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            Rate Your Driver
                        </h4>
                    </div>
                    <div class="modal-body">

                        <div id="driverRating">



                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" id="formViewDriver">
        <div class="modal" id="viewDriverModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            View Driver
                        </h4>
                    </div>
                    <div class="modal-body">

                        <div id="driverView">



                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" id="formRateRiders">
        <div class="modal" id="rateRidersModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            Rate Your Riders
                        </h4>
                    </div>
                    <div class="modal-body">

                        <div id="ridersListRating">



                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <form method="post" id="formAddRide">
        <div class="modal" id="rideAddModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="myModalLabel">
                            New Ride
                        </h4>
                    </div>
                    <div class="modal-body">


                        <div id="result"></div>

                        <!--Google Map-->
                        <div id="googleMap"></div>


                        <div class="form-group">
                            <label for="departure" class="sr-only">Start Location:</label>
                            <input type="text" name="departure" id="departure" placeholder="Start Location"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="destination" class="sr-only">Destination:</label>
                            <input type="text" name="destination" id="destination" placeholder="Destination"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price" class="sr-only">Price:</label>
                            <input type="number" name="price" id="price" placeholder="Price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="seatsavailable" class="sr-only">Seats available:</label>
                            <input type="number" name="seatsavailable" id="seatsavailable" placeholder="Seats available"
                                class="form-control">
                        </div>
                        <div class="form-group ">
                            <label for="date" class="sr-only">Date: </label>
                            <input name="date" id="date" readonly="readonly" placeholder="Date" class="form-control">
                        </div>
                        <div class="form-group time ">
                            <label for="time" class="sr-only">Time: </label>
                            <input type="time" name="time" id="time" placeholder="Time" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-primary" name="createTrip" type="submit" value="Create Ride">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php

    include("profileTemplate.php");

    ?>

    <div class="footer">
        <div class="container">
            <p>Fantastic-4 Copyright &copy;
                <?php $dt = date("Y");
                echo $dt ?>.
            </p>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <script src="ridermyride.js"></script>
    <script src="profile.js"></script>
    <script src="https://kit.fontawesome.com/1f2bae3960.js" crossorigin="anonymous"></script>
    <!-- <script src="googleapis.js"></script> -->
</body>

</html>