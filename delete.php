<?php
session_start();
if (!isset($_SESSION["matric"]) || !isset($_SESSION["access"]) || $_SESSION["access"] !== true) {
    // Redirect to login page if the session is not set or access is not true
    header("Location: login.php");
    exit();
}
include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve the matric value from the POST request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Create an instance of the User class
    $user = new User($db);
    $user->deleteUser($matric);

    header('location: read.php?delete=success');
    exit();
    // Close the connection
    $db->close();
}
