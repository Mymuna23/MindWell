<?php
    // --- PHP LOGIC FIRST ---
    // All server-side logic must be processed before any HTML is sent to the browser.
    
    // 1. START THE SESSION
    // This must be called before any output, including HTML, spaces, or text.
    session_start();

    // 2. INCLUDE DATABASE CONNECTION
    // Ensure this file does not output anything (like error messages on success).
    include './connect.php'; 

    // 3. REDIRECT IF ALREADY LOGGED IN
    // If a user with an active session visits this page, send them to their profile.
    if (isset($_SESSION["userID"])) {
        header('Location: profile.php');
        exit(); // Stop script execution after a redirect
    }

    $login_error_message = ''; // Initialize an empty variable to hold error messages

    // 4. PROCESS FORM SUBMISSION
    // Check if the request method is POST, which indicates the form was submitted.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $conn = OpenCon();

            // --- SECURITY IMPROVEMENT: USE PREPARED STATEMENTS ---
            // This prevents SQL injection attacks, which your original code was vulnerable to.
            // Never insert variables directly into your SQL queries.
            $sql = "SELECT userID, password FROM Users WHERE email = ?";
            
            // Prepare the statement
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                // Handle error, e.g., die('MySQL prepare error: ' . $conn->error);
                $login_error_message = "<div class='alert alert-danger mt-3'>An unexpected error occurred. Please try again later.</div>";
            } else {
                // Bind the email parameter
                $stmt->bind_param("s", $_POST['email']);
                
                // Execute the query
                $stmt->execute();
                
                // Get the result
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // --- PASSWORD VERIFICATION ---
                    // Your current code stores passwords in plain text. This is highly insecure.
                    // You should use password_hash() when signing up and password_verify() here.
                    // Example: if (password_verify($_POST['password'], $row['password'])) { ... }
                    
                    // For now, using direct comparison as per your original logic:
                    if ($_POST['password'] === $row['password']) {
                        // Passwords match, login is successful.
                        $_SESSION['userID'] = $row['userID'];
                        header('Location: profile.php');
                        exit();
                    } else {
                        // Password does not match
                        $login_error_message = "<div class='alert alert-danger mt-3'>Invalid email or password. Please try again.</div>";
                    }
                } else {
                    // No user found with that email
                    $login_error_message = "<div class='alert alert-danger mt-3'>Invalid email or password. Please try again.</div>";
                }
                $stmt->close();
            }
            CloseCon($conn);
        } else {
            $login_error_message = "<div class='alert alert-warning mt-3'>Please enter both email and password.</div>";
        }
    }
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Crucial for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mental Health Webapp</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" xintegrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <!-- Google Fonts for a nicer look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom Styles for responsiveness and modern look -->
    <style>
        body, html {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: #138441; /* Your original background color */
        }

        .main-container {
            display: flex;
            align-items: center; /* Vertical center */
            justify-content: center; /* Horizontal center */
            min-height: 100vh;
            padding: 1rem;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
            padding: 2.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            color: #333; /* Darker text for readability */
            width: 100%;
        }

        .form-control {
            border-radius: 8px;
            padding: 1.25rem 1rem;
        }

        .btn-custom-login {
            background-color: #138441;
            border-color: #138441;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-custom-login:hover {
            background-color: #106a34;
            color: white;
        }

        .signup-link-container {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Bootstrap grid for responsive width. Narrows on larger screens. -->
        <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-4">
            <div class="login-card text-center">
                <h1 class="mb-2 h3">Welcome Back!</h1>
                <p class="mb-4 text-muted">Login to continue</p>

                <!-- The form action points to the current file itself -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                    <!-- Email Field -->
                    <div class="form-group text-left">
                        <label for="email">Email Address</label>
                        <!-- Note: The 'for' attribute in the label matches the 'id' of the input -->
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group text-left">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Display Login Error Message (if any) -->
                    <?php echo $login_error_message; ?>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-custom-login btn-block mt-4">Login</button>
                </form>

                <div class="signup-link-container mt-4">
                    Don't have an account? <a href="./signup.php">Sign up here</a>
                    <br>
                    <a href="index.php">Go to Home Page</a>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" xintegrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
