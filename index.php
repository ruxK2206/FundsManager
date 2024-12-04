<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entry and Operations</title>
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

        .container {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        button {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Choose an Action</h1>
        <button onclick="window.location.href='entryForm.php';">Entry</button>
        <button onclick="window.location.href='operations.php';">Operations</button>
        <button onclick="window.location.href='table.php';">Table</button>
        <button onclick="window.location.href='delete.php';">Delete</button>
        
    </div>
</body>
</html>
