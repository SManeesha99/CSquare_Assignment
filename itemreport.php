<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "assignment";

// Create a connection to the database
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to fetch item details grouped by item name
$sql = "SELECT item_name, SUM(quantity) as item_quantity, item_category, item_subcategory 
        FROM item 
        GROUP BY item_name, item_category, item_subcategory";

$results = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
</head>
<body>

<div class="">
    <!-- Navbar placeholder -->
    <?php include 'navbar.php'; ?>
</div>

<!-- Table -->
<div class="container">
    <h2 class="text-center">Item Report</h2>
    
    <!-- Item Report Table -->
    <div class="row justify-content-center">
        <table id="table" class="table center">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Item Name</th>
                    <th scope="col">Item Category</th>
                    <th scope="col">Item Subcategory</th>
                    <th scope="col">Item Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetching data to display in the table
                while ($row = mysqli_fetch_assoc($results)) {
                    echo "<tr style='vertical-align:middle;'>";
                    echo "<td>" . htmlspecialchars($row["item_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["item_category"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["item_subcategory"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["item_quantity"]) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
