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

                            // Read all rows from the database table
                            $sql = "SELECT * FROM customer";
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
                                        <a class='btn btn-primary' href='/ERP_System/customeredit.php?id=$row[id]' role='button'>Edit</a>
                                        <a class='btn btn-danger' href='/ERP_System/customerdelete.php?id=$row[id]' role='button'>Delete</a>
                                    </td>
                                </tr>
                                ";
                            }

                            // Function to add a new customer
                            function addCustomer($connection) {
                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitbtn'])) {
                                    // Get form data
                                    $title = $_POST['selectTitle'];
                                    $firstName = $_POST['firstName'];
                                    $lastName = $_POST['lastName'];
                                    $contact = $_POST['contact'];
                                    $district = $_POST['district'];

                                    // SQL query to insert data
                                    $sql = "INSERT INTO customer (title, first_name, last_name, contact_no, district) 
                                            VALUES ('$title', '$firstName', '$lastName', '$contact', '$district')";

                                    if ($connection->query($sql) === TRUE) {
                                        echo "<script>alert('New customer added successfully');</script>";
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $connection->error;
                                    }
                                }
                            }

                            // Call the function to handle form submission
                            addCustomer($connection);
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Right Column: Add Customer Form -->
            <div class="col-md-6">
                <h2 class="text-center">Add Customer</h2>
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
                            <input type="number" class="form-control" name="district" required>
                            <div class="invalid-feedback">Please enter a valid District No</div>
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
