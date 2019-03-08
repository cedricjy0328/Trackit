<?php
    include 'includes/session.php';
    $project_id = $_GET['id'];

    $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if(mysqli_connect_errno()){die(mysqli_connect_error());}

    foreach( $_POST as $value) { 
        $sql = "DELETE FROM todolist where todolist_id = '$value' && user_id = '$user_id'"; 
        $conn->query($sql);
    }
    mysqli_close($conn);
    header("location: homepage2.php?id=$project_id");
?>