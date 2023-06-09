<?php
session_start();
include('dbConnect.php');
include('forgotpassDriverDao.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
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
            <li class="nav-item">
            <a class="nav-link" href="metrics.php">Metrics</a>
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
    <div class="container-fluid" style="margin-left: 30rem; margin-top:3rem;">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10 contactForm" style="border: none;">
                <h1 style="color:black; margin-bottom: 2rem;">Reset Password:</h1>
                <div id="resultmessagedriver"></div>
                <?php
                if (!isset($_GET['user_id']) || !isset($_GET['key'])) {
                    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>';
                    exit;
                }
                $user_id = $_GET['user_id'];
                $key = $_GET['key'];
                $time = time() - 86400;
                $user_id = mysqli_real_escape_string($link, $user_id);
                $key = mysqli_real_escape_string($link, $key);

                $forgotDao = new ForgotDriverDao();
                $result = $forgotDao->getUser($link, $key, $user_id, $time);

                if (!$result) {
                    echo '<div class="alert alert-danger">Error running the query!</div>';
                    exit;
                }

                $count = mysqli_num_rows($result);
                if ($count !== 1) {
                    echo '<div class="alert alert-danger">Please try again.</div>';
                    exit;
                }

                echo "
<form method=post id='passwordresetdriver'>
<input type=hidden name=key value=$key>
<input type=hidden name=user_id value=$user_id>
<div class='form-group' style='margin-bottom:2rem'>
    <label for='password'>Enter your new Password:</label>
    <input type='password' name='password' id='password' placeholder='Enter Password' style='width:30rem' class='form-control'>
</div>
<div class='form-group' style='margin-bottom:2rem'>
    <label for='password2'>Re-enter Password::</label>
    <input type='password' name='password2' id='password2' placeholder='Re-enter Password' style='width:30rem' class='form-control'>
</div>
<input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>


</form>
";


                ?>

            </div>
        </div>
    </div>

    <form method="post" id="loginform">
    <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="myModalLabel">
              Rider Login
            </h4>
          </div>
          <div class="modal-body">
            <div id="loginmessage"></div>
            <div class="form-group">
              <label for="loginemail" class="sr-only">Email:</label>
              <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email"
                maxlength="50">
            </div>
            <div class="form-group">
              <label for="loginpassword" class="sr-only">Password</label>
              <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password"
                maxlength="30">
            </div>
            <div class="checkbox">
              <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal"
                data-toggle="modal">
                Forgot Password?
              </a>
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="login" type="submit" value="Login">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="loginformDriver">
    <div class="modal" id="loginModalDriver" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="myModalLabel">
              Driver Login
            </h4>
          </div>
          <div class="modal-body">
            <div id="loginmessagedriver"></div>
            <div class="form-group">
              <label for="loginemail" class="sr-only">Email:</label>
              <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email"
                maxlength="50">
            </div>
            <div class="form-group">
              <label for="loginpassword" class="sr-only">Password</label>
              <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password"
                maxlength="30">
            </div>
            <div class="checkbox">
              <a class="pull-right" style="cursor: pointer" data-dismiss="modal"
                data-target="#forgotpasswordModalDriver" data-toggle="modal">
                Forgot Password?
              </a>
            </div>

          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="login" type="submit" value="Login">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="signupform">
    <div class="modal" id="signupModalRider" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Sign up and join your first ride!
            </h4>
          </div>
          <div class="modal-body">
            <div id="signupmessage"></div>

            <div class="form-group">
              <label for="username" class="sr-only">Username:</label>
              <input class="form-control" type="text" name="username" id="username" placeholder="Username"
                maxlength="30">
            </div>
            <div class="form-group">
              <label for="email" class="sr-only">Email:</label>
              <input class="form-control" type="email" name="email" id="email" placeholder="Email Address"
                maxlength="50">
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Choose a password:</label>
              <input class="form-control" type="password" name="password" id="password" placeholder="Choose a password"
                maxlength="30">
            </div>
            <div class="form-group">
              <label for="password2" class="sr-only">Confirm password</label>
              <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password"
                maxlength="30">
            </div>
          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="signup" type="submit" value="Sign up">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form method="post" id="signupformDriver">
    <div class="modal" id="signupModalDriver" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="myModalLabel">
              Sign up and create your first ride!
            </h4>
          </div>
          <div class="modal-body">
            <div id="signupmessagedriver"></div>

            <div class="form-group">
              <label for="username" class="sr-only">Username:</label>
              <input class="form-control" type="text" name="username" id="username" placeholder="Username"
                maxlength="30">
            </div>
            <div class="form-group">
              <label for="email" class="sr-only">Email:</label>
              <input class="form-control" type="email" name="email" id="email" placeholder="Email Address"
                maxlength="50">
            </div>
            <div class="form-group">
              <label for="password" class="sr-only">Choose a password:</label>
              <input class="form-control" type="password" name="password" id="password" placeholder="Choose a password"
                maxlength="30">
            </div>
            <div class="form-group">
              <label for="password2" class="sr-only">Confirm password:</label>
              <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password"
                maxlength="30">
            </div>
            <div class="form-group">
            <select class="form-select" name="carMake" id="carMake" aria-label=".form-select-lg example">
                <option selected>Select Car Make</option>
                <option value="Toyota">Toyota</option>
                <option value="Honda">Honda</option>
                <option value="Ford">Ford</option>
                <option value="Chevrolet">Chevrolet</option>
                <option value="Nissan">Nissan</option>
              </select>
            </div>
            <div class="form-group">
            <select class="form-select"  name="carModel" id="carModel" aria-label=".form-select-lg example">
                <option selected>Select Car Model</option>
                <option value="Camry">Camry</option>
                <option value="Corolla">Corolla</option>
                <option value="Prius">Prius</option>

                <option value="Civic">Civic</option>
                <option value="Accord">Accord</option>
                <option value="CR-V">CR-V</option>

                <option value="Mustang">Mustang</option>
                <option value="F-150">F-150</option>
                <option value="Explorer">Explorer</option>

                <option value="Silverado">Silverado</option>
                <option value="Camaro">Camaro</option>
                <option value="Equinox">Equinox</option>

                <option value="Altima">Altima</option>
                <option value="Rogue">Rogue</option>
                <option value="Sentra">Sentra</option>

              </select>
            </div>
            <div class="form-group">
              <label for="seats" class="sr-only">Seating Capacity:</label>
              <input class="form-control" type="text" name="seats" id="seats" placeholder="Enter seating capacity"
                maxlength="30">
            </div>
          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="signup" type="submit" value="Sign up">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <form method="post" id="forgotpasswordform">
    <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Forgot Password? Enter your email address:
            </h4>
          </div>
          <div class="modal-body">


            <div id="forgotpasswordmessage"></div>


            <div class="form-group">
              <label for="forgotemail" class="sr-only">Email:</label>
              <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email"
                maxlength="50">
            </div>
          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="forgotpassword" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>

          </div>
        </div>
      </div>
    </div>
  </form>



  <form method="post" id="forgotpasswordformdriver">
    <div class="modal" id="forgotpasswordModalDriver" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">

            <h4 id="myModalLabel">
              Forgot Password? Enter your email address:
            </h4>
          </div>
          <div class="modal-body">


            <div id="forgotpasswordmessagedriver"></div>


            <div class="form-group">
              <label for="forgotemail" class="sr-only">Email:</label>
              <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email"
                maxlength="50">
            </div>
          </div>
          <div class="modal-footer">
            <input class="btn btn-primary" name="forgotpassword" type="submit" value="Submit">
            <button type="button" class="btn btn-dark" data-dismiss="modal">
              Cancel
            </button>

          </div>
        </div>
      </div>
    </div>
  </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $("#passwordresetdriver").submit(function (event) {
            event.preventDefault();
            var datatopost = $(this).serializeArray();
            $.ajax({
                url: "storeresetdriver.php",
                type: "POST",
                data: datatopost,
                success: function (data) {

                    $('#resultmessagedriver').html(data);
                },
                error: function () {
                    $("#resultmessagedriver").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

                }

            });

        });

    </script>
</body>

</html>