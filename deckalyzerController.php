<?php
	require('deckalyzerModel.php');
	require('deckalyzerView.php');

	class deckalyzerController {
		private $model;
		private $views;

		private $orderBy = '';
		private $view = '';
		private $action = '';
		private $message = '';
		private $data = array();

		public function __construct() {
			$this->model = new deckalyzerModel();
			$this->views = new deckalyzerView();

			$this->view = $_GET['view'] ? $_GET['view'] : 'cardlist';
			$this->action = $_POST['action'];
		}

		public function __destruct() {
			$this->model = null;
			$this->views = null;
		}

      public function run(){

			switch($this->action) {
				case 'delete':
					$this->handleDeleteCard();
					break;
				case 'add':
					$this->handleAddCard();
					break;
				case 'edit':
					$this->handleEditCard();
					break;
				case 'update':
					$this->handleUpdateCard();
					break;

				case 'deleteD':
					$this->handleDeleteDeck();
					break;
				case 'addD':
					$this->handleAddDeck();
					break;
				case 'editD':
					$this->handleEditDeck();
					break;
				case 'updateD':
					$this->handleUpdateDeck();
					break;

			}

			switch($this->view) {
				case 'cardform':
					print $this->views->cardFormView($this->data, $this->message);
					break;
				case 'deckform':
					print $this->views->deckFormView($this->data, $this->message);
					break;
				case 'loginform':
					print $this->views->loginFormView($this->message);
					break;
				default: 
					list($cards, $error) = $this->model->getCardCollection();
					if ($error) {
						$this->message = $error;
					}
					//print $this->views->cardListView($cards, $orderBy, $orderDirection, $this->message);
					
					list($decks, $error) = $this->model->getDeckCollection();
					if($error)
					{
						$this->message = $error;	
					}
					print $this->views->cardListView($cards, $decks, $orderBy, $orderDirection, $this->message);
			}
		}

		private function handleLogin() {
			$userId = $_POST['userId'];

			list($success, $message) = $this->model->loadUser($userId);
			if ($success) {
				$this->view = 'cardList';
			} else {
				$this->message = $message;
				$this->view = 'loginform';
			}
		}

		private function handleDeleteCard() {
			if ($error = $this->model->deleteCard($_POST['id'])) {
				$this->message = $error;
			}
			$this->view = 'cardlist';
		}

		private function handleAddCard() {
			if ($_POST['cancel']) {
				$this->view = 'cardlist';
				return;
			}

			$error = $this->model->addCard($_POST);
			if ($error) {
				$this->message = $error;
				$this->view = 'cardform';
				$this->data = $_POST;
			}
		}

		private function handleEditCard() {
			list($task, $error) = $this->model->getCard($_POST['id']);
			if ($error) {
				$this->message = $error;
				$this->view = 'cardlist';
				return;
			}
			$this->data = $task;
			$this->view = 'cardform';
		}

		private function handleUpdateCard() {
			if ($_POST['cancel']) {
				$this->view = 'cardlist';
				return;
			}

			if ($error = $this->model->editCard($_POST)) {
				$this->message = $error;
				$this->view = 'cardform';
				$this->data = $_POST;
				return;
			}

			$this->view = 'cardlist';
		}

		//***************************************************************DECKS***************************************************

		private function handleDeleteDeck() {
			if ($error = $this->model->deleteCard($_POST['id'])) {
				$this->message = $error;
			}
			$this->view = 'cardlist';
		}

		private function handleAddDeck() {
			if ($_POST['cancel']) {
				$this->view = 'cardlist';
				return;
			}

			$error = $this->model->addDeck($_POST);
			if ($error) {
				$this->message = $error;
				$this->view = 'deckform';
				$this->data = $_POST;
			}
		}

		private function handleEditDeck() {
			list($task, $error) = $this->model->getDeck($_POST['id']);
			if ($error) {
				$this->message = $error;
				$this->view = 'cardlist';
				return;
			}
			$this->data = $task;
			$this->view = 'deckform';
		}

		private function handleUpdateDeck() {
			if ($_POST['cancel']) {
				$this->view = 'cardlist';
				return;
			}

			if ($error = $this->model->editDeck($_POST)) {
				$this->message = $error;
				$this->view = 'deckform';
				$this->data = $_POST;
				return;
			}

			$this->view = 'cardlist';
		}
	}
?>
