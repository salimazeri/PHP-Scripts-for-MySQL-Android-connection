<?php

require_once '../include/DB_Operations.php';

$response = array();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['email']) AND isset($_POST['password'])){
		$db = new DB_Operations();
		if($db->userLogin($_POST['email'], $_POST['password'])){
			$user = $db->getUserByEmail($_POST['email']);
			$response['error'] = false;
			$response['message'] = 'Successful logging in';
			$response['ID'] = $user['ID'];
			$response['name'] = $user['name'];
			$response['email'] = $user['email'];
		}
		else{
			$response['error'] = true;
			$response['message'] = 'Invalid mail or password';
		}
	}
	else{
		$response['error'] = true;
		$response['message'] = 'Required fileds are missing';
	}
}

echo json_encode($response);