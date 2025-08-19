<?php
	
	include 'connect.php';
	$conn = OpenCon();
	session_start();

	// Check if the helpseeker form is submitted
	if(isset($_POST['HelpSeekerSubmit'])){ 
		processHelpSeekerUpdate();
	} 

	// Check if the counsellor form is submitted
	if(isset($_POST['CounsellorSubmit'])){ 
		processCounsellorUpdate();
	} 

	// Display the helpSeeker update form
	function showHelpSeekerForm() {

		global $conn; 
		$sql = "SELECT * FROM Users WHERE userID =". $_SESSION['userID'];
		$result = $conn->query($sql);

		$row = $result->fetch_assoc();

		echo "<form action = '' method='POST'>
				  <div class='form-row'>
				    <div class='col'>
				    	<label>Email</label>
				    	<input name='email' type='text' class='form-control' placeholder='Email' value = ".$row["email"].">
				    </div>
				    <div class='col'>
				    	<label>Password</label>
				    	<input name='password' type='password' class='form-control' placeholder='Password' value =".$row["password"].">
				    </div>
				  </div>
				  <div class='form-row mt-5'>
				    <div class='col'>
				    	<label>Name</label>
				    	<input name='name' type='text' class='form-control' placeholder='Name' value = ".$row["name"].">
				    </div>
				    <div class='col'>
				    	<label>Age</label>
				    	<input name='age' type='number' class='form-control' placeholder='Age' value =".$row["age"].">
				    </div>
				    <div class='col'>
				    	<label>Phone Number</label>
				    	<input name='phone' type='text' class='form-control' placeholder='Phone Number' value =".$row["phone"].">
				    </div>
				  </div>
				  <div class = 'form-row mt-5 float-right'>
				  	<button name='HelpSeekerSubmit' type='submit' class='btn btn-success mr-2'>Save Changes</button>
				  	<a href='/MindWell/profile.php' class='btn btn-success'>Go Back</a>
				  </div>
			  </form>";
	}

	// Process the help seeker update
	function processHelpSeekerUpdate() {

		global $conn;

		$email = $_POST['email'];
		$password = $_POST['password'];
	  	$name = $_POST['name'];
	  	$age = $_POST['age'];
	  	$phone = $_POST['phone'];

	  	$sql = "UPDATE Users 
	  			SET email = '$email',
	  				password = '$password',
	  				name = '$name',
	  				age = '$age',
	  				phone = '$phone'
	  			WHERE userID =".$_SESSION["userID"];

	  	$conn->query($sql);
	}

	// Display the counsellors update form
	function showCounsellorForm() {

		global $conn; 
		$sql = "SELECT * 
				FROM Users U, Counsellor C 
				WHERE U.userID = C.userID AND 
				U.userID =". $_SESSION['userID'];
		$result = $conn->query($sql);

		$row = $result->fetch_assoc();

		echo "<form action = '' method='POST'>
				  <div class='form-row'>
				    <div class='col'>
				    	<label>Email</label>
				    	<input name='email' type='text' class='form-control' placeholder='Email' value = ".$row["email"].">
				    </div>
				    <div class='col'>
				    	<label>Password</label>
				    	<input name='password' type='password' class='form-control' placeholder='Password' value =".$row["password"].">
				    </div>
				  </div>
				  <div class='form-row mt-5'>
				    <div class='col'>
				    	<label>Name</label>
				    	<input name='name' type='text' class='form-control' placeholder='Name' value = ".$row["name"].">
				    </div>
				    <div class='col'>
				    	<label>Age</label>
				    	<input name='age' type='number' class='form-control' placeholder='Age' value =".$row["age"].">
				    </div>
				    <div class='col'>
				    	<label>Phone Number</label>
				    	<input name='phone' type='text' class='form-control' placeholder='Phone Number' value =".$row["phone"].">
				    </div>
				  </div>
				  <div class='form-row mt-5'>
				    <div class='col'>
				    	<label>Years of Experience</label>
				    	<input name='experience' type='number' class='form-control' placeholder='Email' value = ".$row["yearsExperience"].">
				    </div>
				    <div class='col'>
				    	<label>Certification</label>
				    	<input name='certification' type='text' class='form-control' placeholder='Password' value =".$row["certification"].">
				    </div>
				  </div>
				  <div class = 'form-row mt-5 float-right'>
				  	<button name='CounsellorSubmit' type='submit' class='btn btn-success mr-2'>Save Changes</button>
				  	<a href='/MindWell/profile.php' class='btn btn-success'>Go Back</a>
				  </div>
			  </form>";
	}

	// Process the counsellor update
	function processCounsellorUpdate() {

		global $conn;

		$email = $_POST['email'];
		$password = $_POST['password'];
	  	$name = $_POST['name'];
	  	$age = $_POST['age'];
	  	$phone = $_POST['phone'];
	  	$experience = $_POST['experience'];
	  	$certification = $_POST['certification'];

	  	$sql = "UPDATE Users 
	  			SET email = '$email',
	  				password = '$password',
	  				name = '$name',
	  				age = '$age',
	  				phone = '$phone'
	  			WHERE userID =".$_SESSION["userID"];

	  	$conn->query($sql);

	  	$sql = "UPDATE Counsellor
	  			SET yearsExperience = '$experience',
	  				certification = '$certification'
	  			WHERE userID =".$_SESSION["userID"];
	  	
	  	$conn->query($sql);
	}

