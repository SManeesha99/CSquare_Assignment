<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "assignment";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['searchBtn'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Prepare SQL query to fetch invoice records within the date range and search criteria
    $sql = "SELECT 
                invoice.customer, 
                invoice.invoice_no, 
                invoice.date, 
                CONCAT(customer.first_name, ' ', customer.last_name) AS 'name',
                invoice_master.item_id,
                item.item_name,
                item.item_code,
                item.item_category,
                invoice_master.unit_price
            FROM invoice
            JOIN invoice_master ON invoice.invoice_no = invoice_master.invoice_no
            JOIN item ON item.id = invoice_master.item_id
            JOIN customer ON customer.id = invoice.customer
            WHERE invoice.date BETWEEN '$from_date' AND '$to_date'";
} else {
    // Default SQL query to fetch all invoices
    $sql = "SELECT 
                invoice.customer, 
                invoice.invoice_no, 
                invoice.date, 
                CONCAT(customer.first_name, ' ', customer.last_name) AS 'name',
                invoice_master.item_id,
                item.item_name,
                item.item_code,
                item.item_category,
                invoice_master.unit_price
            FROM invoice
            JOIN invoice_master ON invoice.invoice_no = invoice_master.invoice_no
            JOIN item ON item.id = invoice_master.item_id
            JOIN customer ON customer.id = invoice.customer";
}

$results = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Item Report</title>
</head>
<body>

    <!-- Navbar -->
    <div>
        <?php include 'navbar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center">Invoice Item Report</h2>
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

        <!-- Invoice Item report View Table -->
        <div class="row justify-content-center">
            <table id="table" class="table center mt-4">
                <thead>
                    <tr class="table-primary">
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Invoiced Date</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Item Code</th>
                        <th scope="col">Item Category</th>
                        <th scope="col">Item Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the results in the table
                    while ($row = mysqli_fetch_assoc($results)) {
                        echo "<tr style='vertical-align:middle;'>";
                        echo "<td>" . $row["invoice_no"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["item_name"] . "</td>";
                        echo "<td>" . $row["item_code"] . "</td>";
                        echo "<td>" . $row["item_category"] . "</td>";
                        echo "<td>" . $row["unit_price"] . "</td>";
                        echo "</tr>";
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
