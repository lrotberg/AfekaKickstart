<?php
	try {
		// connection
		$db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");

		// get details
		$un = $_POST['username'] = ''; 
		$pw = $_POST['password'] = '';
		$secretKey = 'JSR*@*HKSFS';
		$hash = hash('sha512', $_POST['password'].$secretKey);

		// insert user
		$insertQuery = "INSERT INTO `USERS` (`username`,`password`,`permissions`) VALUES ('$un','$pw',2)";
		echo $insertQuery;
		$data = mysqli_query($db,$insertQuery);
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		echo mysqli_error($db);

		// insert project
		$pname = $_POST['pname'];
		$creator = $_POST['creator'];
		$overview = $_POST['overview'];
		$amount = $_POST['amount'];
		$end_date = $_POST['end_date'];
		$insertProject = "INSERT INTO `project`(`name`, `creator`, `overview`, `amount`, `start_date`, `end_date`, `active`) 
						VALUES('$pname', '$creator', '$overview', '$amount', getdate(), '$end_date', 1)";
		$data = mysqli_query($db, $insertProject);

		// insert donation
		$pid = $_POST['pid'];
		$donator_id = $_POST['donator_id'];
		$amount = $_POST['amount'];
		$insertDonation = "INSERT INTO `donation`(`project_id`, `donator_id`, `date`, `amount`) 
						VALUES('$pid', '$donator_id', getdate() , '$amount')";
		$data = mysqli_query($db, $insertDonation);

		// insert permission
		$permission_type = $_POST['permission_type'];
		$permission_user = $_POST['permission_user'];
		$pid = $_POST['pid'];
		$insertPermission = "INSERT INTO `permission`(`permission_type`, `permission_user`, `project_id`) 
						VALUES('$permission_type', '$permission_user', '$pid')";
		$data = mysqli_query($db, $insertPermission);

		// select user
		$selectQuery = "SELECT * FROM `users` inner join `permissions` on permissions.id = users.permissions where username like '%$un%' and password like '%hash%'";
		$data = mysqli_fetch_all(mysqli_query($db,$selectQuery),MYSQLI_ASSOC);
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		// select project
		$pid = $_POST['pid'];
		$creator = $_POST['creator'];

		$selectProject = "SELECT * FROM `project` where id = '$pid'";
		$data = mysqli_fetch_all(mysqli_query($db,$selectProject),MYSQLI_ASSOC);

		$selectAllProjects = "SELECT * FROM `project`";
		$data = mysqli_fetch_all(mysqli_query($db,$selectAllProjects),MYSQLI_ASSOC);

		$selectAllProjectsPerUser = "SELECT * FROM `project` WHERE `creator` = '$creator";
		$data = mysqli_fetch_all(mysqli_query($db,$selectAllProjectsPerUser),MYSQLI_ASSOC);

		// Select donations
		$donator_id = $_POST['donator_id'];
		$pid = $_POST['pid'];

		$selectAllDonationsPerUser = "SELECT * FROM `donation` INNER JOIN `project` on donation.project_id = project.id 
									WHERE `donator_id` = '$donator_id";
		$data = mysqli_fetch_all(mysqli_query($db,$selectAllDonationsPerUser),MYSQLI_ASSOC);

		$selectAllDonationsPerProject ="SELECT * FROM `donation` WHERE project_id = $pid";
		$data = mysqli_fetch_all(mysqli_query($db,$selectAllDonationsPerProject),MYSQLI_ASSOC);

		// select permission
		$permission_user = $_POST['permission_user'];

		$selectPermission = "SELECT * FROM `permission` WHERE permission_user = $permission_user";
		$data = mysqli_fetch_all(mysqli_query($db,$selectPermission),MYSQLI_ASSOC);

		// update user
		$pw = $_POST['password'] = '';
		$secretKey = 'JSR*@*HKSFS';
		$hash = hash('sha512', $_POST['password'].$secretKey);
		$id = $_POST['uid'];
		$permission = $_POST['permissions'];

		$updateUserPassword = "UPDATE `users` set password = '$pw' where id = '$uid'";
		$data = mysqli_query($db, $updateUserPassword);

		$updateUserPermissions = "UPDATE `users` set permissions = '$permission' where id = '$uid'";
		$data = mysqli_query($db, $updateUserPassword);

		// update project
		$name = $_POST['name'];
		$overview = $_POST['overview'];
		$pid = $_POST['id'];
		$updateProject = "UPDATE `project` set name = '$name', overview = '$overview' where id = '$pid'"
		$data = mysqli_query($db, $updateProject);

		// delete permission
		$permission_id = $_POST['id']
		$deletePermission = "DELETE FROM `permission` WHERE id = '$permission_id'"

	}
	catch (Exception $e) {
		echo $e->getMessage();	
		echo mysqli_error($db);
	}

?>