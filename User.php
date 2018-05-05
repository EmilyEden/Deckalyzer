<?php

class User {
	public $loginID = '';
	public $userID = 0;
	
	public function load($loginID, $mysqli) {
		$this->clear();
	
		if (! $mysqli) {
			return false;
		}
		
		$loginIDEscaped = $mysqli->real_escape_string($loginID);
	
		$sql = "SELECT * FROM users WHERE loginID = '$loginIDEscaped'";
		
		if ($result = $mysqli->query($sql))
		{
			if ($result->num_rows > 0)
			{
				$user = $result->fetch_assoc();
				$this->loginID = $user['loginID'];
				$this->userID = $user['id'];
			}
			$result->close();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function clear()
	{
		$loginID = '';
		$userID = 0;
	}
}

?>
