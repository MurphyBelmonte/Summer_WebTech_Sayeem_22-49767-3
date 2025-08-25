<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$errors = [];
$success = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate inputs
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = sanitizeInput($_POST['age']);
    $phone = sanitizeInput($_POST['phone']);

    // Validate Name
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors['name'] = "Only letters and spaces allowed";
    } elseif (strlen($name) < 2) {
        $errors['name'] = "Name must be at least 2 characters long";
    }

    // Validate Email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate Password
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters long";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $errors['password'] = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $errors['password'] = "Password must contain at least one lowercase letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $errors['password'] = "Password must contain at least one number";
    }

    // Validate Confirm Password
    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Please confirm your password";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    // Validate Age
    if (empty($age)) {
        $errors['age'] = "Age is required";
    } elseif (!is_numeric($age)) {
        $errors['age'] = "Age must be a number";
    } elseif ($age < 18 || $age > 120) {
        $errors['age'] = "Age must be between 18 and 120";
    }

    // Validate Phone Number
    if (empty($phone)) {
        $errors['phone'] = "Phone number is required";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors['phone'] = "Phone number must be 10-15 digits";
    }

    // If no errors, process the form
    if (empty($errors)) {
        $success = true;
        
        // Here you would typically:
        // 1. Hash the password: password_hash($password, PASSWORD_DEFAULT)
        // 2. Save to database
        // 3. Send confirmation email, etc.
        
        // For this example, we'll just display success message
    }
}

// Function to sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Display results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .result-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .error {
            color: red;
            margin: 10px 0;
            padding: 10px;
            background-color: #ffe6e6;
            border: 1px solid #ffcccc;
            border-radius: 4px;
        }
        .success {
            color: green;
            margin: 10px 0;
            padding: 10px;
            background-color: #e6ffe6;
            border: 1px solid #ccffcc;
            border-radius: 4px;
        }
        .data-display {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .back-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h2>Validation Results</h2>
        
        <?php if ($success): ?>
            <div class="success">
                <strong>Success!</strong> All fields are valid.
            </div>
            
            <div class="data-display">
                <h3>Submitted Data:</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            </div>
            
            <a href="form.html" class="back-button">Go Back</a>
            
        <?php else: ?>
            
            <?php if (!empty($errors)): ?>
                <div class="error">
                    <strong>Please correct the following errors:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <a href="form.html" class="back-button">Try Again</a>
            
        <?php endif; ?>
    </div>
</body>
</html>