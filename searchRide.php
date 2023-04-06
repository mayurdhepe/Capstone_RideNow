<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Search a Ride<span class="sr-only">(current)</span></a></a>
                </li>


            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout=1">Log Out</a>
                </li>
            </ul>

        </div>
    </nav>



    <div class="container rideContainer" id="container">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-2">
                <div class="createRide">
                    <form method="post" id="formsearchrides">
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
                        <button type="button" id="searchRide" class="btn btn-lg" data-target="#rideAddModal"
                            data-toggle="modal">
                            Search Rides
                        </button>
                    </form>
                </div>
                <form method="post" id="sortsearchrides">
                    <div class="form-group">
                        <label for="dropwdownsort" class="sr-only">Select:</label>
                        <select name="dropwdownsort" id="dropwdownsort" placeholder="select" class="form-control">
                            <option value="price">Price</option>
                            <option value="seatsavailable">Available Seats</option>
                        </select>
                    </div>
                    <button type="button" id="sortRides" class="btn btn-lg" data-target="#rideAddModal"
                        data-toggle="modal">
                        Sort
                    </button>
                </form>
                <div id="ridelist" class="rides">

                </div>
            </div>

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

    <script src="js/bootstrap.min.js"></script>

    <script src="searchride.js"></script>
    <!-- <script src="googleapis.js"></script> -->
</body>

</html>