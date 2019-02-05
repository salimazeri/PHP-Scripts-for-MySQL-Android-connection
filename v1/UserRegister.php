<?php
 
require_once '../include/DB_Operations.php';

$response = array();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['password'])){
		$db = new DB_Operations();
		
		$result = $db->createUser($_POST['name'], $_POST['email'], $_POST['password']);
		if($result == 1){
			$response['error'] = false;
			$response['message'] = "User registered successfully";
		}
		elseif($result == 2){
			$response['error'] = true;
			$response['message'] = 'Some error occured, please try again';
		}
		elseif($result == 0){
			$response['error'] = true;
			$response['message'] = 'User already registered';
		}
	}
	else{
		$response['error'] = true;
		$response['message'] = 'Required fileds are missing';
	}
}
else{
	$response['error'] = true;
	$response['message'] = "Invalid request";
}

echo json_encode($response);