<?php
	
	
	class DB_Operations{
		
		private $con;
			
		function __construct(){
			require_once 'DB_Connect.php'; 
			$db = new DB_Connect();
			$this->con = $db->connect();
		}
		
		public function createUser($username,$email,$password){
			if ($this->isUserExist($username, $email)){
				return 0;
			}
			else{
				$pass = md5($password);
				$stmt = $this->con->prepare("INSERT INTO `user` (`ID`, `name`, `email`, `password`) VALUES (NULL, ?, ?, ?);");
				$stmt->bind_param("sss",$username, $email, $pass);
				if($stmt->execute()){
					return 1;
				}
				else{
					return 2;
				}
			}
		}
		
		function joinEvent($USER_ID, $id){
            $stmt = $this->con->prepare("INSERT INTO `event_user` (`id`, `user_id`, `event_id`) VALUES (NULL, ?, ?);");
            $stmt->bind_param("ii", $USER_ID, $id);
            if($stmt->execute()){
                return 1;
            }
            else{
                return 2;
            }
        }
		
		function isUserInEvent($USER_ID, $EVENT_ID){
			$stmt = $this->con->prepare("SELECT id FROM event_user WHERE user_id = ? AND event_id = ?;");
			$stmt->bind_param("ss",$USER_ID, $EVENT_ID);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		
		function createEvent($name,$place,$date, $start_time){
			if ($this->isEventExist($name)){
				return 0;
			}
			else{
				$stmt = $this->con->prepare("INSERT INTO `event` (`id`, `name`, `place`, `date`, `start_time`) VALUES (NULL, ?, ?, ?, ?);");
				$stmt->bind_param("ssss",$name, $place, $date, $start_time);
				if($stmt->execute()){
					return 1;
				}
				else{
					return 2;
				}
			}
		}
		
		public function userLogin($email, $pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM user WHERE email = ? AND password = ?;");
			$stmt->bind_param("ss",$email, $password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		
		public function getUserByEmail($email){
			$stmt = $this->con->prepare("SELECT * FROM user WHERE email = ?;");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
		
		public function getEventByName($name){
			$stmt = $this->con->prepare("SELECT * FROM event WHERE name = ?;");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
		
		private function isUserExist($username, $email){
			$stmt = $this->con->prepare("SELECT id FROM user WHERE name = ? OR email = ?;");
			$stmt->bind_param("ss", $username, $email);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
		
		private function isEventExist($name){
			$stmt = $this->con->prepare("SELECT id FROM event WHERE name = ?;");
			$stmt->bind_param("s", $name);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}
			
	}	