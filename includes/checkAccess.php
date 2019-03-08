
<?php
//if a user is not a member of this project, redirect back to dashboard
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if(mysqli_connect_errno()){
	die(mysqli_connect_error());
}

$sql = "SELECT User_ID from MemberList WHERE Project_ID = $project_id and User_ID = $user_id";
$result = mysqli_query($connection, $sql);

if(mysqli_num_rows($result) <= 0){
	header("location: dashboard.php");
}

mysqli_close($connection);
?>