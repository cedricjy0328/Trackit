<?php
	include 'includes/session.php';
	$project_id = $_GET['id'];
    include 'includes/checkAccess.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['task'])){

            $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
            if(mysqli_connect_errno()){
                die(mysqli_connect_error());
            }

            $sql = "INSERT INTO todolist (`description`,`user_id`) VALUES ('$_POST[task]','$user_id');";
            
            //prepare query statement
            if($statement = mysqli_prepare($conn, $sql)){
                mysqli_stmt_execute($statement);
            }
            mysqli_close($conn);

            header("location: homepage2.php?id=$project_id");
        }
    }
?>