<?php
	try {
		// connection
		$db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");

		$un = $_POST['username']; 
		$pw = $_POST['password'];
		// $secretKey = 'JSR*@*HKSFS';
		// $hash = hash('sha512', $_POST['password'].$secretKey);

		$selectQuery = "SELECT * FROM `users`";
		$data = mysqli_fetch_all(mysqli_query($db,$selectQuery),MYSQLI_ASSOC);
		echo json_encode($data);

	} catch (Exception $e) {
		echo $e->getMessage();	
		echo mysqli_error($db);
	}
?>