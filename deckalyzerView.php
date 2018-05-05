<?php


		class deckalyzerView{
			private $stylesheet = 'deckalyzer.css';
			private $pageTitle = 'Cards';

			public function __construct()
			{

			}

			public function __destruct()
			{

			}

			public function cardListView($cards, $decks, $orderBy = 'cardName', $orderDirection = 'asc', $message = '')
			{
				$body = "<h1>Cards</h1>\n";

				if ($message)
				{
					$body .= "<p class ='message'>$message</p>\n";
				}

				$body .= "<p><a class='taskButton' href='index.php?view=cardform'>+ Add Card</a>";
				$body .= "<p><a class='taskButton' href='index.php?view=deckform'>+ Add Deck</a></p>\n";

				if (count($cards) < 1)
				{
					$body .= "<p>You don't have cards! You can fix that by clicking +Add Card. Or don't. Whatever.</p>\n";
					return $body;
				}

				$body .= "<span><table>\n";
				$body .= "<tr><th>Delete</th><th>Edit</th>";

				$columns = array(array('name' => 'cardName', 'label' => 'Card Name'));

				foreach ($columns as $column)
				{
					$name = $column['name'];
					$label = $column['label'];
					if ($name == $orderBy)
					{
						if ($orderDirection == 'asc')
						{
							$label .= " &#x25BC;";
						}
						else
						{
							$label .= " &#x25B2;";
						}
					}
					$body .= "<th><a class='order' href='index.php?orderby=$name'>$label</a></th>";
				}

				foreach($cards as $card)
				{
					$id = $card['id'];
					$cardName = $card['name'];


					$body .= "<tr>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='edit' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
					$body .= "<td>$cardName</td>";
					$body .= "</tr>\n";
                }
			$body .= "</table></span>\n";
			
			$body .= "<span><table>\n";
			$body .= "<tr><th>Delete</th><th>Edit</th>";
			
			$columns = array(array('name' => 'deckName', 'label' => 'Deck Name'));
			
			foreach ($columns as $column)
				{
					$name = $column['name'];
					$label = $column['label'];
					if ($name == $orderBy)
					{
						if ($orderDirection == 'asc')
						{
							$label .= " &#x25BC;";
						}
						else
						{
							$label .= " &#x25B2;";
						}
					}
					$body .= "<th><a class='order' href='index.php?orderby=$name'>$label</a></th>";
				}
				
			foreach($decks as $deck)
				{
					$id = $deck['id'];
					$deckName = $deck['name'];


					$body .= "<tr>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='deleteD' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
					$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='editD' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
					$body .= "<td>$deckName</td>";
					$body .= "</tr>\n";
                }
			
			
			
			$body .= "</table></span>\n";

			return $this->page($body);
		}

		public function cardFormView($data = null, $message = '')
		{
			$cardName = '';

			if($data)
			{
				$cardName = $data['cardName'];
			}

			$html = <<<EOT1
<!DOCTYPE html>
<html>
<head>
<title>Card Manager</title>
<link rel="stylesheet" type="text/css" href="deckalyzer.css">
</head>
<body>
<h1>Cards</h1>
EOT1;


			if($message)
			{
				$html .= "<p class='message'>$message</p>\n";
			}

			$html .= "<form action='index.php' method='post'>";

			if($data['id'])
			{
				$html .="<input type='hidden' name='action' value='update' />";
				$html .= "<input type='hidden' name='id' value='{$data['id']}' />";
			}
			else
			{
				$html .= "<input type='hidden' name='action' value='add' />";
			}

			$html .= <<<EOT2
	<p>Card Name<br />
	<input type="text" name="name" value="$name" placeholder="Card Name" maxlength="255" size="80"></p>
	<<input type="submit" name='submit' value="Submit">
</form>
</body>
</html>
EOT2;
			print $html;
		}
		
		
		public function deckFormView($data = null, $message = '')
		{
			$deckName = '';

			if($data)
			{
				$deckName = $data['deckName'];
			}

			$html = <<<EOT1
<!DOCTYPE html>
<html>
<head>
<title>Cards and Deck Manager</title>
<link rel="stylesheet" type="text/css" href="deckalyzer.css">
</head>
<body>
<h1>Cards and Decks</h1>
EOT1;


			if($message)
			{
				$html .= "<p class='message'>$message</p>\n";
			}

			$html .= "<form action='index.php' method='post'>";

			if($data['id'])
			{
				$html .="<input type='hidden' name='action' value='updateD' />";
				$html .= "<input type='hidden' name='id' value='{$data['id']}' />";
			}
			else
			{
				$html .= "<input type='hidden' name='action' value='addD' />";
			}

			$html .= <<<EOT2
	<p>Deck Name<br />
	<input type="text" name="name" value="$name" placeholder="Deck Name" maxlength="255" size="80"></p>
	<input type="submit" name='submit' value="Submit">
</form>
</body>
</html>
EOT2;
			print $html;
		}

		private function page($body) {
			$html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>{$this->pageTitle}</title>
<link rel="stylesheet" type="text/css" href="{$this->stylesheet}">
</head>
<body>
$body
<p>&copy; 2018 Warren Allen, Emily Eden, and Luke Fisher. All rights reserved. Yeet.</p>
</body>
</html>
EOT;
			return $html;
		}



        }
