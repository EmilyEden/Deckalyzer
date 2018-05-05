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

			$this->view = $_GET['view'] ? $_GET['view'] : 'loginform';
			$this->action = $_POST['action'];
		}

		public function __destruct() {
			$this->model = null;
			$this->views = null;
		}

      public function run(){

			switch($this->action) {
				case 'delete':
					$this->handleDelete();
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
				case 'login':
					$this->handleLogin();
					break;

			}

			switch($this->view) {
				case 'loginform':
					print $this->views->loginFormView($this->data, $this->message);
					break;
				case 'cardform':
					print $this->views->cardFormView($this->model->getUser(), $this->data, $this->message);
					break;
				default: // 'cardlist'
					//list($orderBy, $orderDirection) = $this->model->getOrdering();
					list($cards, $error) = $this->model->getCardCollection(this->model->getUser());
					if ($error) {
						$this->message = $error;
					}
					print $this->views->cardListView($this->model->getUser(), $cards, $orderBy, $orderDirection, $this->message);
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

		private function handleDelete() {
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

			$error = $this->model->addCard($this->model->getuser(),$_POST);
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

			if ($error = $this->model->updateCard($_POST)) {
				$this->message = $error;
				$this->view = 'cardform';
				$this->data = $_POST;
				return;
			}

			$this->view = 'cardlist';
		}
	}
?>
