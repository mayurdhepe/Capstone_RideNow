<?php
session_start();
include('dbConnect.php');
include('carDao.php');
include('driverDao.php');

$missingUsername = '<p><strong>Please enter a username!</strong></p>';
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword = '<p><strong>Please enter a Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
$missingCarMake = '<p><strong>Please enter Car Make</strong></p>';
$missingCarModel = '<p><strong>Please enter Car Model</strong></p>';
$missingSeats = '<p><strong>Please enter Seats</strong></p>';

if (empty($_POST["username"])) {
    $errors .= $missingUsername;
} else {
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
}

if (empty($_POST["email"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

if (empty($_POST["password"])) {
    $errors .= $missingPassword;
} elseif (
    !(strlen($_POST["password"]) > 6
        and preg_match(
            '/[A-Z]/',
            $_POST["password"]
        )
        and preg_match(
            '/[0-9]/',
            $_POST["password"]
        )
    )
) {
    $errors .= $invalidPassword;
} else {
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    if (empty($_POST["password2"])) {
        $errors .= $missingPassword2;
    } else {
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if ($password !== $password2) {
            $errors .= $differentPassword;
        }
    }
}

if (empty($_POST["carMake"])) {
    $errors .= $carMake;
} else {
    $carMake = filter_var($_POST["carMake"], FILTER_SANITIZE_STRING);
}

if (empty($_POST["carModel"])) {
    $errors .= $carModel;
} else {
    $carModel = filter_var($_POST["carModel"], FILTER_SANITIZE_STRING);
}

if (empty($_POST["seats"])) {
    $errors .= $missingUsername;
} else {
    $seats = filter_var($_POST["seats"], FILTER_SANITIZE_STRING);
}

if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
$carMake = mysqli_real_escape_string($link, $carMake);
$carModel = mysqli_real_escape_string($link, $carModel);
$seats = mysqli_real_escape_string($link, $seats);

$password = hash('sha256', $password);

$driverDao = new DriverDao();

$result = $driverDao->findByUsername($link, $username);
if (!$result) {
    echo '<div class="alert alert-danger">Error running the query!</div>';

    exit;
}
$results = mysqli_num_rows($result);
if ($results) {
    echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>';
    exit;
}

$result = $driverDao->findByEmail($link, $email);
if (!$result) {
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;
}
$results = mysqli_num_rows($result);
if ($results) {
    echo '<div class="alert alert-danger">That email is already registered. Do you want to log in?</div>';
    exit;
}

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
$activationKey2 = '0';

$newCar = new Car($carMake, $carModel, $seats);
$carDao = new CarDao();
$result = $carDao->save($link, $newCar);
if (!$result) {
    echo '<div class="alert alert-danger">There was an error inserting the car details in the database!</div>';
    exit;
}

$carId = $link->insert_id;

$newDriver = new Driver($username, $email, $password, $activationKey, $activationKey2, $carId);

$result = $driverDao->save($link, $newDriver);

if (!$result) {
    echo '<div class="alert alert-danger">There was an error inserting the Driver details in the database!</div>';
    exit;
}

$message = "Please the link below to activate your account:\n\n";
$message .= "http://grad-project.host20.uk/RideNow/activateDriver.php?email=" . urlencode($email) . "&key=$activationKey";
if (mail($email, 'Confirm your Registration', $message, 'From:' . 'gradproj@grad-project.host20.uk')) {
    echo "<div class='alert alert-success'>Thank you for the registration! An email has been sent to $email, please check.</div>";
} else {
    echo "<div class='alert alert-success'>FAIL!!!.</div>";
}

?>