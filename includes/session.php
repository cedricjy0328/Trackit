<?php
include_once 'includes/dbConfig.php';
session_start();

//if the session exist, get the user data from database
if(isset($_SESSION['email'])){
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	//mysqli_connect_errno() function returns the error code from the last connection error, if any.
	//mysqli_connect_error() function returns the error description from the last connection error, if any.
	if(mysqli_connect_errno()){
		die(mysqli_connect_error());
	}

	$user_email = $_SESSION['email'];

	$ses_sql = mysqli_query($connection, "select User_ID from User where User_email = '$user_email' ");

	$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

	$user_id = $row['User_ID'];

	mysqli_close($connection);
}
else{
	// Redirect them to the login page
	header("location: login.php");
}

?>