<?php

include 'includes/session.php';
$project_id = $_GET['id'];

$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

$sql = "DELETE from Member where User_ID = $user_id and Project_ID = $project_id";
$conn->query($sql);

$sql = "DELETE from MemberList where User_ID = $user_id and Project_ID = $project_id";
$conn->query($sql);

header("location: dashboard.php");

mysqli_close($conn);

?>