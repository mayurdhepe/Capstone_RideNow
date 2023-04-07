<?php
session_start();
include('dbConnect.php');
include('userDao.php');

$missingUsername = '<p><strong>Please enter a username!</strong></p>';
$missingEmail = '<p><strong>Please enter your email address!</strong></p>';
$invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
$missingPassword = '<p><strong>Please enter a Password!</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least 6 characters long and inlcude one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';

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

if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);

$password = hash('sha256', $password);

$userDao = new UserDao();

$result = $userDao->findByUsername($link, $username);
if (!$result) {
    echo '<div class="alert alert-danger">Error running the query!</div>';

    exit;
}
$results = mysqli_num_rows($result);
if ($results) {
    echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>';
    exit;
}

$result = $userDao->findByEmail($link, $email);
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
$newUser = new User($username, $email, $password, $activationKey, $activationKey2);

$result = $userDao->save($link, $newUser);

if (!$result) {
    echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
    exit;
}

$message = "Please click on this link to activate your account:\n\n";
$message .= "http://grad-project.host20.uk/RideNow/activate.php?email=" . urlencode($email) . "&key=$activationKey";
if (mail($email, 'Confirm your Registration', $message, 'From:' . 'gradproj@grad-project.host20.uk')) {
    echo "<div class='alert alert-success'>Thank for your registring! A confirmation email has been sent to $email. Please click on the activation link to activate your account.</div>";
} else {
    echo "<div class='alert alert-success'>FAIL!!!.</div>";
}

?>