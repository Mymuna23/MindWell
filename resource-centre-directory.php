<?php
    
    include 'connect.php';
    session_start();
    $conn = OpenCon();

    // get and display all resource centre information
    function showResourceCentres() {

        global $conn;   
        $sql = "SELECT * FROM ResourceCentre";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) { 
            echo "<tr>
                      <td>".$row["centreID"]."</td>
                      <td>".$row["centreName"]."</td>
                      <td>".$row["address"]."</td>
                      <td>".$row["email"]."</td>
                      <td>".$row["postalCode"]."</td>
                      <td>".$row["phoneNum"]."</td>
                  </tr>";
        }
    }
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MindWell - Resource Centre Directory</title>
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
                            <a class="dropdown-item active" href="/MindWell/resource-centre-directory.php">Resource Centers</a>
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

        <div class = "container">
            <h1 class = "text-center mt-5 mb-5"> Resource Centre Directory </h1>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th>Centre ID</th>
                        <th>Centre Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Postal Code</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php showResourceCentres()?>
                </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
