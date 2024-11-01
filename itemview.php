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

// Handle form submission for adding items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitbtn"])) {
    // Collect data from the form
    $itemCode = $connection->real_escape_string($_POST["item_code"]);
    $itemName = $connection->real_escape_string($_POST["item_name"]);
    $itemCategory = $connection->real_escape_string($_POST["item_category"]);
    $itemSubcategory = $connection->real_escape_string($_POST["item_subcategory"]);
    $quantity = (int)$_POST["quantity"]; // Cast to int
    $unitPrice = (float)$_POST["unit_price"]; // Cast to float

    // Prepare SQL statement to insert the data
    $sql = "INSERT INTO item (item_code, item_name, item_category, item_subcategory, quantity, unit_price) 
            VALUES ('$itemCode', '$itemName', '$itemCategory', '$itemSubcategory', $quantity, $unitPrice)";

    // Execute the query and check for success
    if ($connection->query($sql) === TRUE) {
        // Redirect to the same page to refresh and clear the form
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error_message = "Error: " . $connection->error;
    }
}

// Initialize search variable
$search = isset($_GET['search']) ? $connection->real_escape_string($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Item Management</title>
</head>
    <div class=""> 
        <!-- Navbar comes here -->
        <?php include 'navbar.php'; ?>
    </div>
<body>
    <div class="container my-5">
        <div class="row">
            <!-- Left Column: List of Items -->
            <div class="col-md-8 ">
                <h2 class="text-center">List of Items</h2>

                <!-- Search Form -->
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by item details" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>

                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Subcategory</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Read rows from the database table, filtering based on the search input
                            $sql = "SELECT * FROM item";
                            if (!empty($search)) {
                                $sql .= " WHERE item_name LIKE '%$search%' OR item_code LIKE '%$search%'";
                            }
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }

                            // Read data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <td>$row[item_code]</td>
                                    <td>$row[item_name]</td>
                                    <td>$row[item_category]</td>
                                    <td>$row[item_subcategory]</td>
                                    <td>$row[quantity]</td>
                                    <td>$row[unit_price]</td>
                                    <td>
                                        <a class='btn btn-primary' href='itemedit.php?id=$row[id]' role='button'>Edit</a>
                                        <a class='btn btn-danger' href='#' role='button' onclick='confirmDelete($row[id])'>Delete</a>
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
                <script>
                    function confirmDelete(id) {
                        if (confirm("Are you sure you want to delete this item?")) {
                            // If the user clicks "OK", redirect to the delete script
                            window.location.href = '/CSquare_Assignment/itemdelete.php?id=' + id;
                        }
                    }
                </script>
            </div>

            <!-- Right Column: Add Item Form -->
            <div class="col-md-4 border-start">
                <h2 class="text-center">Add Item</h2>

                <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

                <form class="row needs-validation" method="POST" novalidate>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label class="form-label">Item Code</label>
                            <input type="text" class="form-control" name="item_code" required>
                            <div class="invalid-feedback">Please enter a valid Item Code</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="item_name" required>
                            <div class="invalid-feedback">Please enter a valid Item Name</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="item_category" required>
                            <div class="invalid-feedback">Please enter a valid Category</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Subcategory</label>
                            <input type="text" class="form-control" name="item_subcategory" required>
                            <div class="invalid-feedback">Please enter a valid Subcategory</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" required>
                            <div class="invalid-feedback">Please enter a valid Quantity</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" class="form-control" name="unit_price" required>
                            <div class="invalid-feedback">Please enter a valid Unit Price</div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button class="btn btn-primary btn-xl mt-4" type="submit" name="submitbtn">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
