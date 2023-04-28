<?php
session_start();
// if (!isset($_SESSION['user_id'])) {
//   header("location: index.php");
// }
include('dbConnect.php');
$usernames = array("-", "-", "-", "-", "-");
$ratings = array("-", "-", "-", "-", "-");
$pictures = array("-", "-", "-", "-", "-");


$sql = "SELECT * FROM Metrics ORDER BY rating DESC LIMIT 5";
if ($result = mysqli_query($link, $sql)) {
  if (mysqli_num_rows($result) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
      $driver_id = $row["driver_id"];
      $ratings[$i] = $row["rating"];

      $sql = "SELECT * FROM Driver WHERE user_id='$driver_id'";
      $result = mysqli_query($link, $sql);
      $row = mysqli_fetch_array($result);

      $usernames[$i] = $row["username"];
      $pictures[$i] = $row["profilepicture"];
      //echo "Hi";
      $i++;
    }
  }
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
      height: 20px;
      border-radius: 50%;
    }

    .preview2 {
      height: auto;
      max-width: 100%;
      border-radius: 50%;
    }

    .rating__star {
      cursor: pointer;
      color: #dabd18b2;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">RideNow</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">Metrics</a>
        </li>
      </ul>

    </div>
  </nav>

  <div class="container" id="container">
    <div class="row">
      <div class="driverProf col-md-offset-3 col-md-12">

        <h2>Top Rated Drivers</h2>
        <div class="table-responsive driverTable">
          <table class="table table-hover table-condensed table-bordered">
            <tr>
              <th>Username</th>
              <th>Rating</th>
              <th>Profile Photo</th>
            </tr>
            <tr>
              <td>
                <?php echo $usernames[0]; ?>
              </td>
              <td>
                <?php echo $ratings[0]; ?>
              </td>
              <td><a href="#">
                  <?php
                  if (empty($pictures[0]) || $pictures[0] == '-') {
                    echo "<div class='image_preview'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
                  } else {
                    echo "<div class='image_preview'><img class='preview' src='$pictures[0]' /></div>";
                  }

                  ?>
                </a></td>
            </tr>
            <tr>
              <td>
                <?php echo $usernames[1]; ?>
              </td>
              <td>
                <?php echo $ratings[1]; ?>
              </td>
              <td><a href="#">
                  <?php
                  if (empty($pictures[1]) || $pictures[1] == '-') {
                    echo "<div class='image_preview'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
                  } else {
                    echo "<div class='image_preview'><img class='preview' src='$pictures[1]' /></div>";
                  }

                  ?>
                </a></td>
            </tr>
            <tr>
              <td>
                <?php echo $usernames[2]; ?>
              </td>
              <td>
                <?php echo $ratings[2]; ?>
              </td>
              <td><a href="#">
                  <?php
                  if (empty($pictures[2]) || $pictures[2] == '-') {
                    echo "<div class='image_preview'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
                  } else {
                    echo "<div class='image_preview'><img class='preview' src='$pictures[2]' /></div>";
                  }

                  ?>
                </a></td>
            </tr>
            <tr>
              <td>
                <?php echo $usernames[3]; ?>
              </td>
              <td>
                <?php echo $ratings[3]; ?>
              </td>
              <td><a href="#">
                  <?php
                  if (empty($pictures[3]) || $pictures[3] == '-') {
                    echo "<div class='image_preview'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
                  } else {
                    echo "<div class='image_preview'><img class='preview' src='$pictures[3]' /></div>";
                  }

                  ?>
                </a></td>
            </tr>
            <tr>
              <td>
                <?php echo $usernames[4]; ?>
              </td>
              <td>
                <?php echo $ratings[4]; ?>
              </td>
              <td><a href="#">
                  <?php
                  if (empty($pictures[4]) || $pictures[4] == '-') {
                    echo "<div class='image_preview'><img class='preview' src='profilepictures/noimage.jpg' /></div>";
                  } else {
                    echo "<div class='image_preview'><img class='preview' src='$pictures[4]' /></div>";
                  }

                  ?>
                </a></td>
            </tr>
          </table>

        </div>

      </div>
    </div>
  </div>

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