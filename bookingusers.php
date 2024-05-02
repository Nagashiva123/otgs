<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <style>
        /* Your CSS styles here */
        body {
           
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: orange;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>User Data</h1>

    <?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otgs";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch user data from the database
    $sql = "SELECT email, username, password,  countrycode, phonenum, gender FROM login";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data in a table
        echo '<table>';
        echo '<tr><th>Email</th><th>Username</th><th>Password</th><th>Country Code</th><th>Phone Number</th><th>Gender</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['password'] . '</td>';
            
            echo '<td>' . $row['countrycode'] . '</td>';
            echo '<td>' . $row['phonenum'] . '</td>';
            echo '<td>' . $row['gender'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No user data found.';
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
