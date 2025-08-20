<?php
include 'connect.php';
$conn = OpenCon();

// Find the helpseeker that has booked an appointment with all counsellors
function showActiveHelpSeeker() {
    global $conn;
    $sql = "SELECT name
            FROM Users U, Helpseeker H
            WHERE U.userID = H.userID AND
                NOT EXISTS (
                    (SELECT C.userID
                     FROM Counsellor C)
                    EXCEPT
                    (SELECT C.userID
                     FROM Counsellor C, Appointment A 
                     WHERE C.userID = A.counsellorID AND
                           H.userID = A.helpSeekerID)
                )";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        echo htmlspecialchars($row["name"]);
    } else {
        echo "No helpseeker has booked with all counsellors yet.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindWell - Most Active Help Seeker</title>
    
    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">MindWell</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/MindWell/profile.php">Profile</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown">Appointments</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/view-appointments.php">View Appointments</a>
                        <a class="dropdown-item" href="/MindWell/book-appointments.php">Book an Appointment</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown">Reviews</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/view-reviews.php">View Reviews</a>
                        <a class="dropdown-item" href="/MindWell/write-reviews.php">Write a Review</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown">Directories</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/user-directory.php">Users</a>
                        <a class="dropdown-item" href="/MindWell/hotline-directory.php">Hotlines</a>
                        <a class="dropdown-item" href="/MindWell/resource-centre-directory.php">Resource Centers</a>
                        <a class="dropdown-item" href="/MindWell/types-of-help-directory.php">Types of Help</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown">Leaderboard</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/top-counsellor.php">Top Counsellor</a>
                        <a class="dropdown-item" href="/MindWell/active-counsellor.php">Most Active Counsellor</a>
                        <a class="dropdown-item active" href="/MindWell/active-helpseeker.php">Most Active Help Seeker</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="/MindWell/lookup.php">Look Up</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page content -->
    <main class="container my-5 flex-grow-1">
        <h1 class="text-center mb-4">Most Active Help Seeker</h1>

        <div class="alert alert-info text-center" role="alert">
            <b>Most Active HelpSeeker</b> (booked an appointment with all counsellors): 
            <b><?php showActiveHelpSeeker(); ?></b>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php CloseCon($conn); ?>
</html>
