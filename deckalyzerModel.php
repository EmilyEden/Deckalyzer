<?php
	/**
	 *
	 */
	class Model{
		private $error = '';
		private $mysqli;
		private $user;

		function __construct(argument){
			this->connectToDB();
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

			if(!$this->user){
				$this->error = "No user specified. Could not add card";
				return $this->error;
			}

			$name = $data['name'];
			// $quantity = $data['$quantity'];
			// $forTrade = $data['forTrade'];

			if(!$name){
				$this->error = "No card name specified. Could not add card";
				return $this->error;
			}

			$nameEscaped = $this->mysqli->real_escape_string($name);
			$userIDEscaped = $this->mysqli->real_escape_string($this->user->userID);
			// $quantityEscaped = $this->mysqli->real_escape_string($quantity);
			// $forTradeEscaped = $this->mysqli->real_escape_string($forTrade);

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
		}

		public function editCard(){
			$this->error = '';
		}

		public function deleteCard(){
			$this->error = '';
		}
	}

?>
