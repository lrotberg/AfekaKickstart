<?php
	session_start();
	if (!isset($_SESSION['id'])) {
		die(json_encode(array('status'	=>	'bad','message'	=>	'Please login to continue')));
	}
	$db = mysqli_connect("127.0.0.1", "root", "", "afekakickstart");
	if ($_POST['action'] === 'donate') {
		$pid = $_POST['pid'];
		$donator_id = $_SESSION['id'];
		$amount = $_POST['pamount'];
		$insertDonation = "INSERT INTO `donation`(`project_id`, `donator_id`, `date`, `amount`) 
						VALUES('$pid', '$donator_id', NOW() , '$amount')";
		$data = mysqli_query($db, $insertDonation);
		if (mysqli_insert_id($db) > 0) {
			$array = array('status' => 'ok', 'data' => mysqli_insert_id($db));
		}
		else {
			$array = array('status' => 'bad', 'message' => 'Some error occured');
		}
	}
	echo json_encode($array);
?>