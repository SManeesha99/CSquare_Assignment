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

// Initialize variables for the form
$item = [
    'id' => '',
    'item_code' => '',
    'item_name' => '',
    'item_category' => '',
    'item_subcategory' => '',
    'quantity' => '',
    'unit_price' => ''
];

// Handle form submission for updating an item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updatebtn"])) {
    // Collect data from the form
    $itemId = $_POST["id"];
    $itemCode = $connection->real_escape_string($_POST["item_code"]);
    $itemName = $connection->real_escape_string($_POST["item_name"]);
    $itemCategory = $connection->real_escape_string($_POST["item_category"]);
    $itemSubcategory = $connection->real_escape_string($_POST["item_subcategory"]);
    $quantity = (int)$_POST["quantity"]; // Cast to int
    $unitPrice = (float)$_POST["unit_price"]; // Cast to float

    // Prepare SQL statement to update the data
    $sql = "UPDATE item SET item_code='$itemCode', item_name='$itemName', item_category='$itemCategory', 
            item_subcategory='$itemSubcategory', quantity=$quantity, unit_price=$unitPrice WHERE id=$itemId";

    // Execute the query and check for success
    if ($connection->query($sql) === TRUE) {
        header("Location: itemview.php"); // Redirect after successful update
        exit();
    } else {
        $error_message = "Error: " . $connection->error;
    }
}

// Handle loading the item details for editing
if (isset($_GET['id'])) {
    $itemId = (int)$_GET['id'];
    $result = $connection->query("SELECT * FROM item WHERE id=$itemId");

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        die("Item not found.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Edit Item</title>
</head>
    <div class=""> 
        <!-- Navbar comes here -->
        <?php include 'navbar.php'; ?>
    </div>
<body>
    <div class="container my-5">
        <h2 class="text-center">Edit Item</h2>
        <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <div class="mb-3">
                <label for="item_code" class="form-label">Item Code</label>
                <input type="text" class="form-control" name="item_code" value="<?php echo $item['item_code']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="item_name" class="form-label">Item Name</label>
                <input type="text" class="form-control" name="item_name" value="<?php echo $item['item_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="item_category" class="form-label">Category</label>
                <input type="text" class="form-control" name="item_category" value="<?php echo $item['item_category']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="item_subcategory" class="form-label">Subcategory</label>
                <input type="text" class="form-control" name="item_subcategory" value="<?php echo $item['item_subcategory']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" value="<?php echo $item['quantity']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="unit_price" class="form-label">Unit Price</label>
                <input type="number" step="0.01" class="form-control" name="unit_price" value="<?php echo $item['unit_price']; ?>" required>
            </div>
            <button type="submit" name="updatebtn" class="btn btn-primary">Update Item</button>
            <a href="/CSquare_Assignment/itemview.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
