<?php
    
    // Include the database connection script.
    include 'connect.php';

    // Open a database connection.
    $conn = OpenCon();

    // Start the session to get the user's ID and type.
    session_start();

    // Check if the user is logged in. If not, redirect to the login page.
    if (!isset($_SESSION['userID'])) {
        header("Location: /MindWell/login.php");
        exit();
    }
    
    // Check if the logout button is clicked.
    if(isset($_POST['logoutSubmit'])){ 
        logout();
    } 

    /**
     * Determines if the current user is a counsellor or help seeker and stores it in the session.
     */
    function setUserType() {
        global $conn;

        // Use a prepared statement to prevent SQL injection.
        $sql = "SELECT COUNT(1) FROM helpSeeker WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['userID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $num = $row["COUNT(1)"];

        if($num == 1) {
            $_SESSION["userType"] = "helpSeeker";
        } else {
            $_SESSION["userType"] = "counsellor";
        }
        $stmt->close();
    }
    
    /**
     * Displays basic information of the user.
     */
    function showBasicInfo() {
        global $conn;
        $sql = "SELECT name, age, location, email, phone FROM Users WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['userID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "<p><b>Name: </b>".$row["name"]."</p>
              <p><b>Age: </b>".$row["age"]."</p>
              <p><b>Location: </b>".$row["location"]."</p>
              <p><b>Email: </b>".$row["email"]."</p
              <p><b>Phone: </b>".$row['phone']."</p>";
        $stmt->close();
    }

    /**
     * Displays the correct profile picture based on the user's type.
     */
    function showProfilePicture() {
        if($_SESSION["userType"] == "helpSeeker") {
            echo "<img src='../MindWell/assets/helpseeker-pfp.png' class='img-fluid img-max'>";
        } else {
            echo "<img src='../MindWell/assets/counsellor-pfp.png' class='img-fluid img-max'>";
        }
    }

    /**
     * Displays counsellor-specific details if the user is a counsellor.
     */
    function showCounsellorDetails() {
        global $conn;

        // Fetch yearsOfExperience and certification using a prepared statement.
        $sql = "SELECT yearsExperience, certification FROM counsellor WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['userID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        echo "<p><b>Years of Experience: </b>".$row["yearsExperience"]."</p>
              <p><b>Certification: </b>".$row["certification"]."</p>";
        
        // Fetch the average rating for a counsellor.
        $sql = "SELECT AVG(R.rating) AS AvgRating
                FROM review R
                WHERE R.counsellor = ?
                GROUP BY R.counsellor";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION["userID"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<p><b>Average Rating: </b> No Ratings Yet </p>";
        } else {
            $row = $result->fetch_assoc();
            echo "<p><b>Average Rating: </b>".number_format($row["AvgRating"], 2)."</p>";
        }
        $stmt->close();

        // Fetch the number of patients based on the number of unique helpSeekers.
        $sql = "SELECT COUNT(DISTINCT A.helpSeekerID) AS numOfPatients
                FROM Appointment A
                WHERE A.counsellorID = ?
                GROUP BY A.counsellorID";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION["userID"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<p><b>Number of Patients: </b>0</p>";
        } else {
            $row = $result->fetch_assoc();
            echo "<p><b>Number of Patients: </b>".$row["numOfPatients"]."</p>";
        }
        $stmt->close();

        // Fetch the counsellor's level based on their yearsOfExperience.
        $sql = "SELECT level
                FROM Counsellor C, Counselloryearsexperience CY
                WHERE C.yearsExperience = CY.yearsExperience AND C.userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION["userID"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        echo "<p><b>Level: </b>".$row["level"]."</p>";
        $stmt->close();
    }

    /**
     * Displays the hotlines related to the user.
     */
    function showHotlines() {
        global $conn;
        $sql = "";
        $stmt = null;

        if($_SESSION["userType"] == "helpSeeker") {
            echo "<p><b> Favourite Hotlines </b></p>";
            $sql = "SELECT HL.name, HL.phoneNum, HL.typeOfHelp
                    FROM Hotline HL, FavouriteHotline FH
                    WHERE HL.phoneNum = FH.hotlineNum AND
                          FH.helpSeekerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION["userID"]);
        } else {
            echo "<p><b> Recommended Hotlines </b></p>";
            $sql = "SELECT HL.name, HL.phoneNum, HL.typeOfHelp
                    FROM Hotline HL, RecommendedHotline RH
                    WHERE HL.phoneNum = RH.hotlineNum AND
                          RH.counsellorID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION["userID"]);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0) {
            echo "You have no saved hotlines!";
        } else {
            echo "<table class='table mb-5 mr-3'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone #</th>
                        <th>Type of Help</th>
                    </tr>
                </thead>
                <tbody>";
            while($row = $result->fetch_assoc()) { 
                echo "<tr>
                        <td>".$row["name"]."</td>
                        <td>".$row["phoneNum"]."</td>
                        <td>".$row["typeOfHelp"]."</td>
                      </tr>";
            }
            echo "</tbody></table>";
        }
        $stmt->close();
    }

    /**
     * Displays the resource centres related to the user.
     */
    function showCentres() {
        global $conn;
        $sql = "";
        $stmt = null;

        if($_SESSION["userType"] == "helpSeeker") {
            echo "<p><b> Favourite Centres </b></p>";
            $sql = "SELECT RC.centreName, RC.address, RC.email, RC.phoneNum
                    FROM ResourceCentre RC, FavouriteCentre FC
                    WHERE RC.centreID = FC.centreID AND 
                          FC.helpSeekerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION["userID"]);
        } else {
            echo "<p><b> Recommended Centres </b></p>";
            $sql = "SELECT RC.centreName, RC.address, RC.email, RC.phoneNum
                    FROM ResourceCentre RC, RecommendedCentre REC
                    WHERE RC.centreID = REC.centreID AND 
                          REC.counsellorID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_SESSION["userID"]);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0) {
            echo "You have no saved resource centres!";
        } else {
            echo "<table class='table mb-5 mr-3'>
                <thead>
                    <tr>
                        <th>Center Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone #</th>
                    </tr>
                </thead>
                <tbody>";
            while($row = $result->fetch_assoc()) { 
                echo "<tr>
                        <td>".$row["centreName"]."</td>
                        <td>".$row["address"]."</td>
                        <td>".$row["email"]."</td>
                        <td>".$row["phoneNum"]."</td>
                      </tr>";
            }
            echo "</tbody></table>";
        }
        $stmt->close();
    }

    /**
     * Logs a user out by destroying the session and redirecting to the login page.
     */
    function logout() {
        session_destroy();
        header("Location: /MindWell/login.php");
        exit();
    }

    // Set the user's type to be used by the functions below.
    setUserType();
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap Stylesheet -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" xintegrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!-- Custom Stylesheet -->
        <link rel="stylesheet" href="styles/main.css">
        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" xintegrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d2935;">
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
                    <li class="nav-item">
                        <a class="nav-link" href="/MindWell/lookup.php">Look Up</a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <!-- Page content -->
        <div class = "container">
            <h1 class = "text-center mt-5 mb-5"> User Profile </h1>
            <div class = "row">
                <div class ="col-3 mr-3 text-center">
                    <?php showProfilePicture() ?>
                </div>
                <div class ="col">
                    <?php showBasicInfo() ?>
                    <a href="/MindWell/edit-profile.php" class="btn btn-success mr-2">Edit Profile</a>
                    <a href="/MindWell/delete-profile.php" class="btn btn-danger">Delete Account</a>

                    <form action = '' method='POST'>
                        <button name='logoutSubmit' type='submit' class='btn btn-primary mt-2'>Logout</button>
                    </form>
                    
                </div>
                <div class = "col">
                    <?php 
                        if($_SESSION["userType"] == "counsellor") {
                            showCounsellorDetails();
                        }
                    ?>
                </div>
            </div>
            <div class = "row mt-5">
                <div class = "col text-center">
                    <?php showHotlines() ?>
                </div>
                <div class = "col text-center">
                    <?php showCentres() ?>
                </div>
            </div>
        </div>
    </body>
    <?php CloseCon($conn) ?>
</html>
