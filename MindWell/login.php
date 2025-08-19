<!DOCTYPE html> 
<html>
<head>
    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="styles/main.css">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(135deg, #1a936f 0%, #114b5f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 0 auto;
        }
        .login-title {
            color: #114b5f;
            font-weight: bold;
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #1a936f;
            box-shadow: 0 0 0 0.2rem rgba(26, 147, 111, 0.25);
        }
        .btn-submit {
            background: #1a936f;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: #147957;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 147, 111, 0.3);
        }
        .signup-link {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 2rem;
        }
        .signup-link a {
            color: #1a936f;
            font-weight: 600;
            text-decoration: none;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
        .alert-error {
            background-color: #ffe5e5;
            color: #d63031;
            border-radius: 8px;
            padding: 15px;
            margin-top: 1rem;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-radius: 8px;
            padding: 15px;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <h1 class="login-title text-center">Welcome Back</h1>
            
            <form action='./login.php' method='post'>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type='email' class="form-control" id='email' name='email' pattern=".+@.+" required 
                           placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id='password' class="form-control" name='password' type="password" required 
                           placeholder="Enter your password">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-submit" value="submit">Log In</button>
                </div>
            </form>

            <div class="signup-link text-center">
                Don't have an account? <a href="./signup.php">Sign up now</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    include './connect.php';
    session_start(); // will not expire until user closes the browser

    $conn = OpenCon();
    if (isset($_POST['password']) && isset($_POST['email'])) {
        loginSuccess();
    } else if (isset($_SESSION["userID"])) {
        header('Location: profile.php');
        die();
    }

    function loginSuccess() {
        global $conn;
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "select userID from Users where email='$email' and password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['userID'] = $row['userID'];
            header('Location: profile.php');
            die();
        } else {
            echo "<div class='alert-error text-center'>Invalid email or password. Please try again.</div>";
        }
    }
    
?>

