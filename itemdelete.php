<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "assignment";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle deletion
if (isset($_GET['id'])) {
    $itemId = (int)$_GET['id'];
    $sql = "DELETE FROM item WHERE id=$itemId";

    if ($connection->query($sql) === TRUE) {
        header("Location: itemview.php"); // Redirect after successful deletion
        exit();
    } else {
        die("Error deleting record: " . $connection->error);
    }
} else {
    die("Invalid request.");
}
?>
