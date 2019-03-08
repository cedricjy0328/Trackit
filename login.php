<?php
include_once 'includes/dbConfig.php';

function validLogin(){
	//connect to database
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	if(mysqli_connect_errno()){
		die(mysqli_connect_error());
	}

	//prepare query statement
	$email = $_POST['email'];
	$sql = "select User_password from USER where User_email = ?";
	
	if($statement = mysqli_prepare($connection, $sql)){
		mysqli_stmt_bind_param($statement, 's', $email);
		mysqli_stmt_execute($statement);

		//bind result variable
		mysqli_stmt_bind_result($statement, $pw);

		//fetch the result
		mysqli_stmt_fetch($statement);

		// Verify user password and set $_SESSION
		if (password_verify($_POST['password'], $pw ) ) {
			//close the statement
			mysqli_stmt_close($statement);
			mysqli_close($connection);
			return true;
		}
		else{
			//close the statement
			mysqli_stmt_close($statement);
			mysqli_close($connection);
			return false;
		}
	}
}

session_start();

//initialize variable
$alertMessage = '';
$alertClass = '';
$emailMessage = '';
if (isset($_POST['email']) && isset($_POST['password'])) {
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$emailMessage = "Invalid email format"; 
	}
	else{
		if(validLogin()){
			//if the login is valid, set the session
			$_SESSION['email'] = $_POST['email'];
			//redirect to the dashboard
			header("location: dashboard.php");
		}
		else{
			//else display error message
			$alertMessage = 'Wrong email and password combination!';
			$alertClass = 'has-error';
		}
	}

	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Trackit - Login</title>

	<link rel="stylesheet" href="css/reset.css" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
	<link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/Homepage2.css" />
	<link rel="stylesheet" href="css/login.css" />
	
	<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
	<?php
	if(isset($_SESSION['email'])):
		header("location: dashboard.php");
	else:
	?>
		<nav class="navbar bg-dark navbar-dark">
			<ul class="nav justify-content-start">
				<li class="nav-item">
					<a class="navbar-brand" href="Homepage2.html">Trackit</a>
				</li>
			</ul>
		</nav>

		<div class="container" style="margin-top: 50px;">
			<div class="row">
				<!-- Login Form -->
				<div class="col-md-12">
					<div class="loginBox">
						<center><h3>Login to Trackit</h3></center>
						<br>
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="loginform" novalidate="novalidate">
							<div class="form-group <?php echo $alertClass?>">
								<label for="email">Email address:</label>
								<input type="email" class="form-control" id="email" name="email">
								<p id="emailEmpty" class="valid">**Please enter your email.**</p>
								<p id="emailWrongFormat" class="valid">**Invalid email format.**</p>
								<p class="invalid"><?php echo $emailMessage; ?></p>	
							</div>
							<div class="form-group <?php echo $alertClass?>">
								<label for="pwd">Password:</label>
								<input type="password" class="form-control" id="pwd" name="password">
								<p id="pwdEmpty" class="valid">**Please enter your password.**</p>
							</div>
							<div id="alert">
								<?php echo $alertMessage; ?>
							</div>
							<br/>
							<p>Do not have an account? Click here to <a href="sign-up.php">sign up</a>.</p>
							<center><button type="submit" class="btn btn-primary">Submit</button></center>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</body>
</html>

