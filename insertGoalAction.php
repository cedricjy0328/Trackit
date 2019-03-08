<?php
include 'includes/session.php';
$project_id = $_GET['id'];
include 'includes/checkAccess.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(isset($_POST['goal1']) && isset($_POST['goaldesc1']) && isset($_POST['mic1']) && isset($_POST['due_date1'])){
        
        $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if(mysqli_connect_errno()){
            die(mysqli_connect_error());
        }
        $goal = $_POST['goal1'];
        $goaldesc = $_POST['goaldesc1'];
        $userName = $_POST['mic1'];
        $sql = "INSERT INTO goal (goal_name, goal_description, `incharge_user_id`,`start_date`,`due_date`,`project_id`) 
        VALUES ( ?,?, (SELECT user_id from user as userIDincharge WHERE user_name = ?), CURDATE(),'$_POST[due_date1]', '$project_id')";

        //prepare query statement
        if($statement = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($statement, "sss", $goal,$goaldesc,$userName);
            mysqli_stmt_execute($statement);
        }
        mysqli_close($conn);

        header("location: homepage2.php?id=$project_id");
    }
}
?>

