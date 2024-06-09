<?php
session_start();
if (!isset($_SESSION["matric"]) || !isset($_SESSION["access"]) || $_SESSION["access"] !== true) {
    // Redirect to login page if the session is not set or access is not true
    header("Location: login.php");
    exit();
}
include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the POST request
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->updateUser($matric, $name, $role);


    header('location: read.php?update=success');
    exit();
    // Close the connection
    $db->close();
}