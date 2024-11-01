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

if (isset($_POST['searchBtn'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Prepare SQL query to fetch invoice records within the date range and search criteria
    $sql = "SELECT invoice.date, invoice.invoice_no, invoice.customer, invoice.item_count, invoice.amount, customer.district, customer.first_name 
            FROM `invoice` 
            LEFT JOIN customer ON invoice.customer = customer.id 
            WHERE invoice.date BETWEEN '$from_date' AND '$to_date'";
} else {
    // Default SQL query to fetch all invoices
    $sql = "SELECT invoice.date, invoice.invoice_no, invoice.customer, invoice.item_count, invoice.amount, customer.district, customer.first_name 
            FROM `invoice` 
            LEFT JOIN customer ON invoice.customer = customer.id";
}

$results = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report</title>
</head>
<body>

    <!-- Navbar -->
    <div>
        <?php include 'navbar.php'; // Include your navbar file ?>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center">Invoice Report</h2>
            <form class="needs-validation" method="POST" novalidate>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                            <div class="invalid-feedback">Please select a start date.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                            <div class="invalid-feedback">Please select an end date.</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <button type="submit" name="searchBtn" class="btn btn-primary btn-xl">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Invoice Table -->
        <div class="row justify-content-center">
            <table id="table" class="table center mt-4">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Date</th>
                        <th scope="col">Customer ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Customer District</th>
                        <th scope="col">Item Count</th>
                        <th scope="col">Invoice Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the results in the table
                    while ($row = mysqli_fetch_assoc($results)) {
                        echo "<tr style='vertical-align:middle;'>";
                        echo "<td>" . $row["invoice_no"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["customer"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["district"] . "</td>";
                        echo "<td>" . $row["item_count"] . "</td>";
                        echo "<td>" . $row["amount"] . "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Form validation for Bootstrap
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Close database connection
$connection->close();
?>
