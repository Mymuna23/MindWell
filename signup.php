<?php
    // --- PHP LOGIC FIRST ---
    // All server-side logic must be processed before any HTML is sent to the browser.

    // 1. START THE SESSION
    session_start();

    // 2. INCLUDE DATABASE CONNECTION
    include 'connect.php'; 
    $conn = OpenCon(); // Open the connection once at the top

    // 3. REDIRECT IF ALREADY LOGGED IN
    if (isset($_SESSION["userID"])) {
        header('Location: profile.php');
        exit(); // Stop script execution
    }

    $signup_error_message = ''; // Variable for feedback messages

    // 4. PROCESS FORM SUBMISSION
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // --- DATA SANITIZATION AND COLLECTION ---
        $type = $_POST["type"] ?? '';
        $name = trim($_POST["name"] ?? '');
        $email = trim($_POST["email"] ?? '');
        $password = $_POST["password"] ?? '';
        
        // Use null coalescing operator for optional fields
        $age = !empty($_POST["age"]) ? $_POST["age"] : NULL;
        $location = !empty($_POST["location"]) ? trim($_POST["location"]) : NULL;
        $phone = !empty($_POST["phone"]) ? trim($_POST["phone"]) : NULL;

        // --- VALIDATION ---
        if (empty($name) || empty($email) || empty($password) || empty($type)) {
            $signup_error_message = "<div class='alert alert-danger mt-3'>Please fill out all required fields.</div>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $signup_error_message = "<div class='alert alert-danger mt-3'>Please provide a valid email address.</div>";
        } else {
            // --- SECURITY: HASH THE PASSWORD ---
            // Never store plain-text passwords.
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // --- USE PREPARED STATEMENTS TO PREVENT SQL INJECTION ---
            $sql = "INSERT INTO Users (password, name, age, location, email, phone) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            // 'ssisss' corresponds to the data types: string, string, integer, string, string, string
            $stmt->bind_param("ssisss", $hashed_password, $name, $age, $location, $email, $phone);

            if ($stmt->execute()) {
                $new_user_id = $conn->insert_id; // Get the ID of the user just created
                $_SESSION["userID"] = $new_user_id; // Log the new user in

                // Add user to either counsellor or helpseeker table
                if ($type == "Counsellor") { 
                    $yearsExp = $_POST["yearsExp"] ?? 5;
                    $cert = $_POST["cert"] ?? 'in progress';
                    $sql_role = "INSERT INTO Counsellor (userID, yearsExperience, certification) VALUES (?, ?, ?)";
                    $stmt_role = $conn->prepare($sql_role);
                    $stmt_role->bind_param("iis", $new_user_id, $yearsExp, $cert);
                } else { // HelpSeeker
                    $sql_role = "INSERT INTO HelpSeeker (userID, numCounsellors, numReviews) VALUES (?, 0, 0)";
                    $stmt_role = $conn->prepare($sql_role);
                    $stmt_role->bind_param("i", $new_user_id);
                }

                if ($stmt_role->execute()) {
                    header("Location: profile.php"); // Redirect to profile on success
                    exit();
                } else {
                    $signup_error_message = "<div class='alert alert-danger mt-3'>Error creating user role. Please contact support.</div>";
                }
                $stmt_role->close();

            } else {
                // Check for duplicate email
                if ($conn->errno == 1062) {
                    $signup_error_message = "<div class='alert alert-danger mt-3'>An account with this email already exists. Please <a href='./login.php'>login</a>.</div>";
                } else {
                    $signup_error_message = "<div class='alert alert-danger mt-3'>Sorry, could not create your account. Please try again.</div>";
                }
            }
            $stmt->close();
        }
    }
    CloseCon($conn); // Close connection at the end of the script
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Mental Health Webapp</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" xintegrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Custom Responsive CSS -->
    <style>
        body, html {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: #2f4e4a; /* Your signup background color */
        }

        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1rem; /* Add more padding for longer form */
        }

        .signup-card {
            background-color: white;
            padding: 2.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            color: #333;
            width: 100%;
        }

        .form-control {
            border-radius: 8px;
            padding: 1.25rem 1rem;
            height: auto; /* Allow height to adjust */
        }

        .btn-custom-signup {
            background-color: #2f4e4a;
            border-color: #2f4e4a;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-custom-signup:hover {
            background-color: #253e3a;
            color: white;
        }

        .login-link-container {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        
        /* Style for the counsellor-specific section */
        #counsellor-fields {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Responsive grid column -->
        <div class="col-11 col-sm-10 col-md-8 col-lg-7 col-xl-6">
            <div class="signup-card">
                <h1 class="text-center h3 mb-3">Create Your Account</h1>
                <p class="text-center text-muted mb-4">Thanks for joining us! Please fill out the information below.</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    
                    <div class="form-group">
                        <label for="type">I am a:</label>
                        <select class="form-control" name="type" id="type" required> 
                            <option value="HelpSeeker">Help-seeker</option>
                            <option value="Counsellor">Counsellor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" name="age" id="age" min="13" max="120">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number (Optional):</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., 1234567890" pattern="[0-9]{10}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location (e.g., City, Country):</label>
                        <input name="location" class="form-control" id="location"> 
                    </div>

                    <!-- Counsellor-only fields, initially hidden -->
                    <div id="counsellor-fields" style="display: none;">
                        <h5 class="mb-3">Counsellor Information</h5>
                        <div class="form-group">
                            <label for="yearsExp">Years of experience as a mental health professional:</label>
                            <select name="yearsExp" class="form-control" id="yearsExp">
                                <option value="5">Less than 5 years</option>
                                <option value="10">5-10 years</option>
                                <option value="15">10-15 years</option>
                                <option value="20">15+ years</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label for="cert">Current status as a counsellor:</label>
                            <select name="cert" class="form-control" id="cert">
                                <option value="certified">Certified</option>
                                <option value="in progress">In Progress</option>
                            </select>
                        </div>
                    </div>

                    <!-- Display Signup Error Message -->
                    <?php echo $signup_error_message; ?>

                    <button class="btn btn-custom-signup btn-block mt-4" type="submit">Sign Up</button>
                </form>

                <div class="login-link-container mt-4">
                    Already have an account? <a href="./login.php">Login here</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" xintegrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
    <!-- Script to show/hide counsellor fields -->
    <script>
        document.getElementById('type').addEventListener('change', function () {
            var counsellorFields = document.getElementById('counsellor-fields');
            if (this.value === 'Counsellor') {
                counsellorFields.style.display = 'block';
            } else {
                counsellorFields.style.display = 'none';
            }
        });
    </script>
</body>
</html>
