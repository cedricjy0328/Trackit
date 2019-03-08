<?php 

include 'includes/session.php';

$alertMessage = "";
$successMessage = "";

if(isset($_POST['desc']) && isset($_POST['due_date']) && isset($_POST['due_time'])){
	if(!empty($_POST['desc']) && !empty($_POST['due_date']) && !empty($_POST['due_time'])){
		
		$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
		//mysqli_connect_errno() function returns the error code from the last connection error, if any.
		//mysqli_connect_error() function returns the error description from the last connection error, if any.
		if(mysqli_connect_errno()){
			die(mysqli_connect_error());
		}
		
		$sql = "INSERT INTO Reminder (Description, Rem_Date, Rem_Time, User_ID) VALUES (?,?,?,?)";
		if($statement = mysqli_prepare($connection, $sql)){
			mysqli_stmt_bind_param($statement, 'sssi', $_POST['desc'], $_POST['due_date'], $_POST['due_time'], $user_id);
			
			mysqli_stmt_execute($statement);
			$successMessage = "A reminder added successfully.";
		}
		$alertMessage = "";
		
		mysqli_close($connection);
	}
	else{
		$alertMessage = "Please complete the details before submitting!";
		$successMessage = "";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <title>Add a reminder</title>
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">
	
    <!-- Custom CSS -->
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/Homepage2.css"/>
    <link rel="stylesheet" href="css/sidebar-menu.css">
	<link rel="stylesheet" href="css/reminder.css" />
	
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
	
	<!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="js/sidebar-menu.js"></script>
	<script src="js/reminder-adding.js"></script>
</head>
<body>
	
<div class="wrapper">

	<!-- Side Menu -->
	<nav id="sidebar">
		<div id="dismiss">
			<i class="fas fa-arrow-left"></i>
		</div>
		
		<div class="sidebar-header">
			<h3>Trackit</h3>
		</div>
			
		<ul class="list-unstyled components">
			<li class="active">
				<a href="dashboard.php">Project</a>
			</li>
			<li>
				<a href="reminder.php">Reminders</a>
			</li>
			<li>
				<a href="settings.php">Settings</a>
			</li>
		</ul>
	</nav>

	<div id="content">
		<nav class="navbar bg-dark navbar-dark">
			
			<button type="button" id="sidebarCollapse" class="navbar-toggler">
				<span class="navbar-toggler-icon"></span> 
			</button>
			
			<ul class="nav justify-content-center">
				<!-- Dropdown -->
				<li class="nav-item dropdown">
					<a class="nav-item" href="#" id="navbardrop" data-toggle="dropdown"><img src="images/profilePic.png" alt="user-profile" width="35" /></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="settings.php">Settings</a>
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
			</ul>
		</nav>
			
		<div class="container" style="margin-top: 50px;">
			<div class="row">
				<!-- Reminder Lists -->
				<div class="col-md-8">
					<div class="reminder">
						<p class="reminder-title">Reminder Details</p>
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="reminderform" >
							<div class="form-group">
								<label for="reminder-description">Reminder Description: </label>
								<textarea class="form-control" rows="4" id="reminder-description" name="desc"></textarea>
								<p id="descEmpty" class="valid">**Please enter the description.**</p>
							</div>
							<div class="form-group row">
							  <label for="due-date" class="col-2 col-form-label">Date</label>
							  <div class="col-10">
								<input class="form-control" type="date" id="due-date" name="due_date">
							  </div>
							  <p id="dateEmpty" class="valid">**Please enter the date.**</p>
							</div>
							<div class="form-group row">
							  <label for="due-time" class="col-2 col-form-label">Time</label>
							  <div class="col-10">
								<input class="form-control" type="time" id="due-time" name="due_time">
							  </div>
							  <p id="timeEmpty" class="valid">**Please enter the time.**</p>
							</div>
							<div id="successMessage">
								<?php echo $successMessage; ?>
							</div>
							<div id="alertMessage">
								<?php echo $alertMessage ?>
							</div>

							<span style="float:right;"><button type="submit" class="btn btn-primary ">Submit</button></span>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<div class="overlay"></div>

</body>
</html>