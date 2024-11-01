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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitbtn"])) {
    // Collect data from the form
    $title = $_POST["selectTitle"];
    $firstName = $connection->real_escape_string($_POST["firstName"]);
    $lastName = $connection->real_escape_string($_POST["lastName"]);
    $contact = $connection->real_escape_string($_POST["contact"]);
    $district = $connection->real_escape_string($_POST["district"]);

    // Prepare SQL statement to insert the data
    $sql = "INSERT INTO customer (title, first_name, last_name, contact_no, district) 
            VALUES ('$title', '$firstName', '$lastName', '$contact', '$district')";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>ERP System</title>
</head>
<body>
    <div class="container my-5">
        <div class="row">
            <!-- Left Column: List of Customers -->
            <div class="col-md-6">
                <h2 class="text-center">List of Customers</h2>

                <!-- Search Form -->
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by details" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>

                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">District</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Read rows from the database table, filtering based on the search input
                            $sql = "SELECT * FROM customer";
                            if (!empty($search)) {
                                $sql .= " WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR district LIKE '%$search%'";
                            }
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }

                            // Read data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <tr>
                                    <th>$row[title]</th>
                                    <td>$row[first_name]</td>
                                    <td>$row[last_name]</td>
                                    <td>$row[contact_no]</td>
                                    <td>$row[district]</td>
                                    <td>
                                        <a class='btn btn-primary' href='customeredit.php?id=$row[id]' role='button'>Edit</a>
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
                        if (confirm("Are you sure you want to delete this customer?")) {
                            // If the user clicks "OK", redirect to the delete script
                            window.location.href = '/CSquare_Assignment/customerdelete.php?id=' + id;
                        }
                    }
                </script>
            </div>

            <!-- Right Column: Add Customer Form -->
            <div class="col-md-6">
                <h2 class="text-center">Add Customer</h2>

                <?php if (isset($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

                <form class="row needs-validation" method="POST" novalidate>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label class="form-label">Select Title</label>
                            <select name="selectTitle" class="form-select" required>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="firstName" required>
                            <div class="invalid-feedback">Please enter a valid First Name</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lastName" required>
                            <div class="invalid-feedback">Please enter a valid Last Name</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Contact No.</label>
                            <input type="number" class="form-control" name="contact" required>
                            <div class="invalid-feedback">Please enter a valid Contact No</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label class="form-label">District</label>
                            <input type="text" class="form-control" name="district" required>
                            <div class="invalid-feedback">Please enter a valid District</div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button class="btn btn-primary btn-xl mt-4" type="submit" name="submitbtn">Add Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
