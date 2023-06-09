<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("location: index.php");
}
include('dbConnect.php');

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM Driver WHERE user_id=$user_id";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if ($count == 1) {
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $username = $row["username"];
  $email = $row["email"];
  $carId = $row["car_id"];
  $picture = $row['profilepicture'];

  $sql = "SELECT * FROM Car WHERE id=$carId";
  $result = mysqli_query($link, $sql);

  $count = mysqli_num_rows($result);

  if ($count == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $carMake = $row["carMake"];
    $carModel = $row["carModel"];
    $seats = $row["seats"];

    $sql = "SELECT AVG(driverRating) FROM RideRiders WHERE ride_id IN (SELECT ride_id FROM Rides WHERE user_id=$user_id)";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $rating = round($row["AVG(driverRating)"], 1);

    $sql = "SELECT SUM(price*(capacity-seatsavailable)) as Results FROM Rides WHERE user_id=$user_id AND status = 2";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $earnings = $row["Results"];

    $sql = "SELECT SUM(distance) as TotalDistance FROM Rides WHERE user_id=$user_id AND status = 2";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $totalDistance = $row["TotalDistance"];

    $sql = "SELECT COUNT(*) as TotalTrips FROM Rides WHERE user_id=$user_id AND status = 2";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $totalTrips = $row["TotalTrips"];

  } else {
    echo "There was an error retrieving the username and email from the database";
  }
} else {
  echo "There was an error retrieving the username and email from the database";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/app.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
  <style>
    #container {
      margin-top: 100px;
      
    }

    .buttons {
      margin-bottom: 20px;
    }

    tr {
      cursor: pointer;
    }

    .preview {
      height: 40px;
      border-radius: 50%;
    }

    .preview2 {
      height: auto;
      max-width: 100%;
      border-radius: 50%;
    }
    .footer {
            margin-top: 5rem;
            position: relative;
            left: 0px;
            bottom: 0px;
        }

    .rating__star {
      cursor: pointer;
      color: #dabd18b2;
    }

  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="loggedInDriver.php">RideNow</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active"><a class="nav-link" href="profileDriver.php">Profile<span
              class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="createRide.php">Create a Ride</a>
        </li>


      </ul>
      <ul class="navbar-nav">
        <li><a href="#">
            <?php
            if (empty($picture)) {
              echo "<div class='image_preview'  data-target='#updatepicture' data-toggle='modal'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
            } else {
              echo "<div class='image_preview' data-target='#updatepicture' data-toggle='modal'><img class='preview' src='$picture' /></div>";
            }

            ?>
          </a></li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?logout=1">Log Out</a>
        </li>
      </ul>

    </div>
  </nav>

  <div class="container" id="container">
    <div class="row">
      <div class="driverProf col-md-offset-3 col-md-6">

        <h2>Profile Details</h2>
        <div class="table-responsive driverTable">
          <table class="table table-hover table-condensed table-bordered">
            <tr data-target="#updateusername" data-toggle="modal">
              <td>Username</td>
              <td>
                <?php echo $username; ?>
              </td>
            </tr>
            <tr data-target="#updateemail" data-toggle="modal">
              <td>Email</td>
              <td>
                <?php echo $email ?>
              </td>
            </tr>
            <tr data-target="#updatepassword" data-toggle="modal">
              <td>Password</td>
              <td>hidden</td>
            </tr>
            <tr>
              <td>Rating</td>
              <td>
                <?php echo $rating ?>
                <i class="rating__star fas fa-star fa-lg"></i>
              </td>
            </tr>
            <tr>
              <td>Total Earnings</td>
              <td>
                $
                <?php echo $earnings ?>
              </td>
            </tr>
            <tr>
              <td>Distance Travelled</td>
              <td>
                <?php echo $totalDistance ?> Miles
              </td>
            </tr>
            <tr>
              <td>Number of Trips</td>
              <td>
                <?php echo $totalTrips ?>
              </td>
            </tr>
            <tr data-target="#updateCarMake" data-toggle="modal">
              <td>Car Make</td>
              <td>
                <?php echo $carMake; ?>
              </td>
            </tr>
            <tr data-target="#updateCarModel" data-toggle="modal">
              <td>Car Model</td>
              <td>
                <?php echo $carModel; ?>
              </td>
            </tr>
            <tr data-target="#updateSeats" data-toggle="modal">
              <td>Seats</td>
              <td>
                <?php echo $seats; ?>
              </td>
            </tr>
          </table>

        </div>

      </div>
    </div>
  </div>

  <form method="post" id="updateusernameform">
    <div class="modal" id="updateusername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Edit Username:
            </h4>
          </div>
          <div class="modal-body">
            <div id="updateusernamemessage"></div>


            <div class="form-group">
              <label for="username">Username:</label>
              <input class="form-control" type="text" name="username" id="username" maxlength="30"
                value="<?php echo $username; ?>">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updateusername" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="updateemailform">
    <div class="modal" id="updateemail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Enter new email:
            </h4>
          </div>
          <div class="modal-body">

            <div id="updateemailmessage"></div>


            <div class="form-group">
              <label for="email">Email:</label>
              <input class="form-control" type="email" name="email" id="email" maxlength="50"
                value="<?php echo $email ?>">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updateusername" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="updatepasswordform">
    <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Enter Current and New password:
            </h4>
          </div>
          <div class="modal-body">

            <div id="updatepasswordmessage"></div>


            <div class="form-group">
              <label for="currentpassword" class="sr-only">Your Current Password:</label>
              <input class="form-control" type="password" name="currentpassword" id="currentpassword" maxlength="30"
                placeholder="Your Current Password">
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Choose a password:</label>
              <input class="form-control" type="password" name="password" id="password" maxlength="30"
                placeholder="Choose a password">
            </div>
            <div class="form-group">
              <label for="password2" class="sr-only">Confirm password:</label>
              <input class="form-control" type="password" name="password2" id="password2" maxlength="30"
                placeholder="Confirm password">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updateusername" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="updateCarMakeForm">
    <div class="modal" id="updateCarMake" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Edit Car Make:
            </h4>
          </div>
          <div class="modal-body">

            <div id="updatecarMakemessage"></div>


            <div class="form-group">
              <label for="carMake">Car Make:</label>
              <input class="form-control" type="text" name="carMake" id="carMake" maxlength="30"
                value="<?php echo $carMake; ?>">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updatecarMake" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="updatecarModelForm">
    <div class="modal" id="updateCarModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Edit Car Model:
            </h4>
          </div>
          <div class="modal-body">

            <div id="updatecarModelmessage"></div>


            <div class="form-group">
              <label for="carModel">Car Model:</label>
              <input class="form-control" type="text" name="carModel" id="carModel" maxlength="30"
                value="<?php echo $carModel; ?>">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updatecarModel" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="updateSeatsForm">
    <div class="modal" id="updateSeats" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="myModalLabel">
              Edit Seats:
            </h4>
          </div>
          <div class="modal-body">
            <div id="updateSeatsmessage"></div>


            <div class="form-group">
              <label for="seats">Seats:</label>
              <input class="form-control" type="text" name="seats" id="seats" maxlength="30"
                value="<?php echo $seats; ?>">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updateSeats" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <!-- Update Picture -->
  <!-- <form method="post" id="updatepictureform" enctype="multipart/form-data">
    <div class="modal" id="updatepicture" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Upload Picture:
            </h4>
          </div>
          <div class="modal-body">
            <div id="updatepicturemessage"></div>

            <div>
              <!?php
              if (empty($picture)) {
                echo "<div class='preview2'><img id='preview2' src='profilepictures/noimage.jpg' /></div>";
              } else {
                echo "<div class='preview2'><img id='preview2' src='$picture' /></div>";
              }

              ?> -->
  <!-- </div>

            <div class="form-group">
              <label for="picture">Select a picture:</label>
              <input type="file" name="picture" id="picture">
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="updateusername" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form> -->

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="profileDriver.js"></script>
  <script src="https://kit.fontawesome.com/1f2bae3960.js" crossorigin="anonymous"></script>
</body>

</html>