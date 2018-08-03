<?php 
	session_start();
	if ($_POST['action'] == 'logout') {
		$_SESSION = array();
		session_destroy();
		die('out');
	}
	$db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");

		// get details
	$un = $_POST['username']; 
	$pw = $_POST['password'];
	$secretKey = 'JSR*@*HKSFS';
	$hash = strtoupper(hash('sha256', $pw.$secretKey));

	if ($_POST['action'] == 'signup') {
		$selectQuery = "SELECT * FROM `users` where username like '%$un%'";
		$data = mysqli_fetch_all(mysqli_query($db,$selectQuery),MYSQLI_ASSOC);

		if(empty($data)) {
			$insertQuery = "INSERT INTO `USERS` (`username`,`password`,`permissions`) VALUES ('$un','$hash',2)";
			$data = mysqli_query($db,$insertQuery);
			if (mysqli_insert_id($db) == 0) 
				$array = array('status' => 'bad', 'message' => $insertQuery);
			else {
				$array = array('status' => 'ok', 'data' => mysqli_insert_id($db));
				$_SESSION['id'] = $array['data'];
				$_SESSION['un'] = $un;
			}
		}
		else {
			$array = array('status' => 'bad', 'message' => 'Username already exists');
		}
	}

	if ($_POST['action'] == 'login') {
		$selectQuery = "SELECT users.id FROM `users` inner join `permissions` on permissions.id = users.permissions where username = '$un' and password = '$hash'";
		$data = mysqli_fetch_all(mysqli_query($db,$selectQuery),MYSQLI_ASSOC);
		if (!empty($data)) {
			$array = array('status' => 'ok', 'data' => $data[0]['id']);
			$_SESSION['id'] = $array['data'];
			$_SESSION['un'] = $un;
		}
		else {
			$array = array('status' => 'bad', 'message' => 'Invalid username or password');
		}
	}
	mysqli_close($db);
	echo json_encode($array);

 ?>