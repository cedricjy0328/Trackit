
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
	
	<title>Progress Tracking and Monitoring Application</title>
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
	<link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/Homepage2.css"/>
	<link rel="stylesheet" href="css/sidebar-menu.css"/>
	
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
	<script src="js/clipboard.min.js"></script>
	<script src="js/sidebar-menu.js"></script>
	
</head>
<body>

	<div class="headerDesc">
		<?php
			// Create connection
			$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			$sql = "SELECT project_name from project where $project_id = project_id";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo '<p>'.$row['project_name'].'</p>';
				}
			} 
			else{
				echo 'No project chosen!';
			}
		?>

		<!-- Project Progress Bar -->
		<div class="progress" style="width:60% ;" >
			<?php
				$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
				if(mysqli_connect_errno()){
					die(mysqli_connect_error());
				}
				$numOfGoals=0;
				$completedGoals=0;
				$percentage = 0;
				$sql = "SELECT status from goal where project_id = '$project_id';";
				$result=$conn->query($sql);
				if($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc()){
						if($row['status'] == 0 or $row['status'] == 1){
							$numOfGoals++;
							if($row['status'] == 1) {$completedGoals++;}
						}
					}
					$percentage = number_format(($completedGoals/$numOfGoals)*100, 2);
					echo '<div class="progress-bar bg-success" style="width:'.$percentage.'%">'.$percentage.'%</div>';
				}
				mysqli_close($conn);
			?>
		</div>
	</div>
	
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

				<ul class="nav justify-content-end">
					<!-- Dropdown -->
					<li class="nav-item dropdown">
						<a class="nav-item" href="" id="navbardrop" data-toggle="dropdown"><img src="images/profilePic.png" alt="user-profile" width="35" /></a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="settings.php">Settings</a>
							<a class="dropdown-item" href="logout.php">Logout</a>
						</div>
					</li>
				</ul>
			</nav>
			
			<div class="container" style="margin-top: 300px;">
				<div class="row">
					<!-- Sidebox -->
					<div class="col-md-4">
						<div class="sidebox">
							<div class="sidebox-header">To-do list</div>
							<ol>
								<?php
									// Create connection
									$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
									if ($conn->connect_error) {
										die("Connection failed: " . $conn->connect_error);
									} 
									$sql = "SELECT description,todolist_ID from todolist where $user_id = user_ID";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) {
											echo '<li>'.$row['description'].'</li>';
										}
									} 
									else {echo "Nothing to do!";}
									$conn->close()
								?>
							</ol>

							<div class="sidebox-footer">
								<!-- Add A Task -->
								<a onclick="document.getElementById('addtask').style.display='block'" href="#"><i class="fas fa-plus-circle fa-lg" alt="add" title="Add a task"></i></a>
								<div id="addtask" class="w3-modal">
									<div class="w3-modal-content">
										<div class="w3-container">
											<span onclick="document.getElementById('addtask').style.display='none'" class="w3-button w3-display-topright">&times;</span>
											<form class="modal-content" method="POST" action="insertTaskAction.php?id=<?php echo $project_id?>" id="inserttaskform" novalidate="novalidate">
												<div class="container-homepage">
													<h1>Add New Task</h1>
													<hr>
													<label for="task1"><b>New Task</b></label>
													<input type="text" class="form-control" placeholder="Enter Task" name="task" id="task">
													<div class="clearfix">
														<button type="submit" class="createbtn">Create Task(s)</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>

								<!-- Delete A Task -->
								<a onclick="document.getElementById('deletetask').style.display='block'" href="#"><i class="fas fa-trash-alt fa-lg" alt="add" title="Delete a task"></i></a>
								<div id="deletetask" class="w3-modal">
									<div class="w3-modal-content">
										<div class="w3-container">
											<span onclick="document.getElementById('deletetask').style.display='none'" class="w3-button w3-display-topright">&times;</span>
											<form class="modal-content" method="POST" action="delTaskAction.php?id=<?php echo $project_id?>">
												<div class="container-homepage">
													<h1>Delete Task(s)</h1>
													<hr>
													<p>Choose task(s) to delete:</p>
													<?php
														$conn = mysqli_connect(DBHOST,DBUSER,	DBPASS,DBNAME);
														if(mysqli_connect_errno()){
															die(mysqli_connect_error());
														}
														$sql = "SELECT  description,todolist_id from todolist where $user_id = user_id";
														$result=$conn->query($sql);
														if($result->num_rows > 0){
															while($row = $result->fetch_assoc()){
															echo '<ol>
																<input type="checkbox" name='.$row['todolist_id'].' value='.$row['todolist_id'].'> '.$row['description'].'<br>
																</ol>';
															}
															echo '<div class="clearfix">
															<button type="submit" class="createbtn">Delete Task</button>
															</div>';
														}
													?>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					
						<div class="sidebox">
							<div class="sidebox-header">Calender</div>
							<link rel="stylesheet" href="css/jsRapCalendar.css">
							
							<script src="js/jsRapCalendar.js"></script>
							<div id="calendar"></div>
							<script>
								$('#calendar').jsRapCalendar({
									week:6,
									onClick:function(y,m,d){
										alert(y + '-' + m + '-' + d);
									}
								});	
							</script>	
						</div>

						<!-- Due date of incomplete goals of the user -->
						<div class="sidebox">
							<div class="sidebox-header">Due Date</div>
							<ul>
								<?php
									// Create connection
									$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
									if ($conn->connect_error) {
										die("Connection failed: " . $conn->connect_error);
									} 
									$sql = "SELECT Goal_Name, Due_Date from Goal where Status = 0 and Incharge_User_ID = '$user_id' and Project_ID = '$project_id' ORDER BY Due_Date";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) {
											echo '<li>'.$row['Due_Date'].' '.$row['Goal_Name'].'</li>';
										}
									} 
									else {echo "Nothing due!";}
									$conn->close()
								?>
							</ul>
						</div>
					</div>

					<!-- Main content -->
					<div class="col-md-8">
						<div class="main-box">
							<div class="main-header">Goals</div>
							<ol>
							<?php
								// Create connection
								$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								} 
								$sql = "SELECT user_name,goal_id,goal_name,goal_description,start_date,
									(case when (end_date is null) then 'incomplete' ELSE end_date end) AS end_date, due_date, 
									(case when status = 0 then '-' else DATEDIFF(end_date, start_date)end) AS DateDiff,
									(case when status <>0 then 'complete' else 'incomplete' end) AS stat 
									FROM Goal,user 
									WHERE goal.project_id = $project_id 
									AND goal.incharge_user_id = user_id 
									ORDER BY goal_id;";
								$result = $conn->query($sql);
								$options = "";
								if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
										$goal_id = $row['goal_id'];
										$sql3 = "SELECT File_name, File_path FROM File WHERE Goal_ID = $goal_id and Project_ID = $project_id";
										$result3 = $conn->query($sql3);
										if ($result3->num_rows > 0) {
											while($row3 = $result3->fetch_assoc()) {
												$options .= '<a href="downloadfile.php?filename='.$row3['File_name'].'">'.$row3['File_name'].'</a><br>';
											}
										}
										else{
											$options = "";
										}
										$status = "";
										if ($row['stat'] == 'incomplete') {
											$status = "goal-details";
										}
										else{
											$status = "goal-details-done";
										}

										echo '
											<li>'.$row['goal_name'].'</li>
											<div class="'.$status.'">
												<b>Description: </b>'.$row['goal_description'].'<br>
												<b>Member in charge: </b>'.$row['user_name'].'<br>
												<b>Start date: </b>'.$row['start_date'].'<br>
												<b>End date: </b>'.$row['end_date'].'<br>
												<b>Due date: </b>'.$row['due_date'].'<br>
												<b>Status: </b>'.$row['stat'].'<br>
												<b>Time spent: </b>'.$row['DateDiff'].' day(s)<br>
											</div>
											<div class="goal-footer">
												<a onclick="document.getElementById(\'file'.$row['goal_id'].'\').style.display=\'block\'" href="#" class="goal-footer-upload">Upload a file</a>
												<div id="file'.$row['goal_id'].'" class="w3-modal">
													<div class="w3-modal-content">
														<div class="w3-container">
															<span onclick="document.getElementById(\'file'.$row['goal_id'].'\').style.display=\'none\'" class="w3-button w3-display-topright">&times;</span>
															<form class="modal-content" method="POST" enctype="multipart/form-data" action="uploadedFile.php?id='.$project_id.'&gid='.$row['goal_id'].'">
																<div class="container-homepage">
																	<h1>Upload A File</h1>
																	<hr>
																	<label>Upload a file</label>
																	<input type="file" name="file"/>
																	<div class="clearfix">
																		<button type="submit" class="createbtn">Upload</button>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
												<a onclick="document.getElementById(\'download'.$row['goal_id'].'\').style.display=\'block\'" href="#">Download a file</a>
												<div id="download'.$row['goal_id'].'" class="w3-modal">
													<div class="w3-modal-content">
														<div class="w3-container">
															<span onclick="document.getElementById(\'download'.$row['goal_id'].'\').style.display=\'none\'" class="w3-button w3-display-topright">&times;</span>
															
																<div class="container-homepage">
																	<h1>Download File(s)</h1>
																	<hr>
																	<label>Click a file to download:</label><br>
																	'.$options.'
																</div>
															
														</div>
													</div>
												</div>
												<a href="markAsDone.php?id='.$row['goal_id'].'&pid='.$project_id.'" class="goal-footer-done">Mark as done</a><br>
											</div>';
									}
								} 
								else {
									echo "No goals!";
								}
								$conn->close();
							?>
							</ol>
							<br><br>

							<div class="main-box-footer">
								<!-- Add A Goal -->
								<a onclick="document.getElementById('addgoal').style.display='block'" href="#"><i class="fas fa-plus-circle fa-lg" alt="add" title="Add a goal"></i></a>
								<div id="addgoal" class="w3-modal">
									<div class="w3-modal-content">
										<div class="w3-container">
											<span onclick="document.getElementById('addgoal').style.display='none'" class="w3-button w3-display-topright">&times;</span>

											<div class="container-homepage">
												<h1>Add New Goal</h1>
												<hr>
												<form class="modal-content" method="POST" action="insertGoalAction.php?id=<?php echo $project_id; ?>" id="insertgoalform" novalidate="novalidate">
													<label for="goal1"><b>Goal Name</b></label>
													<input type="text" class="form-control" placeholder="Enter Goal Name" id="goal1" name="goal1">

													<label for="mic1"><b>Goal Description</b></label>
													<input type="text" class="form-control" placeholder="Enter Goal Description" id="goaldes1" name="goaldesc1">

													<label for="mic1"><b>Member In Charge</b></label>
													<select name="mic1"  class="form-control">
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
																	echo '<option value="'.$row2['User_name'].'">'.$row2['User_name'].'</option>';
																}
															}
														}
														else{
															echo '<p class="people-user">-</p>';
														}

														mysqli_close($connection);
													?>
													</select>
													
													<label for="due-date1"><b>Due Date: </b></label>
													<input type="date" class="form-control" id="due_date1" name="due_date1"><br><br>
													<div class="clearfix">
														<button type="submit" class="createbtn">Add Goal</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>

								<!-- Delete A Goal -->
								<a onclick="document.getElementById('deletegoal').style.display='block'" href="#"><i class="fas fa-trash-alt fa-lg" alt="delete" title="Delete a goal"></i></a>
								<div id="deletegoal" class="w3-modal">
									<div class="w3-modal-content">
										<div class="w3-container">
											<span onclick="document.getElementById('deletegoal').style.display='none'" class="w3-button w3-display-topright">&times;</span>
											<form class="modal-content" method="POST" action="delGoalAction.php?id=<?php echo $project_id?>">
												<div class="container-homepage">
													<h1>Delete Goal(s)</h1>
													<hr>
													<p>Choose goal(s) to delete</p>
													<?php
														$conn = mysqli_connect(DBHOST,DBUSER,	DBPASS,DBNAME);
														if(mysqli_connect_errno()){die(mysqli_connect_error());}

														$sql = "SELECT  goal_id,goal_name from goal where $project_id = goal.project_id";
														$result=$conn->query($sql);
														if($result->num_rows > 0)
														{
															while($row = $result->fetch_assoc()){
																echo '
																	<input type="checkbox" name='.$row['goal_name'].' value='.$row['goal_id'].'> '.$row['goal_name'].'<br>';
															}
															echo '<div class="clearfix">
																	<button type="submit" class="createbtn">Delete Goal</button>
																</div>';
														}
													?>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="overlay"></div>

</body>
</html>