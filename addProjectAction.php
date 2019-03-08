
<?php

include 'includes/session.php';
//connect to database
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

if($_POST['inv-code'] != ""){
	//if the user input an invitation code to join an existing project
	$invCode = $_POST['inv-code'];
	$sql = "SELECT Project_ID FROM Project where '$invCode' = Project_Code";

	$result = $conn->query($sql);

	//if there is such project, add the user to the project as member
	if ($result) {
		$row = $result->fetch_assoc();
		$pid =  $row['Project_ID'];

		//if the project is already added
		$sql = "SELECT User_ID, Project_ID FROM Member where '$user_id' = User_ID and '$pid' = Project_ID";
		$result = $conn->query($sql);
		if(!$result){
			echo "The project is already in your dashboard.";
		}
		else{
			$sql = "INSERT INTO MemberList (User_ID, Project_ID, Member_Type) VALUES ('$user_id','$pid', 'M') ";
			$conn->query($sql);

			$sql = "INSERT INTO Member (User_ID, Project_ID) VALUES ('$user_id','$pid') ";
			$conn->query($sql);

			//redirect to the project page
			header("location: Homepage2.php?id=$pid");
		}
	}
	else{
		echo 'No Such Project.';   
	}
}
else{
	//if the user wants to create a new project
	$date = date("Y-m-d");
	$code = uniqid();	
	$name = $_POST['title'];
	$due_date = $_POST['due_date'];

	$sql = "INSERT INTO Project (Project_Name, Start_Date, End_Date, Project_Code) VALUES ('$name','$date','$due_date','$code')";
	$conn->query($sql);

	$last_id = $conn->insert_id;

	$sql = "INSERT INTO MemberList (User_ID, Project_ID, Member_Type) VALUES ('$user_id','$last_id','M')";
	$conn->query($sql);

	$sql = "INSERT INTO Member (User_ID, Project_ID) VALUES ($user_id,'$last_id')";
	$conn->query($sql);

	//redirect to the project page
	header("location: Homepage2.php?id=$last_id");
}

//close connection to database
mysqli_close($conn);

?>