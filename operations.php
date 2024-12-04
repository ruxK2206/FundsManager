<?php
// operations.php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "materials_db";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables for results
$totalAmount = 0;
$dataByName = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['calculate_total'])) {
        // Calculate total amount
        $result = $conn->query("SELECT SUM(amount) AS total FROM materials");
        if ($result && $row = $result->fetch_assoc()) {
            $totalAmount = $row['total'];
        }
    } elseif (isset($_POST['search_name'])) {
        // Retrieve data by name
        $name = $_POST['name'];
        $stmt = $conn->prepare("SELECT * FROM materials WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $dataByName[] = $row;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Operations</title>
    
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
            flex-direction: column;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #4cae4c;
        }

        .result {
            background: #e9f7ef;
            padding: 10px;
            border: 1px solid #d4edda;
            border-radius: 4px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Operations</h1>
        <button onclick="window.location.href='index.php';">Back to home</button>
        

        <!-- Form to calculate total amount -->
        <form method="post">
            <button type="submit" name="calculate_total">Calculate Total Amount</button>
        </form>

        <?php if ($totalAmount > 0): ?>
            <div class="result">
                <strong>Total Amount:</strong> <?php echo number_format($totalAmount, 2); ?>
            </div>
        <?php endif; ?>

        <!-- Form to search data by name -->
        <form method="post">
            <label for="name">Enter Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit" name="search_name">Search</button>
        </form>

        <?php if (!empty($dataByName)): ?>
            <div class="result">
                <strong>Results for "<?php echo htmlspecialchars($name); ?>":</strong>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Material</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataByName as $row): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['material']; ?></td>
                                <td><?php echo number_format($row['amount'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
