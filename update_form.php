<?php
session_start();
if (!isset($_SESSION["matric"]) || !isset($_SESSION["access"]) || $_SESSION["access"] !== true) {
    // Redirect to login page if the session is not set or access is not true
    header("Location: login.php");
    exit();
}
include 'Database.php';
include 'User.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'];
    // Process the update using the matric value
    // For example, you can fetch the user data using the matric value and display it in a form for updating
    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $userDetails = $user->getUser($matric);

 
    $db->close();

    if ($userDetails) {
        // Display the update form with the fetched user data
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update User</title>
        </head>

        <body>
            <form action="update.php" method="post">
                <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>"><br>
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="">Please select</option>
                    <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
                    <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
                </select><br>
                <input type="submit" value="Update">
            </form>
        </body>

        </html>
        <?php
    } else {
        echo "No user found with the provided matric number.";
    }
}
?>