<?php
include 'includes/session.php';
$goal_id = $_GET['id'];
$project_id = $_GET['pid'];

$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(mysqli_connect_errno()){
    die(mysqli_connect_error());
} 

$sql = "UPDATE goal SET goal.status = 1, end_date = CURDATE() WHERE '$goal_id' = goal_id;"; 
$conn->query($sql);

mysqli_close($conn);
header("location: homepage2.php?id=$project_id");
?>