<?php

class TargetController extends AppController {


	public $components = array('MyAuth', 'RequestHandler');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account', 'Post', 'Comment', 'Friend', 'Target', 'Mytarget', 'Studylog', 'Studytime');				// 使用するモデル
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
		$this->set('title_for_layout', ' | 目標');
	}



	/**
	* 新しい目標を取得
	*/
	public function searchNewTargets() {
		$result = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$keyword = $_POST['keyword'];

				// 副問い合わせ
				$subQuery = "SELECT ";
				$subQuery .= " Mytarget.target_id ";
				$subQuery .= "FROM ";
				$subQuery .= " mytargets AS Mytarget ";
				$subQuery .= "JOIN ";
				$subQuery .= " targets AS Target ";
				$subQuery .= " ON ";
				$subQuery .= " Mytarget.target_id = Target.id ";
				$subQuery .= "WHERE ";
				$subQuery .= " Mytarget.account_id = " . $loginId . " ";
				$subQuery .= "  ";
				$subQuery .= "  ";
				// $subQuery .= 'AND ';
				// $subQuery .= ' Target. ';
				// $subQuery .= '  ';
				// $subQuery .= '  ';
				$subQuery .= '  ';

				// 主問い合わせ
				$query = 'SELECT ';
				$query .= ' * ';
				$query .= 'FROM ';
				$query .= ' targets AS Target ';
				$query .= 'WHERE ';
				$query .= ' Target.id NOT IN (' . $subQuery . ') ';
				$query .= "AND ";
				$query .= " Target.name LIKE '%" . $keyword . "%' ";
				$query .= '  ';
				$result = $this->Post->query($query);
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	/**
	* 目標を格納
	*/
	public function registerNewTarget() {
		$result = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$targetId = $_POST['target_id'];

				// 副問い合わせ
				$query = "INSERT INTO ";
				$query .= " mytargets (account_id, target_id) ";
				$query .= "VALUES (" . $loginId . ", " . $targetId . ")  ";
				$query .= "  ";
				$result = $this->Target->query($query) ? 'true' : 'false';
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function getMyTarget() {
		$result = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');

				// 副問い合わせ
				$query = "SELECT ";
				$query .= " * ";
				$query .= "FROM ";
				$query .= " mytargets AS MyTarget ";
				$query .= "JOIN ";
				$query .= " targets AS Target ";
				$query .= " ON ";
				$query .= " MyTarget.target_id = Target.id ";
				$query .= "WHERE ";
				$query .= " MyTarget.account_id = " . $loginId . " ";
				$result = $this->Mytarget->query($query);
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function getMyTargetCountdown() {
		$result = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');

				// 副問い合わせ
				$query = "SELECT ";
				$query .= " name, to_days(Target.date) - to_days(now()) as days ";
				$query .= "FROM ";
				$query .= " mytargets AS MyTarget ";
				$query .= "JOIN ";
				$query .= " targets AS Target ";
				$query .= " ON ";
				$query .= " MyTarget.target_id = Target.id ";
				$query .= "WHERE ";
				$query .= " MyTarget.account_id = " . $loginId . " ";
				$query .= "HAVING ";
				$query .= " days >= 0 ";
				$result = $this->Mytarget->query($query);
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function removeTarget() {
		$result = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$targetId = $_POST['target_id'];

				$query = "DELETE FROM ";
				$query .= " mytargets ";
				$query .= "WHERE ";
				$query .= " account_id = " . $loginId . " ";
				$query .= "AND ";
				$query .= " target_id = " . $targetId . " ";
				$result = $this->Mytarget->query($query) ? 'true' : 'false';
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}
}
