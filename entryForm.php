<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "materials_db";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create table if it does not exist
$table = "CREATE TABLE IF NOT EXISTS materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    name VARCHAR(100) NOT NULL,
    material VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
)";

if ($conn->query($table) === TRUE) {
    echo "Table created successfully or already exists.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $name = $_POST['name'];
    $material = $_POST['material'];
    $amount = $_POST['amount'];

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO materials (date, name, material, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $date, $name, $material, $amount);

    if ($stmt->execute()) {
        echo "Data inserted successfully!<br>";
    } else {
        echo "Error inserting data: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #444;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #4cae4c;
        }

        .form-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Material Entry Form</h1>
        <button onclick="window.location.href='index.php';">Back to home</button>
        <form method="post" action="">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="material">Material:</label>
            <input type="text" id="material" name="material" required><br>

            <label for="amount">Amount:</label>
            <input type="number" step="0.01" id="amount" name="amount" required><br>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
