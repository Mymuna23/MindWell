<?php
    
    include 'connect.php';
    $conn = OpenCon();
    
    // Returns basic information of a user
    function showInfo() {
        
        global $conn;   

        $searchID = $_POST['searchUserID'];

        $sql = "SELECT name, age, location, email, phone FROM Users WHERE userID =".$searchID;
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();

        if(mysqli_num_rows($result)==0) {

            echo "<div style='color: #ff6b6b; font-weight: 600; font-size: 1.1rem;'>User not found! Please enter a different ID</div>";

        } else {
            echo "<div class='text-left'>
                    <p><strong>Name: </strong><span class='ml-2'>".$row["name"]."</span></p>
                    <p><strong>Age: </strong><span class='ml-2'>".$row["age"]."</span></p>
                    <p><strong>Location: </strong><span class='ml-2'>".$row["location"]."</span></p>
                    <p><strong>Email: </strong><span class='ml-2'>".$row["email"]."</span></p>
                    <p><strong>Phone: </strong><span class='ml-2'>".$row["phone"]."</span></p>
                  </div>";
        }
    }
?>

<!DOCTYPE html>
<html>
    
    <head>
        <!-- Bootstrap Stylesheet -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" xintegrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Custom Stylesheet -->
        <link rel="stylesheet" href="styles/main.css">

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" xintegrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

        <style>
            body {
                background-color: white;
                min-height: 100vh;
                color: #333;
            }
            .navbar {
                background-color: #1d2935ff !important;
            }
            .search-container {
                background: rgba(0, 0, 0, 0.05);
                backdrop-filter: blur(5px);
                border-radius: 15px;
                padding: 2.5rem;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                max-width: 800px;
                margin: 2rem auto;
            }
            .form-control {
                border-radius: 25px;
                padding: 12px 20px;
                border: 2px solid rgba(0, 0, 0, 0.1);
                background: rgba(0, 0, 0, 0.05);
                color: #333;
                transition: all 0.3s;
            }
            .form-control::placeholder {
                color: rgba(0, 0, 0, 0.5);
            }
            .form-control:focus {
                background: rgba(0, 0, 0, 0.1);
                border-color: rgba(0, 0, 0, 0.2);
                box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.15);
                color: #333;
            }
            .btn-search {
                background: #1a936f;
                border: none;
                padding: 12px 30px;
                border-radius: 25px;
                color: white;
                font-weight: 600;
                transition: all 0.3s;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            .btn-search:hover {
                background: #147957;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(26, 147, 111, 0.3);
                color: white;
            }
            .user-info {
                background: rgba(0, 0, 0, 0.05);
                backdrop-filter: blur(5px);
                border-radius: 15px;
                padding: 2rem;
                margin-top: 2rem;
            }
            .user-info p {
                font-size: 1.1rem;
                margin-bottom: 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                padding-bottom: 0.5rem;
            }
            .page-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }
            .page-description {
                font-size: 1.2rem;
                opacity: 0.9;
                margin-bottom: 2rem;
            }
            .navbar-toggler {
                border-color: rgba(255, 255, 255, 0.5);
            }
            .navbar-toggler:focus {
                box-shadow: none;
                outline: none;
            }
            @media (max-width: 991.98px) {
                .navbar-collapse {
                    background: #114b5f;
                    padding: 1rem;
                    border-radius: 10px;
                    margin-top: 1rem;
                }
                .dropdown-menu {
                    background: #0d3846;
                    border: 1px solid #114b5f;
                }
                .dropdown-item {
                    color: white;
                }
                .dropdown-item:hover {
                    background: #0d3846;
                    color: white;
                }
            }
        </style>
    </head>

    <body>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">MindWell</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="/MindWell/profile.php">Profile</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Appointments
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/MindWell/view-appointments.php">View Appointments</a>
                            <a class="dropdown-item" href="/MindWell/book-appointments.php">Book an Appointment</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reviews
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/MindWell/view-reviews.php">View Reviews</a>
                            <a class="dropdown-item" href="/MindWell/write-reviews.php">Write a Review</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Directories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/MindWell/user-directory.php">Users</a>
                            <a class="dropdown-item" href="/MindWell/hotline-directory.php">Hotlines</a>
                            <a class="dropdown-item" href="/MindWell/resource-centre-directory.php">Resource Centers</a>
                            <a class="dropdown-item" href="/MindWell/types-of-help-directory.php">Types of Help</a>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Leaderboard
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/MindWell/top-counsellor.php">Top Counsellor</a>
                            <a class="dropdown-item" href="/MindWell/active-counsellor.php">Most Active Counsellor</a>
                            <a class="dropdown-item" href="/MindWell/active-helpseeker.php">Most Active Help Seeker</a>
                        </div>
                    </li>

                    <li class="nav-item active">
                        <a class="nav-link" href="#">Look Up</a>
                    </li>
                    
                </ul>
            </div>
        </nav>
        
        <!-- Page content -->
        <div class="container">
            <div class="search-container text-center">
                <h1 class="page-title">Find A User</h1>
                <p class="page-description">Search for a user's basic information through their user ID</p>
                
                <form action='' method='POST' class="form-inline justify-content-center">
                    <div class="input-group">
                        <input name='searchUserID' type='text' class='form-control' placeholder='Enter User ID' required/>
                        <div class="input-group-append ml-3">
                            <button name='SearchSubmit' type='submit' class='btn btn-search'>Search User</button>
                        </div>
                    </div>
                </form>

                <div class="user-info">
                    <?php
                        // Check if the search form is submitted
                        if(isset($_POST['SearchSubmit'])){ 
                            showInfo();
                        } 
                    ?>
                </div>
            </div>
        </div>
    </body>
    <?php CloseCon($conn) ?>
</html>
