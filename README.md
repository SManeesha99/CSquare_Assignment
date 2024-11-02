# CSquare_Assignment - ERP System

This project fulfills the requirements specified for the ERP System.

1. **Download the Project**:
   - Download the zip file containing the project.

2. **Extract and Move the Project**:
   - Extract the zip file and move the project folder to the `htdocs` directory of your XAMPP server. The default location is:
     ```bash
     C:\xampp\htdocs
     ```

3. **Import the Database**:
   - Open **phpMyAdmin** in your browser by navigating to `localhost/phpmyadmin`.
   - Create a new database.
   - Import the provided `.sql` file into the newly created database.

4. **Update Database Configuration**:
   - Open the `con.php` file located in the project folder.
   - Update the database credentials with your MySQL server details:
     ```php
     $servername = "localhost";
     $username = "your_username";
     $password = "your_password";
     $dbname = "your_database_name";
     ```

5. **Run the Project**:
   - Open your browser and type the following URL to launch the project:
     ```bash
     http://localhost/CSquareAssignment/index.php
     ```

## Environment Setup

To run this project, ensure you have the following installed and configured:
- **XAMPP**: Make sure both Apache and MySQL servers are running.
- **phpMyAdmin**: For managing the database, accessible via XAMPP.

## Assumptions & Features

### Task 1: Customer Management
- **Middle Name**: The form does not include a middle name field, as it was not specified.
- **Search Functionality**: Implemented as a filter using District No, First Name, and Last Name, since search was implied alongside insert, update, and delete features.
- **Customer List**: The district number is added directly to the table, assuming that database joins were unnecessary.

### Task 2: Item Management
- **Select Options**: Database-dependent values are fetched using PHP and displayed as select options in the form.
- **Filter Function**: Users can filter items by name and code.

### Task 3: Report Generation
- **Date Range Search**: Added a date range search validation, as specified in the requirements. No update or delete features were implemented.
- **SQL Joins**: Used to retrieve relevant data for reporting purposes.
- **Distinct Item Names**: Ensured that item names are unique and quantities are grouped appropriately.

## Additional Assumptions

- **Database Relationships**: The database schema did not include relationships between tables. Although adding relationships would simplify some queries, all requirements were met using PHP and SQL.

---
