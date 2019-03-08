
<?php
$project_id = $_GET['id'];
include 'includes/session.php';
include 'includes/checkAccess.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <title>People</title>
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">
	
    <!-- Custom CSS -->
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/Homepage2.css"/>
    <link rel="stylesheet" href="css/sidebar-menu.css">
	<link rel="stylesheet" href="css/people.css" />
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
				<li class="nav-item">
				  <a class="nav-link" href="Homepage2.php?id=<?php echo $project_id; ?>">HOME</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="people.php?id=<?php echo $project_id; ?>">PEOPLE</a>
				</li>
			</ul>
			
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
				<!-- Projects Members -->
				<div class="col-md-8">
					<div class="people">
						<p class="people-title">Referee</p>
						
						<?php 
							$connection = mysqli_connect(DBHOST, DBUSER,DBPASS, DBNAME);
							if(mysqli_connect_errno()){
								die(mysqli_connect_error());
							}

							$sql = "SELECT User_ID FROM Referee WHERE Project_ID = '$project_id'";
							if ($result = mysqli_query($connection, $sql)) {
								while($row = mysqli_fetch_assoc($result)){
									$u_id = $row['User_ID'];
									$sql2 = "SELECT User_name FROM User WHERE User_ID = '$u_id'";
									if ($result2 = mysqli_query($connection, $sql2)) {
										$row2 = mysqli_fetch_assoc($result2);
										echo '<p class="people-user">'.$row2['User_name'].'</p>';
									}
								}
							}
							else{
								echo '<p class="people-user">-</p>';
							}
							
							mysqli_close($connection);
						?>

						<a class="people-footer" href="referee-adding.php?id=<?php echo $project_id; ?>">+ Add a referee</a>					
						<p class="people-title">Team Members</p>

						<?php 
							$connection = mysqli_connect(DBHOST, DBUSER,DBPASS, DBNAME);
							if(mysqli_connect_errno()){
								die(mysqli_connect_error());
							}

							$sql = "SELECT User_ID FROM Member WHERE Project_ID = '$project_id'";
							if ($result = mysqli_query($connection, $sql)) {
								while($row = mysqli_fetch_assoc($result)){
									$u_id = $row['User_ID'];
									$sql2 = "SELECT User_name FROM User WHERE User_ID = '$u_id'";
									if ($result2 = mysqli_query($connection, $sql2)) {
										$row2 = mysqli_fetch_assoc($result2);
										echo '<p class="people-user">'.$row2['User_name'].'</p>';
									}
								}
							}
							else{
								echo '<p class="people-user">-</p>';
							}
							
							mysqli_close($connection);
						?>

					</div>
				</div>				
			</div>
		</div>
	</div>
</div>

	<div class="overlay"></div>

</body>
</html>