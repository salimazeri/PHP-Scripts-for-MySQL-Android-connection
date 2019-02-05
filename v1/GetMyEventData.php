<?php

require_once '../include/DB_Connect.php';

$db = new DB_Connect();
$con = $db->connect();
$myeventinfo = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['user_id'])){
		$user_id = $_POST['user_id'];
		$stmt = $con->prepare("select event_id, name, place, date, start_time from event_user, event where event_user.user_id = ? and event_user.event_id = event.id
		;");
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$stmt->bind_result($event_id, $name, $place, $date, $start_time);

		
 
		while($stmt->fetch()){
			$temp = array();
			$temp['id']=$event_id;
			$temp['name']=$name;
			$temp['place']=$place;
			$temp['date']=$date;
			$temp['start_time']=$start_time;
			array_push($myeventinfo, $temp);
		}
		
	
	}
}
echo json_encode($myeventinfo);

