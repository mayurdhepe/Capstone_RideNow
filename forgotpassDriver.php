<?php

session_start();
include('dbConnect.php');
include('driverDao.php');
include('forgotpassDriverDao.php');

$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingEmail = '<p><strong>Please enter your password!</strong></p>';
$invalidPassword = '<p><strong>Please enter a valid password!</strong></p>';



if (empty($_POST["forgotemail"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["forgotemail"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

$email = mysqli_real_escape_string($link, $email);

$driverDao = new DriverDao();

$result = $driverDao->findByEmail($link, $email);

if (!$result) {
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;
}
$count = mysqli_num_rows($result);

if ($count != 1) {
    echo '<div class="alert alert-danger">That email does not exist on our database!</div>';
    exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];

$key = bin2hex(openssl_random_pseudo_bytes(16));

$time = time();
$status = 'pending';

$forgotDao = new ForgotDriverDao();
$forgotDao->save($link, $user_id, $key, $time, $status);
if (!$result) {
    echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
    exit;
}

$message = "Please click on this link to reset your password:\n\n";
$message .= "http://grad-project.host20.uk/RideNow/resetDriver.php?user_id=$user_id&key=$key";
if (mail($email, 'Reset your password', $message, 'From:' . 'gradproj@grad-project.host20.uk')) {
    echo "<div class='alert alert-success'>An email has been sent to $email. Please click on the link to reset your password.</div>";
}

?>