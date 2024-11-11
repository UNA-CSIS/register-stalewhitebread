<?php 
session_start();

// get all 3 strings from the form (and scrub w/ validation function)
include_once 'validate.php';
$username = test_input($_POST['user']);
$password = test_input($_POST['pwd']);
$repeatPassword = test_input($_POST['repeat']);
// make sure that the two password values match!
if ($password !== $repeatPassword) {
    $_SESSION['error'] = "Passwords do not match.";
    header("location: register.php");
    exit();
}

// create the password_hash using the PASSWORD_DEFAULT argument
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// login to the database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "softball";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// make sure that the new user is not already in the database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['error'] = "Username is already taken.";
    $conn->close();
    header("location: register.php");
    exit();
}
// insert username and password hash into db (put the username in the session
// or make them login)
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['username'] = $username;
    header("location: games.php");
    exit();
} else {
    $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    header("location: register.php");
    exit();
}

$conn->close();
?>