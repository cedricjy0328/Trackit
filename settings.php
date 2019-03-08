<?php

include 'includes/session.php';

$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

//mysqli_connect_errno() function returns the error code from the last connection error, if any.
//mysqli_connect_error() function returns the error description from the last connection error, if any.
if(mysqli_connect_errno()){
	die(mysqli_connect_error());
}

$emailAlertMessage = "";
//for changing the email
if(isset($_POST['oldEmail']) && isset($_POST['email']) && isset($_POST['confEmail'])){
	$email = $_POST['email'];

	if($_SESSION['email'] == $_POST['oldEmail']){
		//check if the new email has been used
		$sql = "SELECT * from User WHERE User_email = '$email'";
		$result = $connection->query($sql);
		if ($result->num_rows == 0) {
			$sql = "UPDATE User SET User_email = ? WHERE User_ID = $user_id";
			if($statement = mysqli_prepare($connection, $sql)){
				mysqli_stmt_bind_param($statement, 's', $email);
				mysqli_stmt_execute($statement);
				$_SESSION['email'] = $email;
			}
			$emailAlertMessage = "";
		}
		else{
			$emailAlertMessage = "The email has been used by another account. Please use a different email.";
		}
	}
	else{
		$emailAlertMessage = "Wrong old email!";
	}
}

$passAlertMessage = "";
//for changing the password
if(isset($_POST['oldPass']) && isset($_POST['newPass']) && isset($_POST['confPass'])){
	$oldPass = $_POST['oldPass'];
	$newPass = $_POST['newPass'];
	$sql = "SELECT User_password from User WHERE User_ID = '$user_id'";
	$result = $connection->query($sql);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		if(password_verify($oldPass, $row['User_password'] )){
			//correct old password input, update the new password
			$sql = "UPDATE User SET User_password = ? WHERE User_ID = '$user_id'";
			if($statement = mysqli_prepare($connection, $sql)){
				$passwordHashed = password_hash($newPass, PASSWORD_DEFAULT);
				mysqli_stmt_bind_param($statement, 's', $passwordHashed);
				mysqli_stmt_execute($statement);
			}
			$passAlertMessage = "";
		}
		else{
			//wrong old password input
			$passAlertMessage = "Wrong old password!";
		}
	}
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Settings</title>
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
	<link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/reset.css" />
	<link rel="stylesheet" href="css/Homepage2.css"/>
	<link rel="stylesheet" href="css/sidebar-menu.css">
	<link rel="stylesheet" href="css/settings.css" />
	
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
	<script src="js/settings.js"></script>
	
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
				<li>
					<a href="reminder.php">Reminders</a>
				</li>
				<li class="active">
					<a href="#">Settings</a>
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
							<a class="dropdown-item" href="#">Settings</a>
							<a class="dropdown-item" href="logout.php">Logout</a>
						</div>
					</li>
				</ul>
			</nav>
			
			<div class="container" style="margin-top: 50px;">
				<div class="row">
					<!-- Settings -->
					<div class="col-md-8">
						<div class="settings">
							<p class="settings-title">Settings</p>
							<p class="settings-desc">Change Email Address</p>
							
								<div class="card card-body">
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="changeEmailForm" novalidate="novalidate">
										<div class="form-group row">
											<label for="oldEmail" class="col-sm-2 col-form-label">Current Email</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="oldEmail" placeholder="Old Email" name="oldEmail">
											</div>
										</div>
										<div class="form-group row">
											<label for="newEmail" class="col-sm-2 col-form-label">Email</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="newEmail" placeholder="New Email" name="email">
											</div>
											<p id="emailEmpty1" class="valid">**Please enter your email.**</p>
											<p id="emailWrongFormat1" class="valid">**Invalid email format.**</p>
										</div>
										<div class="form-group row">
											<label for="confirmEmail" class="col-sm-2 col-form-label">Confirm Email</label>
											<div class="col-sm-10">
												<input type="email" class="form-control" id="confirmEmail" placeholder="Confirm Email" name="confEmail">
											</div>
											<p id="emailEmpty2" class="valid">**Please enter your email.**</p>
											<p id="emailWrongFormat2" class="valid">**Invalid email format.**</p>
											<p id="emailNotMatch" class="valid">**Emails not matched.**</p>
										</div>
										<div class="invalid"><?php echo $emailAlertMessage; ?></div>
										<div class="settings-footer"><button type="submit" class="btn btn-primary btn-sm">Save change</button></div>
									</form>
								</div>
							
							<p class="settings-desc">Change Password</p>
							
								<div class="card card-body">
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="changePassForm" novalidate="novalidate">
										<div class="form-group row">
											<label for="oldPassw" class="col-sm-2 col-form-label">Current Password</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" id="oldPassw" placeholder="Current Password" name="oldPass">
											</div>
											<div class="invalid"><?php echo $passAlertMessage; ?></div>
											<p id="oldPwdEmpty" class="valid">**Please enter your old password.**</p>
										</div>
										<div class="form-group row">
											<label for="newPassw" class="col-sm-2 col-form-label">New Password</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" id="newPassw" placeholder="New Password" name="newPass">
											</div>
											<p id="newPwdEmpty" class="valid">**Please enter your new password.**</p>
											<p id="invalidPassword" class="valid">**Please make sure your password consists of at least 6 characters with minimum 1 lowercase, 1 uppercase and 1 number.**</p>
										</div>
										<div class="form-group row">
											<label for="confirmPassw" class="col-sm-2 col-form-label">Confirm Password</label>
											<div class="col-sm-10">
												<input type="password" class="form-control" id="confirmPassw" placeholder="Confirm New Password" name="confPass">
											</div>
											<p id="cpwdNotMatch" class="valid">**Please make sure this password matches password above.**</p>
										</div>
										<div class="settings-footer"><button type="submit" class="btn btn-primary btn-sm">Save changes</button></div>
									</form>
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