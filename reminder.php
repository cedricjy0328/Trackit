<?php
include 'includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <title>Reminder</title>
	
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
			<li>
				<a href="dashboard.php">Project</a>
			</li>
			<li class="active">
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
						<p class="reminder-title">Reminder</p>
						<table class="table">
						<?php
							$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

							$sql = "SELECT Description, Rem_Date, Rem_Time from Reminder where User_ID = '$user_id'
									ORDER BY Rem_Date, Rem_Time";
							$result = mysqli_query($connection, $sql);

							if (mysqli_num_rows($result) > 0) {
								// output data of each row
								echo '<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Description</th>
											<th scope="col">Date</th>
											<th scope="col">Time</th>
										</tr>
									</thead>
									<tbody>';

								$n = 1;
								while($row = mysqli_fetch_assoc($result)) {
									$desc = $row['Description'];
									$date = $row['Rem_Date'];
									$time = $row['Rem_Time'];
									
									echo '<tr>
								  			<th scope="row">'.$n.'</th>
								  			<td>'.$desc.'</td>
								  			<td>'.$date.'</td>
								  			<td>'.$time.'</td>
										</tr>';
								}
								echo '</tbody>';
							}
							else{
								echo '<p class="reminder-desc">No upcoming reminder(s)</p>';
							}

							mysqli_close($connection);
						?>						  
						</table>
						<a class="reminder-footer" href="reminder-adding.php">+ Add a reminder</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

	<div class="overlay"></div>

</body>
</html>