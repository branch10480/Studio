<?php

class summaryController extends AppController {


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
	* 今日のまとめ登録処理 - Ajax
	*/
	public function registerSummary() {
		$result = 'false';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {

				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$studytime_data = explode(',', $_POST['studytime_data']);	// 勉強時間データ: 目標ID-勉強時間
				$text = $_POST['reflection'];				// 反省、感想
				$studylog_id = '';

				// 今日の日付のデータがあるかどうかを確認
				$date = date('Y') . '-' . date('m') . '-' . date('d');
				$params = array(
					'conditions' => array(
						'Studylog.account_id' => $loginId,
						'Studylog.date' => $date
						)
					);
				if ($this->Studylog->find('count', $params) == 0) {
					// 勉強ログにデータを格納
					$data = array(
						'Studylog' => array(
							'account_id' => $loginId,
							'date' => $date,
							'text' => $text
							)
						);
					$result = $this->Studylog->save($data) ? 'true': 'fail';
					// studylog_idの取得
					$query = "SELECT ";
					$query .= " Studylog.id ";
					$query .= "FROM ";
					$query .= " studylogs AS Studylog ";
					$query .= "WHERE ";
					$query .= " Studylog.date = '" . $date . "'";
					$query .= "AND ";
					$query .= " Studylog.account_id = '" . $loginId . "'";
					// print_r($this->Studylog->query($query));
					$tmpArr = $this->Studylog->query($query);
					$studylog_id = $tmpArr[0]['Studylog']['id'];

					// 勉強時間の格納
					for ($i=0; $i<count($studytime_data); $i++) {
						$target_id;
						$time;
						list($target_id, $time) = explode('-', $studytime_data[$i]);

						$data = array(
							'Studytime' => array(
								'studylog_id' => $studylog_id,
								'target_id' => $target_id,
								'time' => $time*60
								)
							);
						$this->Studytime->save($data);
					}
				} else {
					$result = 'already';
				}
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function getTargetData() {
		$result = 'false';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');

				$sql = "SELECT ";
				$sql .= " Target.name, Target.id ";
				$sql .= "From ";
				$sql .= " accounts AS Account ";
				$sql .= "JOIN ";
				$sql .= " mytargets AS Mytarget ";
				$sql .= "ON ";
				$sql .= " Account.id = Mytarget.account_id ";
				$sql .= "JOIN ";
				$sql .= " targets AS Target ";
				$sql .= "ON ";
				$sql .= " Mytarget.target_id = Target.id ";
				$sql .= "WHERE ";
				$sql .= " Account.id = " . $loginId . " ";
				$sql .= "  ";

				$result = $this->Account->query($sql);

			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function getStudytime() {
		$result = 'false';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$targetId = $_POST['target_id'];
				$date = $_POST['year'] . '-' . sprintf('%02d', $_POST['month']) . '-' . sprintf('%02d', $_POST['day']);

				$params = array(
					'conditions' => array(
						'Studylog.account_id' => $loginId,
						'Studylog.date' => $date,
						'Studytime.target_id' => $targetId
						)
					);

				$result = $this->Studytime->find('all', $params);

			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}
}
