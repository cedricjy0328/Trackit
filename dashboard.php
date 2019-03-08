<?php
	include 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <title>Dashboard</title>
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">
	
    <!-- Custom CSS -->
	<link rel="stylesheet" href="css/Homepage2.css"/>
    <link rel="stylesheet" href="css/sidebar-menu.css">
	<link rel="stylesheet" href="css/dashboard.css" />
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
	<!-- Clipboard.js -->
	<script src="js/clipboard.min.js"></script>
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
				<a href="">Project</a>
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
		  
			<ul class="nav justify-content-end">
				<!-- Add a new project -->
				<li class="nav-item"><a onclick="document.getElementById('id01').style.display='block'" class="nav-item" href="#"><img src="images/add.png" alt="add-project" width="35" /></a></li>
				<div id="id01" class="modal">
					<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
					<form class="modal-content" method="POST" action="addProjectAction.php" id="projectForm">
						<div class="container-dashboard">
							<h1>Add A New Project</h1>
							<hr>
							<p>Join a current project using an invitation code</p>
							<label for="inv-code"><b>Invitation Code</b></label>
							<input type="text" placeholder="Enter Invitation Code" id="code" name="inv-code">
							<div class="strike"><span>OR</span></div>
							<br>
							<p>Create a new project</p>
							<label for="title"><b>Project Title</b></label>
							<input type="text" placeholder="Enter Project Title" id="title" name="title">

							<label for="due-date"><b>Due Date: </b></label>
							<input type="date" name="due_date"><br><br>
							
							<p id="alertMessage1" class="valid">You cannot join and create a project at the same time.</p>
							<p id="alertMessage2" class="valid">Please enter invitation code to join a project or create a project.</p>
							<div class="clearfix">
								<button type="submit" class="createbtn">Join/Create Project</button>
							</div>
						</div>
					</form>
				</div>
				<!-- User dropdown -->
				<li class="nav-item dropdown">
					<a class="nav-item" href="#" id="navbardrop" data-toggle="dropdown"><img src="images/profilePic.png" alt="user-profile" width="35" /></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="settings.php">Settings</a>
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
			</ul>
		</nav>
			
		<div class="container" style="margin-top: 100px;">
			<div class="row">
				<!-- Projects -->
				<?php
					// Create connection
					$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} 
					$sql = "SELECT project.project_id, project.project_name, project.start_date, project.end_date, project.project_code FROM project,memberlist where '$user_id' = memberlist.user_ID && project.project_ID = memberlist.project_id";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							$project_id = $row['project_id'];
							$project_name = $row['project_name'];
							$start_date = $row['start_date'];
							$end_date = $row['end_date'];
							$project_code = $row['project_code'];
							
							$numOfGoals = 0;
							$completedGoals = 0;
							$percentage = 0;
							$sql2 = "SELECT status from goal where project_id = '$project_id';";
							$result2=$conn->query($sql2);
							if($result2->num_rows > 0)
							{
								while($row2 = $result2->fetch_assoc()){
									$numOfGoals++;
									if($row2['status'] == 1) {
										$completedGoals++;
									}
							 	}
								$percentage = number_format(($completedGoals/$numOfGoals)*100, 2);
							}

							echo '<div class="col-md-4">
								 	<div class="projectBox">
										<a class="projectBox-title" href="homepage2.php?id='.$project_id.'">'.$project_name.'</a>
										<br>
										<div class="progress" style="width:100%;">
											<div class="progress-bar bg-success" style="width:'.$percentage.'%">'.$percentage.'%</div>
										</div>
										<br>
										<span class="projectBox-desc">
											Created on: '.$start_date.'<br>
											Due date: '. $end_date.'
										</span>

										<!-- Projects More -->
										<div class="projectBox-footer">
											<div class="dropdown">
												<a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
												<div class="dropdown-menu">
													<!-- Generate Project Code Pop Up Box -->
													<a onclick="document.getElementById(\'code'.$project_id.'\').style.display=\'block\'" class="dropdown-item" href="#">Generate Code</a>
													<!-- Quit Project Confirm Box -->
													<a onclick="confirmBox()" class="dropdown-item" href="quitProject.php?id='.$project_id.'">Quit</a>
												</div>
												<!-- Generate Project Code Pop Up Box -->
												<div id="code'.$project_id.'" class="w3-modal">
													<div class="w3-modal-content">
														<div class="w3-container">
															<span onclick="document.getElementById(\'code'.$project_id.'\').style.display=\'none\'" class="w3-button w3-display-topright">&times;</span>
															<div class="db-modal-content">
																<div class="container-homepage">
																	<h1>Invitation Code</h1>
																	<hr>
																	<label for="code'.$project_id.'"><b>Invitation Code</b></label>
																	<input type="text" id="invCode1" value="'.$project_code.'">
																	<center><button data-clipboard-target="#invCode1">Copy</button></center>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>';
						}
					} else {
						echo "No projects! Add a project from the top right add button.";
					}
					$conn->close();
				?>
			</div>
		</div>
	</div>
</div>

	<div class="overlay"></div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

<script type="text/javascript" src="js/dashboard.js"></script>

<!-- Copy to Clipboard JavaScript-->
<script>
    var btns = document.querySelectorAll('button');
    var clipboard = new ClipboardJS(btns);
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>

<!-- Confirm Box JavaScript-->
<script>
function confirmBox() {
  var txt;
  if (confirm("Are you sure want to quit this project?")) {
    txt = "You pressed OK!";
  } else {
    txt = "You pressed Cancel!";
  }
}
</script>

</body>
</html>