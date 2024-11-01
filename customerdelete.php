<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "assignment";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = $_GET['id'];
$sql = "DELETE FROM customer WHERE id = $id";

if ($connection->query($sql) === TRUE) {
    header("Location: /CSquare_Assignment/index.php"); // Redirect back to the main page
    exit;
} else {
    echo "Error deleting record: " . $connection->error;
}
?>
