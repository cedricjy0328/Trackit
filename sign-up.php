<?php
include_once 'includes/dbConfig.php';

function validSignUp(){
	//connect to database
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	if(mysqli_connect_errno()){
		die(mysqli_connect_error());
	}

	//prepare query statement
	$email = $_POST['email'];
	
	$sql = "SELECT User_email from USER where User_email = ?";
	if($statement = mysqli_prepare($connection, $sql)){
		mysqli_stmt_bind_param($statement, 's', $email);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		
		//bind result variable
		mysqli_stmt_bind_result($statement, $pw);

		//fetch the result
		mysqli_stmt_fetch($statement);
		
		if(mysqli_stmt_num_rows($statement) > 0){   //if the email already exists in database
			//close the statement
			mysqli_stmt_close($statement);
			mysqli_close($connection);
			return false;
		}
		else{
			//close the statement
			mysqli_stmt_close($statement);
			mysqli_close($connection);
			return true;
		}
	}
	mysqli_close($connection);
}

function registerNewAccount(){
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

	//mysqli_connect_errno() function returns the error code from the last connection error, if any.
	//mysqli_connect_error() function returns the error description from the last connection error, if any.
	if(mysqli_connect_errno()){
		die(mysqli_connect_error());
	}

	$password = $_POST['password'];
	$sql = "INSERT INTO user (`User_name`, `User_email`, `User_password`) VALUES ('$_POST[name]', '$_POST[email]', ?)";

	//prepare query statement
	if($statement = mysqli_prepare($connection, $sql)){
		$passwordHashed = password_hash($password, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($statement, 's', $passwordHashed);
		mysqli_stmt_execute($statement);
	}

	mysqli_close($connection);
}

session_start();

//initialize variable
$alertMessage = '';
$alertClass = '';
$emailMessage = '';
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$emailMessage = "Invalid email format"; 
	}
	else{
		if(validSignUp()){
			registerNewAccount();
			//if the login is valid, set the session
			$_SESSION['email'] = $_POST['email'];
		}
		else{
			//else display error message
			$alertMessage = "The email has been used for another account! Please login or use another email to signup.";
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
	
	<title>Trackit - Sign Up</title>

	<link rel="stylesheet" href="css/reset.css" />
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	
	<!-- Bootstrap core CSS -->
	<link href="bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/Homepage2.css" />
	<link rel="stylesheet" href="css/signup.css" />

	<script type="text/javascript" src="js/sign-up.js"></script>
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
					<div class="signupBox">
						<center><h3>Sign Up to Trackit</h3></center>
						<br>
						<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="signupform" novalidate="novalidate">
							<div class="form-group <?php echo $alertClass?>">
								<label for="text">Full name:</label>
								<input type="text" class="form-control" id="name" name="name">
								<p id="nameEmpty" class="valid">**Please enter your name.**</p>
								<p id="nameWrongFormat" class="valid">**Username must contain only letters, numbers, underscores and space.**</p>
							</div>
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
								<p id="invalidPassword" class="valid">**Please make sure your password consists of at least 6 characters with 
								minimum 1 lowercase, 1 uppercase and 1 number.**</p>
							</div>
							<div class="form-group <?php echo $alertClass?>">
								<label for="pwd">Confirm password:</label>
								<input type="password" class="form-control" id="conf-pwd" name="conf_pwd">
								<p id="cpwdNotMatch" class="valid">**Please make sure this password matches password above.**</p>
							</div>
							<div id="alert">
								<?php echo $alertMessage; ?>
							</div>
							<br/>
							<p>Already have an account? Click here to <a href="login.php">login</a>.</p>
							<center><button type="submit" class="btn btn-primary">Submit</button></center>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?> 
</body>
</html>