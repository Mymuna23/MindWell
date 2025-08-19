<?php
    include 'connect.php';
    session_start();
    $conn = OpenCon();

    // Display all counsellors
    function showCounsellors() {
        global $conn;  
        $sql = "SELECT * FROM Counsellor";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $sql = "SELECT name FROM Users WHERE userID=".$row["userID"];
            $name = $conn->query($sql)->fetch_assoc()['name'];
            echo "<option value=".$row["userID"].">$name</option>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="styles/main.css">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <style>
        .booking-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 700px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0c9bbe; /* Consistent accent color */
        }
        label {
            color: #000000dd;
            font-weight: 500;
        }
        .form-control,
        input[type="date"],
        input[type="time"] {
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(0,0,0,0.2);
            border-radius: 10px;
            padding: 0.6rem;
            color: #000;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        .form-control:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            background: rgba(255,255,255,0.3);
            box-shadow: 0 0 0 2px rgba(12,155,190,0.3);
            border-color: #0c9bbe;
        }
        .btn-success {
            background: linear-gradient(135deg, #65b4a3, #20c997);
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        @media (max-width: 768px){
            .btn-success { width: 100%; margin-top: 1rem; }
        }
    </style>
</head>
<body>
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
                    <a class="nav-link dropdown-toggle active" role="button" data-toggle="dropdown">Appointments</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item active" href="/MindWell/book-appointments.php">Book an Appointment</a>
                        <a class="dropdown-item" href="/MindWell/view-appointments.php">View Appointments</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">Reviews</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/view-reviews.php">View Reviews</a>
                        <a class="dropdown-item" href="/MindWell/write-reviews.php">Write a Review</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">Directories</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/user-directory.php">Users</a>
                        <a class="dropdown-item" href="/MindWell/hotline-directory.php">Hotlines</a>
                        <a class="dropdown-item" href="/MindWell/resource-centre-directory.php">Resource Centers</a>
                        <a class="dropdown-item" href="/MindWell/types-of-help-directory.php">Types of Help</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">Leaderboard</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/MindWell/top-counsellor.php">Top Counsellor</a>
                        <a class="dropdown-item" href="/MindWell/active-counsellor.php">Most Active Counsellor</a>
                        <a class="dropdown-item" href="/MindWell/active-helpseeker.php">Most Active Help Seeker</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="/MindWell/lookup.php">Look Up</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mt-5 mb-4">Book Appointment</h1>
        <div class="booking-container">
            <form action="./add-appointments.php" method="post">
                <div class="form-group">
                    <label for="userID">Select Counsellor</label>
                    <select class="form-control" name="userID" id="userID">
                        <?php showCounsellors() ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="platform">What platform?</label>
                    <input class="form-control" name="platform" id="platform" placeholder="e.g., Zoom, Teams, In-person" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="date">Choose a date</label>
                        <input class="form-control" type="date" name="date" id="date" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="startTime">Start Time</label>
                        <input class="form-control" type="time" name="startTime" id="startTime" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="endTime">End Time</label>
                        <input class="form-control" type="time" name="endTime" id="endTime" required>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Book Appointment</button>
            </form>
        </div>
    </div>
</body>
</html>
