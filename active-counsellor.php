<?php
include 'connect.php';
$conn = OpenCon();

// Find the counsellor that has booked an appointment with all help seekers
function showActiveCounsellor() {
    global $conn;

    // MySQL-friendly query
    $sql = "SELECT U.name
            FROM Users U
            JOIN Counsellor C ON U.userID = C.userID
            WHERE NOT EXISTS (
                SELECT H.userID
                FROM HelpSeeker H
                WHERE NOT EXISTS (
                    SELECT *
                    FROM Appointment A
                    WHERE A.counsellorID = C.userID
                      AND A.helpSeekerID = H.userID
                )
            )";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0) {
        $names = [];
        while($row = $result->fetch_assoc()) {
            $names[] = $row["name"];
        }
        echo implode(", ", $names);
    } else {
        echo "No counsellor has booked appointments with all help seekers yet.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Most Active Counsellor</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/main.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">MindWell</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/MindWell/profile.php">Profile</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Appointments
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/view-appointments.php">View Appointments</a>
                        <a class="dropdown-item" href="/MindWell/book-appointments.php">Book an Appointment</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Reviews
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/view-reviews.php">View Reviews</a>
                        <a class="dropdown-item" href="/MindWell/write-reviews.php">Write a Review</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Directories
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/user-directory.php">Users</a>
                        <a class="dropdown-item" href="/MindWell/hotline-directory.php">Hotlines</a>
                        <a class="dropdown-item" href="/MindWell/resource-centre-directory.php">Resource Centers</a>
                        <a class="dropdown-item" href="/MindWell/types-of-help-directory.php">Types of Help</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Leaderboard
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/top-counsellor.php">Top Counsellor</a>
                        <a class="dropdown-item active" href="/MindWell/active-counsellor.php">Most Active Counsellor</a>
                        <a class="dropdown-item" href="/MindWell/active-helpseeker.php">Most Active Help Seeker</a>
                    </div>
                </li>

                <li class="nav-item"><a class="nav-link" href="/MindWell/lookup.php">Look Up</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="container my-5 flex-grow-1">
        <h1 class="text-center mb-4">Most Active Counsellor</h1>

        <div class="alert alert-info text-center" role="alert">
            <b>Most Active Counsellor</b> (booked appointments with all help seekers): <b><?php showActiveCounsellor(); ?></b>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
<?php CloseCon($conn); ?>
</html>
