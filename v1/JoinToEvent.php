<?php

require_once '../include/DB_Operations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['USER_ID']) AND isset($_POST['id'])){
        $db = new DB_Operations();
		if($db->isUserInEvent($_POST['USER_ID'], $_POST['id'])){
			$response['error'] = false;
			$response['message'] = "User has already joined the event";
		} else{
			$result = $db->joinEvent($_POST['USER_ID'], $_POST['id']);
			if ($result == 1){
				$response['error'] = false;
				$response['message'] = "User joined to event successfully";
			}
			elseif ($result == 2){
				$response['error'] = true;
				$response['message'] = "Some error occured, please try again";
			}
		}
    }
}

echo json_encode($response);