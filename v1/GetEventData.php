<?php

require_once '../include/DB_Connect.php';

$db = new DB_Connect();
$con = $db->connect();

$stmt = $con->prepare("select id, name, place, date, start_time from event;");
$stmt->execute();
$stmt->bind_result($id, $name, $place, $date, $start_time);

$eventinfo = array();
 
while($stmt->fetch()){
	$temp = array();
	$temp['id']=$id;
	$temp['name']=$name;
	$temp['place']=$place;
	$temp['date']=$date;
	$temp['start_time']=$start_time;
	array_push($eventinfo, $temp);
}

echo json_encode($eventinfo);

