<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
   
    <style>
        /* Your CSS styles here */
        body {
            background-image: url("hero-banner.jpg");
            font-family: Arial, sans-serif;
            
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }
        .form-container h2 {
            margin-top: 0;
            text-align: center;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form input[type="text"],
        .form-container form input[type="password"],
        .form-container form input[type="email"],
        .form-container form select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container form input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .form-container .create-account {
            margin-top: 20px;
            text-align: center;
        }
        .form-container .create-account a {
            color: #007bff;
            text-decoration: none;
        }
        .form-container .phone-inputs {
            display: flex;
            align-items: center; /* Align items vertically */
        }
        .form-container .phone-inputs select {
            flex: 1;
            margin-right: 5px;
            width: 30%;
        }
        .form-container .phone-inputs input[type="text"] {
            flex: 2;
            margin-left: 5px;
            width: 70%;
        }
    </style>
</head>
<body>
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

session_start();

// Check if the signup form is submitted
if (isset($_POST['signup'])) {
    // Fetch form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpass = $_POST['confirmpassword'];
    $countrycode = $_POST['countrycode'];
    $phonenum = $_POST['phonenum'];
    $gender = $_POST['gender'];

    // Perform validation
    if ($password !== $confirmpass) {
        echo "Passwords do not match. Please try again.";
        exit; // Stop further execution
    }

    // SQL query to insert user data into the database (without hashing password)
    $sql = "INSERT INTO login (email, username, password, countrycode, phonenum, gender) 
            VALUES ('$email', '$username', '$password', '$countrycode', '$phonenum', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully";
    } else {
        echo "Error creating account: " . $conn->error;
    }
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch user data based on email and password (without hashing)
    $sql = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, redirect to index.html
        header("Location: index.php");
        exit(); // Ensure that subsequent code is not executed
    } else {
        echo "Invalid email or password.";
    }
}
?>


    <div class="form-container" id="login-form">
        <!-- Login form -->
        <h2>Login</h2>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <!-- Create account link -->
        <div class="create-account">
            <p>Don't have an account? <a href="#" onclick="toggleForms()">Create one</a></p>
            <a href="admin.html"><button color="blue">ADMIN LOGIN</button></a>
        </div>
    </div>

    <div class="form-container" style="display:none;" id="create-account-form">
        <!-- Signup form -->
        <h2>Create Account</h2>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="New Username" required>
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirmpassword" placeholder="Confirm Password" required>
            <!-- Phone number inputs -->
            <div class="phone-inputs">
                <select name="countrycode" id="country-code" required onchange="updatePhoneNumberLength()">
                    <option value="">Select Country Code</option>
                    <option value="+1">+1 (USA)</option>
                    <option value="+91">+91 (India)</option>
                    <!-- Add more options as needed -->
                </select>
                <input type="text" name="phonenum" id="phone-number" placeholder="Phone Number" required>
            </div>
            <!-- Gender selection -->
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <!-- Submit button -->
            <input type="submit" name="signup" value="Create Account">
        </form>
    </div>

    <script>
        // Your JavaScript functions here
        function toggleForms() {
            var loginForm = document.getElementById("login-form");
            var createAccountForm = document.getElementById("create-account-form");

            loginForm.style.display = loginForm.style.display === "none" ? "block" : "none";
            createAccountForm.style.display = createAccountForm.style.display === "none" ? "block" : "none";
        }

        function updatePhoneNumberLength() {
            var countryCode = document.getElementById("country-code").value;
            var phoneNumberInput = document.getElementById("phone-number");
            var maxLength = 15; // Default maximum length for phone number

            // Update maximum length based on country code
            switch (countryCode) {
                case "+1": // USA
                    maxLength = 12;
                    break;
                case "+91": // India
                    maxLength = 10;
                    break;
                // Add more cases for other country codes as needed
            }

            phoneNumberInput.maxLength = maxLength;
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