?>

<!DOCTYPE html>
<html>
	
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
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
				color: white;
				padding: 0;
				margin: 0;
				overflow-x: hidden;
			}

			/* Navbar Styles */
			.navbar {
				background-color: rgba(0, 0, 0, 0.2) !important;
				backdrop-filter: blur(10px);
				border-bottom: 1px solid rgba(255, 255, 255, 0.1);
				padding: clamp(0.5rem, 2vw, 1rem);
			}

			/* Form Container Styles */
			.edit-profile-container {
				background: rgba(255, 255, 255, 0.1);
				backdrop-filter: blur(10px);
				border-radius: 20px;
				padding: clamp(1.5rem, 4vw, 3rem);
				margin: clamp(2rem, 5vh, 4rem) auto;
				box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
				max-width: 1000px;
			}

			/* Form Styles */
			.form-control {
				background: rgba(255, 255, 255, 0.1);
				border: 1px solid rgba(255, 255, 255, 0.2);
				color: white;
				border-radius: 10px;
				padding: 0.75rem 1rem;
				font-size: clamp(14px, 2.5vw, 16px);
				transition: all 0.3s ease;
			}

			.form-control:focus {
				background: rgba(255, 255, 255, 0.15);
				border-color: rgba(255, 255, 255, 0.4);
				color: white;
				box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.15);
			}

			.form-control::placeholder {
				color: rgba(255, 255, 255, 0.6);
			}

			label {
				color: rgba(255, 255, 255, 0.9);
				font-size: clamp(14px, 2.5vw, 16px);
				margin-bottom: 0.5rem;
			}

			/* Button Styles */
			.btn {
				padding: 0.75rem 2rem;
				border-radius: 25px;
				font-weight: 600;
				transition: all 0.3s ease;
				min-height: 44px;
				font-size: clamp(14px, 2.5vw, 16px);
			}

			.btn-success {
				background: #1a936f;
				border: none;
			}

			.btn-success:hover {
				background: #147957;
				transform: translateY(-2px);
				box-shadow: 0 5px 15px rgba(26, 147, 111, 0.3);
			}

			/* Typography */
			.page-title {
				font-size: clamp(2rem, 5vw, 2.5rem);
				font-weight: 700;
				margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
				text-align: center;
				text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
				background: linear-gradient(45deg, #ffffff, #e0e0e0);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
				background-clip: text;
			}

			/* Responsive Form Layout */
			@media (max-width: 768px) {
				.form-row {
					flex-direction: column;
				}
				.form-row > .col {
					margin-bottom: 1rem;
				}
				.form-row > .col:last-child {
					margin-bottom: 0;
				}
				.btn {
					width: 100%;
					margin: 0.5rem 0;
				}
			}

			/* Small Screen Optimizations */
			@media (max-width: 576px) {
				.edit-profile-container {
					margin: 1rem;
					padding: 1.5rem;
				}
				.form-control {
					padding: 0.6rem 0.8rem;
				}
				.page-title {
					margin-bottom: 1.5rem;
				}
			}

			/* Dark Mode Support */
			@media (prefers-color-scheme: dark) {
				.form-control {
					background: rgba(0, 0, 0, 0.2);
				}
				.form-control:focus {
					background: rgba(0, 0, 0, 0.3);
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

			      	<li class="nav-item">
			        	<a class="nav-link" href="/MindWell/lookup.php">Look Up</a>
			      	</li>
			      	
			    </ul>
	  		</div>
		</nav>
		
		<!-- Page content -->
		<div class = "container">
			<h1 class = "text-center mt-5 mb-5"> Update Profile </h1>
			<?php 
				if($_SESSION["userType"] == "helpSeeker") {
					showHelpSeekerForm();
				} else {
					showCounsellorForm();
				}
			 ?>
		</div>

	</body>
	<?php CloseCon($conn) ?>
</html>