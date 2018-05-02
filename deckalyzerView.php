<?php
	
	
		class deckViews{
			private $stylesheet = 'deckalyzer.css';
			private $pageTitle = 'Cards';
			
			public function_construct()
			{
				
			}
			
			public function_destruct()
			{
				
			}
			
			public function cardListView($cards, $orderBy = 'cardName', $orderDirection = 'asc', $message = '')
			{
				$body = "<h1>Cards</h1>\n";
				
				if ($message)
				{
					$body .= "<p class ='message'>$message</p>\n";
				}
				
				$body .= "<p><a class='taskButton' href='index.php?view=taskform'>+ Add Card</a></p>\n";
				
				if (count($cards) < 1)
				{
					$body .= "<p>You don't have cards loser.</p>\n";
					return $body;
				}
				
				$body .= "<table>\n";
				$body .= "<tr><th>delete</th><th>for trade</th>";
				
				$columns = array(array('name' => 'cardName', 'label' => 'Card Name')
								 array('name' => 'wishlist', 'label' => 'Wishlist'));
								 
				
				
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
					$cardName = $card['cardName']
					$ownerId = $card['ownerId']
				}
				
				$body .= "<tr>";
				$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
				$body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='edit' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
				$body .= "</tr>\n";
			}
			$body .= "</table>\n";
			
			return $this->page($body);
		}
		
?>