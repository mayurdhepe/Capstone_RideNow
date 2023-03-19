<?php
session_start();
include("dbConnect.php");
include('driverDao.php');
$missingEmail = '<p><stong>Please enter your email address!</strong></p>';
$missingPassword = '<p><stong>Please enter your password!</strong></p>';
if (empty($_POST["loginemail"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
}
if (empty($_POST["loginpassword"])) {
    $errors .= $missingPassword;
} else {
    $password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING);
}
if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
} else {
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);

    $driverDao = new DriverDao();

    $result = $driverDao->login($link, $email, $password);

    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
        exit;
    }
    $count = mysqli_num_rows($result);
    if ($count !== 1) {
        echo '<div class="alert alert-danger">Wrong Username or Password</div>';
    } else {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        echo "success";
    }
}
?>