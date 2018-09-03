<?php 
	session_start();
	$db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");

	if ($_POST['action'] == 'newProject') {
			$name = isset($_POST['name']) ? $_POST['name'] : "";
			$creator = $_POST['creator'];
			$overview = isset($_POST['overview']) ? $_POST['overview'] : "";
			$amount = $_POST['amount'];
			$end_date = $_POST['end_date'];
			$date = new Datetime($end_date);

			$findProjectByName = "SELECT * FROM `project` WHERE name like '$name'";
			$data = mysqli_fetch_all(mysqli_query($db,$findProjectByName),MYSQLI_ASSOC);

			if(empty($data)) {
				$insertProject = "INSERT INTO `project`(`name`, `creator`, `overview`, `amount`, `start_date`, `end_date`, `active`) VALUES('$name', '$creator', '$overview', '$amount', NOW(), '".$date->format('Y-m-d')."', 1)";
				$data = mysqli_query($db,$insertProject);
				if (mysqli_insert_id($db) == 0) 
					$array = array('status' => 'bad', 'message' => $insertProject);
				else 
					$array = array('status' => 'ok', 'data' => mysqli_insert_id($db), 'url' => 'project.php?proj='.$name);
			}
			else {
			$array = array('status' => 'bad', 'message' => 'Project already exists');
			}
	}

	if ($_POST['action'] == 'editProject') {
		$activeName = $_POST['activeName'];
		$name = isset($_POST['name']) ? $_POST['name'] : "";
		$creator = $_POST['creator'];
		$overview = isset($_POST['overview']) ? $_POST['overview'] : "";
		$amount = $_POST['amount'];
		$end_date = $_POST['end_date'];
		$date = new Datetime($end_date);

		$updateProject = "UPDATE `project` SET `name` = '$name',  `overview` = '$overview', `amount` = '$amount', `end_date` = '".$date->format('Y-m-d')."'  WHERE name like '$activeName'";
		$data = mysqli_query($db,$updateProject);
		if (mysqli_affected_rows($db) == 0) 
			$array = array('status' => 'bad', 'message' => $updateProject, 'url' =>	'project.php?proj='.$activeName);
		else 
			$array = array('status' => 'ok', 'url' => 'project.php?proj='.$name);
	}
	mysqli_close($db);
	echo json_encode($array);
?>