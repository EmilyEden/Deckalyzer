<?php
	/**
	 *
	 */
	class deckalyzerModel{
		private $error = '';
		private $mysqli;
		private $user;

		public function __construct(){
			$this->connectToDB();
		}

		public function __destruct(){
			if ($this->mysqli){
				$this->mysqli->close();
			}
		}

		private function connectToDB(){
			require('DBCredentials.php');
			$this->mysqli = new mysqli($servername, $username, $password, $dbname);
			if ($this->mysqli->connect_error) {
				$this->error = $mysqli->connect_error;
			}
		}

		public function getUser() {
			return $this->user;
		}

		public function login($loginID, $password){

		}

		public function addCard($data){
			$this->error = '';

			// if(!$this->user){
			// 	$this->error = "No user specified. Could not add card";
			// 	return $this->error;
			// }

			$name = $data['name'];
			if(!$name){
				$this->error = "No card name specified. Could not add card";
				return $this->error;
			}

			$nameEscaped = $this->mysqli->real_escape_string($name);
			$userIDEscaped = $this->mysqli->real_escape_string(1);//THIS IS HARD CODED!!!!!!


			$sql = "INSERT INTO cards (name, ownerId) VALUES ('$nameEscaped', '$userIDEscaped')";

			if(!$result = $this->mysqli->query($sql)){
				$this->error = $this->mysqli->error;
			}

			return $this->error;
		}

		public function getCard(){
			$this->error = '';
		}

		public function getCardCollection(){
			$this->error = '';
			$cards = array();

			if (!$this->user) {
				$this->error = "User not specified. Unable to get cards.";
				return $this->error;
			}

			if (!$this->mysqli) {
				$this->error = "No connection to database. Could not get cards";
				return array($cards, $this->error);
			}

			$nameEscaped = $this->mysqli->real_escape_string($name);
			$userIDEscaped = $this->mysqli->real_escape_string(1);//THIS IS HARD CODED!!!!!!

			$sql = "SELECT * FROM cards WHERE userID = $userIDEscaped";
			if($result = $this->mysqli->query($sql)){
				if($result->num_rows > 0){
					while($row = $result->fetch_assoc()) {
						array_push($tcards, $row);
					}
				}
				$result->close();
			} else {
				$this->error = $mysqli->error;
			}

			return array($cards);
		}

		public function editCard(){
			$this->error = '';
		}

		public function deleteCard($id){
			$this->error = '';
			if (!$this->user){
				$this->error = "User not specified. Unable to delete card.";
				return $this->error;
			}

			if(!$this->mysqli){
				$this->error = "No connection to database. Unable to delete card.";
				return $this->error;
			}

			if(!$id){
				$this->error = "No id specified for card to delete.";
				return $this->error;
			}

			$idEscaped = $this->mysqli->real_escape_string($id);
			$userIDEscaped = $this->mysqli->real_escape_string($this->user->userID);
			$sql = "DELETE FROM cards WHERE ownerID = $userIDEscaped AND id = $idEscaped";

			if (!$result = $this->mysqli->query($sql)){
				$this->error = $this->mysqli->error;
			}
			
			return $this->error;
		}
}