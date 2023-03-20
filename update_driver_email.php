<?php
session_start();
include('dbConnect.php');
$user_id = $_SESSION['user_id'];
$newemail = $_POST['email'];

$sql = "SELECT * FROM Driver WHERE email='$newemail'";
$result = mysqli_query($link, $sql);
$count = $count = mysqli_num_rows($result);
if ($count > 0) {
    echo "<div class='alert alert-danger'>There is already a driver registered with that email! Please choose another one!</div>";
    exit;
}
$sql = "SELECT * FROM Driver WHERE user_id=$user_id";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);

if ($count == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $email = $row['email'];
} else {
    echo "<div class='alert alert-danger'>There was an error retrieving the email from the database</div>";
    exit;
}

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
$sql = "UPDATE Driver SET activation2='$activationKey' WHERE user_id = $user_id";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "<div class='alert alert-danger'>There was an error inserting the driver details in the database.</div>";
    exit;
} else {
    $message = "Please click on this link prove that you own this email:\n\n";
    $message .= "http://grad-project.host20.uk/RideNow/activateNewDriver.php?email=" . urlencode($email) . "&newemail=" . urlencode($newemail) . "&key=$activationKey";
    if (mail($newemail, 'Email Update', $message, 'From:' . 'gradproj@grad-project.host20.uk')) {
        echo "<div class='alert alert-success'>An email has been sent to $newemail. Please click on the link to prove you own that email address.</div>";
    }

}


?>