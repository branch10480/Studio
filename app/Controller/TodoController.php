<?php

class TodoController extends AppController {


	// public $components = array('DebugKit.Toolbar');		// デバッグコンポーネント
	public $components = array('MyAuth', 'RequestHandler');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account', 'Post', 'Comment', 'Friend', 'Target', 'MyTarget', 'Studylog', 'Studytime', 'Todo');				// 使用するモデル
	public $read_limit = 10;


	public function beforeFilter() {

		// ログイン認証回避
		$allowArr = array(
			'dammy'
			);
		if ($this->MyAuth->allowAuth($this->action, $this->Session->check('Auth'), $allowArr)) {
			$this->redirect(array('controller' => 'home', 'action' => 'index'));
		}
	}

	public function index() {
		$this->set('title_for_layout', ' | Todoリスト');
	}



	/**
	* Todoリストデータ取得 - Ajax
	*/
	public function getTodo() {
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$dateArr = array();
				$result;

				$dateArr[] = $_POST['year'];
				$dateArr[] = sprintf('%02d', $_POST['month']);
				$dateArr[] = sprintf('%02d', $_POST['day']);
				$date = implode('-', $dateArr);

				if (isset($_POST['target_id'])) {
					// Todoリストウィンドウ側からのリクエスト
					$params = array(
					'conditions' => array(
						'Todo.account_id' => $loginId,
						'Todo.date' => $date,
						'Todo.target_id' => $_POST['target_id']
						), //検索条件の配列
					'recursive' => 1, //int
					// 'fields' => array('Model.field1', 'DISTINCT Model.field2'), //フィールド名の配列
					'order' => array('Todo.target_id ASC'), //並び順を文字列または配列で指定
					// 'group' => array('Model.field'), //GROUP BYのフィールド
					// 'limit' => $this->read_limit, //int
					// 'page' => 1, //int
					// 'offset' => n, //int
					// 'callbacks' => true //falseの他に'before'、'after'を指定できます
					);
				} else {
					// 勉強の記録を見るページからのリクエスト
					$params = array(
					'conditions' => array(
						'Todo.account_id' => $loginId,
						'Todo.date' => $date
						), //検索条件の配列
					'recursive' => 1, //int
					// 'fields' => array('Model.field1', 'DISTINCT Model.field2'), //フィールド名の配列
					'order' => array('Todo.target_id ASC'), //並び順を文字列または配列で指定
					// 'group' => array('Model.field'), //GROUP BYのフィールド
					// 'limit' => $this->read_limit, //int
					// 'page' => 1, //int
					// 'offset' => n, //int
					// 'callbacks' => true //falseの他に'before'、'after'を指定できます
					);
				}
				$result = $this->Todo->find('all', $params);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}


	/**
	* Todoの登録
	*/
	public function registerTodo() {
		$result = array();
		$result[] = 'false';
		// if ($this->RequestHandler->isAjax()) {
		// 	// 正常処理
		// 	if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$dateArr = array();
				$target_id = $_POST['target_id'];
				$todoText = $_POST['text'];
				$rand = $_POST['rand'];

				$dateArr[] = $_POST['year'];
				$dateArr[] = sprintf('%02d', $_POST['month']);
				$dateArr[] = sprintf('%02d', $_POST['day']);
				$date = implode('-', $dateArr);

				$data = array(
						'Todo' => array(
							'account_id' => $loginId,
							'date' => $date,
							'target_id' => $target_id,
							'text' => $todoText,
							'tmp' => $rand
							)
						);
				if ($this->Todo->saveAll($data)) {
					$result[0] = 'true';
				}

				// 上で挿入したtodoのidを取得
				$query = 'SELECT ';
				$query .= ' Todo.id ';
				$query .= 'FROM ';
				$query .= ' todo AS Todo ';
				$query .= 'WHERE ';
				$query .= ' Todo.tmp = ' . $rand . ' ';
				$query .= '  ';
				$result[] = $this->Todo->query($query);
		// 	}
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}


	public function check() {
		$result = 'false';
		// if ($this->RequestHandler->isAjax()) {
		// 	// 正常処理
		// 	if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$todo_id = $_POST['id'];

				$data = array(
						'Todo' => array(
							'id' => $todo_id,
							'done' => '1'
							)
						);
				if ($this->Todo->save($data)) {
					$result = 'true';
				}
		// 	}
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}


	public function uncheck() {
		$result = 'false';
		// if ($this->RequestHandler->isAjax()) {
		// 	// 正常処理
		// 	if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$todo_id = $_POST['id'];

				$data = array(
						'Todo' => array(
							'id' => $todo_id,
							'done' => '0'
							)
						);
				if ($this->Todo->save($data)) {
					$result = 'true';
				}
		// 	}
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}


	public function alter() {
		$result = 'false';
		// if ($this->RequestHandler->isAjax()) {
		// 	// 正常処理
		// 	if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$todo_id = $_POST['todo_id'];
				$text = $_POST['text'];

				$data = array(
						'Todo' => array(
							'id' => $todo_id,
							'text' => $text
							)
						);
				if ($this->Todo->save($data)) {
					$result = 'true';
				}
		// 	}
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}
}
