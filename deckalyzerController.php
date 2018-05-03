<?php
	require('cardModel.php');
	require('cardViews.php');

	class TasksController {
		private $model;
		private $views;
		
		private $orderBy = '';
		private $view = '';
		private $action = '';
		private $message = '';
		private $data = array();
	
		public function __construct() {
			$this->model = new cardModel();
			$this->views = new cardViews();
			
			$this->view = $_GET['view'] ? $_GET['view'] : 'cardlist';
			$this->action = $_POST['action'];
		}
		
		public function __destruct() {
			$this->model = null;
			$this->views = null;
		}
		
		public function run() {
			if ($error = $this->model->getError()) {
				print $views->errorView($error);
				exit;
			}
			
			$this->processOrderBy();

			switch($this->action) {
				case 'delete':
					$this->handleDelete();
					break;
				case 'set_completed':
					$this->handleSetCompletionStatus('completed');
					break;
				case 'set_not_completed':
					$this->handleSetCompletionStatus('not completed');
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
				
			}
			
			switch($this->view) {
				case 'cardform':
					print $this->views->cardFormView($this->data, $this->message);
					break;
				default: // 'tasklist'
					list($orderBy, $orderDirection) = $this->model->getOrdering();
					list($cards, $error) = $this->model->getCards();
					if ($error) {
						$this->message = $error;
					}
					print $this->views->cardListView($tasks, $orderBy, $orderDirection, $this->message);
			}
		
		}
		
		private function processOrderby() {
			if ($_GET['orderby']) {
				$this->model->toggleOrder($_GET['orderby']);
			}			
		}
		
		private function handleDelete() {
			if ($error = $this->model->deleteTask($_POST['id'])) {
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
			list($task, $error) = $this->model->getTask($_POST['id']);
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
			
			if ($error = $this->model->updateTask($_POST)) {
				$this->message = $error;
				$this->view = 'cardform';
				$this->data = $_POST;
				return;
			}
			
			$this->view = 'cardlist';
		}
	
	}
	
	
?>