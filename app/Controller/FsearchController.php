<?php

class FsearchController extends AppController {


	public $components = array('MyAuth', 'RequestHandler');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account', 'Post', 'Comment', 'Friend', 'Target', 'MyTarget');				// 使用するモデル
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

	public function afterFileter() {
		// デバッグ用にSQL文表示
		$sqlLog = $this->Account->getDataSource()->getLog(false, false);
		debug($sqlLog , false);
	}

	public function index() {
		$this->set('title_for_layout', '');
	}



	/**
	* タイムライン内のデータをJsonにして表示 - Ajax
	*/
	public function getMoreFriendData() {
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$result;
				$pattern = $_POST['keyword'];
				$method = $_POST['method'];


				$query = '';
				if ($method == 'target_search') {
					/* 友達登録されていない、かつマイ目標を含むデータ群を取得 */
					// 副問い合わせ用
					$query .= "SELECT ";
					$query .= " Account.id ";
					$query .= "FROM ";
					$query .= " accounts AS Account ";
					$query .= "JOIN ";
					$query .= " mytargets AS Mytarget ";
					$query .= "ON ";
					$query .= " Account.id = Mytarget.account_id ";
					$query .= "JOIN ";
					$query .= " targets AS Target ";
					$query .= "ON ";
					$query .= " Mytarget.target_id = Target.id ";
					$query .= "WHERE ";
					$query .= " Target.name ";
					$query .= "LIKE '%" . $pattern . "%'";
					$query .= "  ";
				} else {
					/* 友達登録されていない、かつキーワードを含む名前を持ったアカウントを取得 */
					// 副問い合わせ用
					$query .= "SELECT ";
					$query .= " Account.id ";
					$query .= "FROM ";
					$query .= " accounts AS Account ";
					$query .= "JOIN ";
					$query .= " mytargets AS Mytarget ";
					$query .= "ON ";
					$query .= " Account.id = Mytarget.account_id ";
					$query .= "JOIN ";
					$query .= " targets AS Target ";
					$query .= "ON ";
					$query .= " Mytarget.target_id = Target.id ";
					$query .= "WHERE ";
					$query .= " Account.name ";
					$query .= "LIKE '%" . $pattern . "%'";
					$query .= "  ";
				}

				// 友達登録されているfriendIdを取得
				$friendQuery = 'SELECT ';
				$friendQuery .= ' Friend.account_id ';
				$friendQuery .= 'FROM ';
				$friendQuery .= ' friends AS Friend ';
				$friendQuery .= 'WHERE ';
				$friendQuery .= ' Friend.my_id = ' . $loginId . ' ';
				$friendQuery .= '  ';

				// 主処理（表示に使う項目のみ取得）
				$finalQuery = 'SELECT ';
				$finalQuery .= 'Account.id, Account.name, Account.studylog_count, Account.img_ext, Target.name ';
				$finalQuery .= "FROM ";
				$finalQuery .= " accounts AS Account ";
				$finalQuery .= "JOIN ";
				$finalQuery .= " mytargets AS Mytarget ";
				$finalQuery .= "ON ";
				$finalQuery .= " Account.id = Mytarget.account_id ";
				$finalQuery .= "JOIN ";
				$finalQuery .= " targets AS Target ";
				$finalQuery .= "ON ";
				$finalQuery .= " Mytarget.target_id = Target.id ";
				$finalQuery .= 'WHERE ';
				$finalQuery .= ' Account.id <> ' . $loginId . ' ';
				$finalQuery .= 'AND ';
				$finalQuery .= ' Account.id IN (' . $query . ') ';
				$finalQuery .= 'AND ';
				$finalQuery .= ' Account.id NOT IN (' . $friendQuery . ') ';
				$finalQuery .= ' ';

				$result = $this->Account->query($finalQuery);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}


	public function getProfile() {
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$result;

				$params = array(
					'conditions' => array(
						'Account.id' => $_POST['id']
						)
					);
				$result = $this->Account->find('first', $params);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}



	public function registerFriend() {
		$result = array();
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');

				// 重複チェック
				$params = array(
					'conditions' => array(
						'Friend.my_id' => $loginId,
						'Friend.account_id' => $_POST['newFriendId']
						)
					);
				if ($this->Friend->find('count', $params) == 0) {
					// 重複なし
					$data = array(
						'Friend' => array(
							'my_id' => $loginId,
							'account_id' => $_POST['newFriendId']
							)
						);
					$result[] = $this->Friend->save($data) ? 'success' : 'fail';
				} else {
					$result[] = 'duplicate';
				}
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'result' => $result
			));
	}



	public function unfollow() {
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$this->layout = 'ajax';
				$this->autoRender = false;
				$loginId = $this->Session->read('Auth.id');
				$unfollow_id = $_POST['unfollow_id'];

				// 重複チェック
				$params = array(
					'conditions' => array(
						'Friend.my_id' => $loginId,
						'Friend.account_id' => $unfollow_id
						),
					'fields' => array('Friend.id')
					);
				$result = $this->Friend->find('first', $params);
				$this->Friend->delete($result['Friend']['id']);
			}
		} else {
			// 不正処理
		}
	}
}
