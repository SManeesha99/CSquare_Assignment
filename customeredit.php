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
$sql = "SELECT * FROM customer WHERE id = $id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Customer not found.");
}

if (isset($_POST['updateBtn'])) {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district'];

    $update_sql = "UPDATE customer SET title='$title', first_name='$first_name', last_name='$last_name', contact_no='$contact_no', district='$district' WHERE id=$id";

    if ($connection->query($update_sql) === TRUE) {
        header("Location: /CSquare_Assignment/index.php"); // Redirect back to the main page
        exit;
    } else {
        echo "Error updating record: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Customer</title>
</head>
    <div class=""> 
        <!-- Navbar comes here -->
        <?php include 'navbar.php'; ?>
    </div>
<body>
    <div class="container my-5">
        <h2 class="text-center">Edit Customer</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="contact_no" class="form-label">Contact No:</label>
                <input type="text" class="form-control" name="contact_no" value="<?php echo htmlspecialchars($row['contact_no']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District:</label>
                <input type="text" class="form-control" name="district" value="<?php echo htmlspecialchars($row['district']); ?>" required>
            </div>
            <button type="submit" name="updateBtn" class="btn btn-primary">Update</button>
            <a href="/CSquare_Assignment/index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
