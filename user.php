<?php

class user {
	public $userName = '';
	public $userID = 0;
	
	public function load($userID, $mysqli)
	{
		$this->clear();
	
		if (! $mysqli)
		{
			return false;
		}
		
		$userIDEscaped = $mysqli->real_escape_string($userID);
	
		$sql = "SELECT * FROM users WHERE id = '$userIDEscaped'";
		
		if ($result = $mysqli->query($sql))
		{
			if ($result->num_rows > 0)
			{
				$user = $result->fetch_assoc();
				$this->userName = $user['userName'];
				$this->userID = $user['userID'];
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
