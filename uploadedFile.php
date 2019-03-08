<?php
include 'includes/session.php';

$project_id = $_GET['id'];
$goal_id = $_GET['gid'];
$fileMessage = "";

if(isset($_FILES['file'])){
	$name = $_FILES['file']['name'];
	$size = $_FILES['file']['size'];
	$type = $_FILES['file']['type'];
	$tmp_name = $_FILES['file']['tmp_name'];

	if(isset($name) && !empty($name)){
		$name = uniqid().'_'.$name;
		$target_dir = "uploadedFile/";
		$target_file = $target_dir . basename($name);

		if(move_uploaded_file($tmp_name, $target_file)){
			$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
			if(mysqli_connect_errno()){
				die(mysqli_connect_error());
			}

			$sql = "INSERT INTO File(`File_Name`,`File_Path`,`Project_ID`,`Goal_ID`) VALUES(?, ?, $project_id, $goal_id)";
			
			if($statement = mysqli_prepare($connection, $sql)){
				mysqli_stmt_bind_param($statement,'ss', $name, $target_file);
				mysqli_stmt_execute($statement);
				$fileMessage = "Uploaded Successfully";
				header("location: homepage2.php?id=$project_id");
			}
			else{
				$fileMessage = "Failed to Upload File";
			}
		}else{
			$fileMessage = "Failed to Upload File";
		}
	}
}
else{
	$fileMessage = "Please Select a File";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php echo $fileMessage; ?>
	<?php echo $name; ?>
	<a href="homepage2.php?id=<?php echo $project_id;?>">Back</a>
</body>
</html>