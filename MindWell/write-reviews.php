<?php
    
    include 'connect.php';
    $conn = OpenCon();
    session_start();

    // Check if the review is submitted
    if(isset($_POST['ReviewSubmit'])){ 
        displayContents();
    } 

    function displayContents() {
        if (processReview()) {
            echo '<div class="alert alert-success" role="alert">
                Review posted. Thanks for your review! </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                Unable to post your review. Please try again.
            </div>';
        }
    }

    // Process the review update
    function processReview() {
        global $conn;
        $reviewAuthor = $_SESSION["userID"];
        $counsellor = $_POST["counsellor"];
        $rating = $_POST["rating"];
        $feedback = $_POST["feedback"];
        
        // Using prepared statements would be better for security here
        $sql = "insert into Review (reviewAuthor, counsellor, rating, feedback) values "; 
        $sql .= "($reviewAuthor, $counsellor, $rating, '$feedback');";
        $result = $conn->query($sql);
        return $result;
    }

    function showReviewForm() {
        echo "
            <form action='' method='post' class='mt-5'>

                <div class='form-group col-md-5'>
                    <label for='counsellor' id='counsellor'>Your counsellor's ID: </label>
                    <input class='form-control' type='number' name='counsellor' required></input>
                </div>

                <div class='form-group col-md-3'>
                    <label for='rating' id='rating'>Please rate (1-5): </label>
                    <input class='form-control' type='number' name='rating' min='1' max='5' required></input>
                </div>

                <div class='form-group'>
                    <label for='feedback' id='feedback'>Please give us your feedback: </label>
                    <textarea class='form-control' name='feedback' rows='3' required></textarea>
                </div>

                <button name='ReviewSubmit' class='btn btn-success' type='submit' value='submit'>Submit Review </button>
            </form>
        ";
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
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                            <a class="dropdown-item active" href="#">Write a Review</a>
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
            <h1 class = "text-center mt-5 mb-5"> Write A Review </h1>

            <?php 
                if($_SESSION["userType"] == "helpSeeker") {
                    showReviewForm();
                } else {
                    echo "Sorry this feature is only avaliable to help seekers.";
                }
            ?>

        </div>
    </body>
</html>
