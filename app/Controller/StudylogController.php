<?php

class StudylogController extends AppController {


	// public $components = array('DebugKit.Toolbar');		// デバッグコンポーネント
	public $components = array('MyAuth', 'RequestHandler');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account', 'Post', 'Comment', 'Friend', 'Target', 'MyTarget', 'Studylog', 'Studytime');				// 使用するモデル
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
		$this->set('title_for_layout', ' | 勉強の記録');
	}



	/**
	* 勉強ログデータ取得 - Ajax
	*/
	public function getStudylog() {
		$result;
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				if (isset($_POST['userid'])) {
					$loginId = $_POST['userid'];
				}

				$year = $_POST['year'];
				$month = $_POST['month'];
				$daysInMonth = $_POST['dayCnt'];	// その月の日数
				$upperLimit = sprintf('%02d', $year) . '-' . sprintf('%02d', ($month+1)) . '-01';
				$lowerLimit = $year . '-' . sprintf('%02d', ($month+1)) . '-' . $daysInMonth;

				$params = array(
					'conditions' => array(
						'Studylog.account_id' => $loginId,
						'Studylog.date BETWEEN ? AND ?' => array( $upperLimit, $lowerLimit )
						), //検索条件の配列
					'recursive' => 1, //int
					// 'fields' => array('Model.field1', 'DISTINCT Model.field2'), //フィールド名の配列
					// 'order' => array('Post.post_datetime DESC'), //並び順を文字列または配列で指定
					// 'group' => array('Model.field'), //GROUP BYのフィールド
					// 'limit' => $this->read_limit, //int
					// 'page' => 1, //int
					// 'offset' => n, //int
					// 'callbacks' => true //falseの他に'before'、'after'を指定できます
					);
				$result = $this->Studylog->find('all', $params);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}



	/**
	* 勉強ログデータ取得 - Ajax
	*/
	public function getDoubleStudylog() {
		$result = array();
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$friendId = $_POST['friend_id'];

				$query = "SELECT ";
				$query .= " Studylog.date, SUM(Studytime.time) AS studytime ";
				$query .= "FROM ";
				$query .= " studylogs AS Studylog ";
				$query .= "JOIN ";
				$query .= " studytimes AS Studytime ";
				$query .= "ON ";
				$query .= " Studylog.id = Studytime.studylog_id ";
				$query .= "WHERE ";
				$query .= " Studylog.account_id = " . $loginId . " ";
				$query .= "AND ";
				$query .= " DATE_FORMAT(Studylog.date,'%Y%m') = '" . $_POST['year'] . sprintf('%02d', $_POST['month']) . "' ";
				$query .= "GROUP BY ";
				$query .= " Studylog.date ";
				$query .= "  ";
				$result[] = $this->Studytime->query($query);

				$query = "SELECT ";
				$query .= " Studylog.date, SUM(Studytime.time) AS studytime ";
				$query .= "FROM ";
				$query .= " studylogs AS Studylog ";
				$query .= "JOIN ";
				$query .= " studytimes AS Studytime ";
				$query .= "ON ";
				$query .= " Studylog.id = Studytime.studylog_id ";
				$query .= "WHERE ";
				$query .= " Studylog.account_id = " . $friendId . " ";
				$query .= "AND ";
				$query .= " DATE_FORMAT(Studylog.date,'%Y%m') = '" . $_POST['year'] . sprintf('%02d', $_POST['month']) . "' ";
				$query .= "GROUP BY ";
				$query .= " Studylog.date ";
				$query .= "  ";
				$result[] = $this->Studytime->query($query);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}



	/**
	* 勉強ログ詳細を取得 - Ajax
	*/
	public function getStudylogDetail() {
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$result;

				$id = $_POST['id'];

				$params = array(
					'conditions' => array(
						'Studytime.studylog_id' => $id
						), //検索条件の配列
					'recursive' => 1, //int
					// 'fields' => array('Model.field1', 'DISTINCT Model.field2'), //フィールド名の配列
					// 'order' => array('Post.post_datetime DESC'), //並び順を文字列または配列で指定
					// 'group' => array('Model.field'), //GROUP BYのフィールド
					// 'limit' => $this->read_limit, //int
					// 'page' => 1, //int
					// 'offset' => n, //int
					// 'callbacks' => true //falseの他に'before'、'after'を指定できます
					);
				$result = $this->Studytime->find('all', $params);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}



	/**
	* 月の勉強時間を取得
	*/
	public function getMonthStudytime() {
		$result = '';
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$userid = $this->Session->read('Auth.id');
				if (isset($_POST['userid'])) {
					$userid = $_POST['userid'];
				}

				$query = "SELECT ";
				$query .= " Studylog.date, SUM(Studytime.time) AS studytime ";
				$query .= "FROM ";
				$query .= " studylogs AS Studylog ";
				$query .= "JOIN ";
				$query .= " studytimes AS Studytime ";
				$query .= "ON ";
				$query .= " Studylog.id = Studytime.studylog_id ";
				$query .= "WHERE ";
				$query .= " Studylog.account_id = " . $userid . " ";
				$query .= "AND ";
				$query .= " DATE_FORMAT(Studylog.date,'%Y%m') = '" . $_POST['year'] . sprintf('%02d', $_POST['month']) . "' ";
				$query .= "GROUP BY ";
				$query .= " Studylog.date ";
				$query .= "  ";
				$result = $this->Studytime->query($query);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}
}
