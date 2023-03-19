<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("location: index.php");
}
include('dbConnect.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id=$user_id";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if ($count == 1) {
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $username = $row["username"];
  $email = $row["email"];
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

    #notePad,
    #allNotes,
    #done {
      display: none;
    }

    .buttons {
      margin-bottom: 20px;
    }

    textarea {
      width: 100%;
      max-width: 100%;
      font-size: 16px;
      line-height: 1.5em;
      border-left-width: 20px;
      border-color: #CA3DD9;
      color: #CA3DD9;
      background-color: #FBEFFF;
      padding: 10px;

    }

    tr {
      cursor: pointer;
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
        <li class="nav-item"><a class="nav-link" href="profile.php">Profile<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Search Rides</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php?logout=1">Log Out</a>
        </li>
      </ul>

    </div>
  </nav>

  <div class="container" id="container">
    <div class="row">
      <div class="col-md-offset-3 col-md-6">

        <h2>General Account Settings:</h2>
        <div class="table-responsive">
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
  <script src="profile.js"></script>
</body>

</html>