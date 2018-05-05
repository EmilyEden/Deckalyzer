<?php

class user {
	public $userName = '';
	public $userID = 0;
	
	public function load($userName, $mysqli)
	{
		$this->clear();
	
		if (! $mysqli)
		{
			return false;
		}
		
		$loginIDEscaped = $mysqli->real_escape_string($userName);
	
		$sql = "SELECT * FROM users WHERE loginID = '$userNameEscaped'";
		
		if ($result = $mysqli->query($sql))
		{
			if ($result->num_rows > 0)
			{
				$user = $result->fetch_assoc();
				$this->userName = $user['userName'];
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
