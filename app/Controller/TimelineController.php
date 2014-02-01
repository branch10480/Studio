<?php

class TimelineController extends AppController {


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
		$this->set('title_for_layout', '');
	}



	/**
	* タイムライン内のデータをJsonにして表示 - Ajax
	*/
	public function getTimelineData() {
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$loginId = $this->Session->read('Auth.id');
				$resultArr;


				// 友人のid 取得
				$params = array(
					'conditions' => array('Friend.my_id' => $loginId),
					'fields' => array('Friend.account_id')
					);
				$friendId = $this->Friend->find('all', $params);
				$friendIdArr = array();
				for ($i=0; $i<count($friendId); $i++) {
					$friendIdArr[] = $friendId[$i]['Friend']['account_id'];
				}
				// 自分のid も加える
				$friendIdArr[] = $this->Session->read('Auth.id');



				$maxPostId = $_POST['max_postid'];
				$params = array(
					'conditions' => array(
						'Post.account_id' => $friendIdArr,
						'Post.id >' => $maxPostId
						), //検索条件の配列
					'recursive' => 1, //int
					// 'fields' => array('Model.field1', 'DISTINCT Model.field2'), //フィールド名の配列
					'order' => array('Post.post_datetime DESC'), //並び順を文字列または配列で指定
					// 'group' => array('Model.field'), //GROUP BYのフィールド
					'limit' => $this->read_limit, //int
					'page' => 1, //int
					// 'offset' => n, //int
					// 'callbacks' => true //falseの他に'before'、'after'を指定できます
					);
				$resultArr = $this->Post->find('all', $params);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'resultArr' => $resultArr
			));
	}



	/**
	* 資格情報取得
	*/
	public function getTargetData() {
		$result = array();
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$this->layout = 'ajax';
				$account_id = $_POST['account_id'];

				// ポストID格納
				if (isset($_POST['post_id'])) {
					$result[] = $_POST['post_id'];
				} else {
					$result[] = 'some';
				}


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
				$sql .= " Account.id = " . $account_id . " ";
				$sql .= "  ";
				$result[] = $this->Account->query($sql);

				$this->set(array(
					'result' => $result
					));
			// }
		// } else {
		// 	// 不正処理
		// }
	}



	/**
	* 送られてきたPostIdに対応するコメントをJsonで表示 - Ajax
	*/
	public function getComment() {
		$this->layout = 'ajax';
		$resultArr = array();
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				$params = array(
					'conditions' => array('Comment.post_id' => $_POST['post_id']), //検索条件の配列
					'recursive' => 1, //int
					// 'fields' => array('Model.field1', 'DISTINCT Model.field2'), //フィールド名の配列
					'order' => array('Comment.post_datetime ASC'), //並び順を文字列または配列で指定
					// 'group' => array('Model.field'), //GROUP BYのフィールド
					// 'limit' => $this->read_limit, //int
					'page' => 1, //int
					// 'offset' => n, //int
					// 'callbacks' => true //falseの他に'before'、'after'を指定できます
					);
				$resultArr[] = $this->Comment->find('all', $params);
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'resultArr' => $resultArr
			));
	}


	/**
	* 投稿処理 - Ajax
	*/
	function post() {
		$this->layout = 'ajax';
		$result = array();
		// if ($this->RequestHandler->isAjax()) {
			// 正常処理
			// if ($this->request->is('post')) {
				// $mailaddress = $_POST['id'];
				// ----------------------------------------------------------------------------------

				// 15秒止める
				// sleep(15);

				// 画像ファイルの保存 & ディレクトリの移動

				$up_dir = '../webroot/img/images/';							// 保存先の相対パス
				$filename = $_FILES['up_img']['name'];
				$filetype = $_FILES['up_img']['type'];
				$filesize = $_FILES['up_img']['size'];
				$tmpfile = $_FILES['up_img']['tmp_name'];	// 一時的に保管
				$msg = '';
				$flg = true;								// エラーがあるか無いか
				$img_flg = '0';
				$completeFlg = 'false';
				$rand = mt_rand();
				$img_exp = 'NULL';
				$lastName = '';


				// 仮投稿 - 後で置き換える
				$data = array(
					'Post' => array(
						'tmp' => $rand
						)
					);
				$this->Post->saveAll($data);


				// 乱数をもとに、post_id を取得
				$params = array(
					'conditions' => array(
						'Post.tmp' => $rand
						),
					'fields' => array(
						'Post.id'
						)
					);
				$tmpData = $this->Post->find('first', $params);
				$tmpId = $tmpData['Post']['id'];





				/* ファイルが選択されたかを判断 */
				if (is_uploaded_file($tmpfile)) {
					// ファイル名の分割
					list($firstName, $lastName) = explode('.', $filename);
					$newFileName = $tmpId . '.' . $lastName;
					$uppath = $up_dir . $newFileName;				// アップロード先のファイルパス

					// ファイルが選択されている場合
					if (move_uploaded_file($tmpfile, $uppath)) {

						/* 画像ファイルかどうかの判断 */
						$fileinfo = getimagesize($uppath);
						if ($fileinfo[2] != IMAGETYPE_GIF && $fileinfo[2] != IMAGETYPE_JPEG && $fileinfo[2] != IMAGETYPE_PNG) {

							// ファイルの削除
							unlink($uppath);
							$msg = '画像以外のファイルが選択されました。';
							$flg = false;
						} else {
							// 正常
							// 拡張子の前に . を付ける
							$lastName = '.' . $lastName;
							$img_ext = "'" . $lastName . "'";
						}
					} else {
						$msg = '移動できませんでした。';
						$flg = false;
					}
				} else {
					// ファイルが選択されていない場合
					$msg = 'ファイルが選択されていませんでした。';
				}


				// データベースに格納処理
				if ($flg) {
					$data = array(
						'Post.account_id' => $this->Session->read('Auth.id'),
						'Post.text' => "'" . $_POST['postText'] . "'",
						'Post.img_ext' => $img_ext
						);
					$conditions = array(
							'Post.id' => $tmpId
							);
					if ($this->Post->updateAll($data, $conditions)) {
						$completeFlg = 'true';
					}
				} else {

				}


				// ----------------------------------------------------------------------------------
			// }
		// } else {
		// 	// 不正処理
		// }
		$this->set(array(
			'completeFlg' => $completeFlg
			));
	}



	public function getFriendData() {
		$this->layout = 'ajax';
		$result = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$loginId = $this->Session->read('Auth.id');
				$date = $_POST['year'] . '-' . sprintf('%02d', $_POST['month']) . '-' . sprintf('%02d', $_POST['day']);

				// 副問い合わせ
				// 友達登録してあるユーザIDを取得
				$query = ' SELECT ';
				$query .= ' Friend.account_id ';
				$query .= 'FROM ';
				$query .= ' friends AS Friend ';
				$query .= 'WHERE ';
				$query .= ' Friend.my_id = ' . $loginId . ' ';
				$query .= '  ';

				// 主文
				// $query = "SELECT ";
				// $query .= " * ";
				// $query .= "FROM ";
				// $query .= " studylogs AS Studylog ";
				// $query .= "JOIN ";
				// $query .= " studytimes AS Studytime ";
				// $query .= "ON ";
				// $query .= " Studylog.id = Studytime.studylog_id ";
				// $query .= "JOIN ";
				// $query .= " accounts AS Account ";
				// $query .= "ON ";
				// $query .= " Studylog.account_id = Account.id ";
				// $query .= "WHERE ";
				// $query .= " Studylog.date = '" . $date . "' ";
				// $query .= "AND ";
				// $query .= " Studylog.account_id IN (" . $subQuery . ") ";
				// $query .= "  ";
				$result = $this->Studylog->query($query);
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function getStudytime() {
		$this->layout = 'ajax';
		$result = array();
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$loginId = $this->Session->read('Auth.id');
				$friendId = $_POST['friend_id'];
				$date = $_POST['year'] . '-' . sprintf('%02d', $_POST['month']) . '-' . sprintf('%02d', $_POST['day']);

				// 副問い合わせ
				// 友達登録してあるユーザIDを取得
				// $query = ' SELECT ';
				// $query .= ' Friend.account_id ';
				// $query .= 'FROM ';
				// $query .= ' friends AS Friend ';
				// $query .= 'WHERE ';
				// $query .= ' Friend.my_id = ' . $loginId . ' ';
				// $query .= '  ';


				// 友達のアカウント情報を取得
				$query = "SELECT ";
				$query .= " * ";
				$query .= "FROM ";
				$query .= " accounts AS Account ";
				$query .= "WHERE ";
				$query .= " Account.id = " . $friendId . " ";
				$query .= "  ";
				$result[] = $this->Account->query($query);

				// 主文
				$query = "SELECT ";
				$query .= " * ";
				$query .= "FROM ";
				$query .= " studylogs AS Studylog ";
				$query .= "JOIN ";
				$query .= " studytimes AS Studytime ";
				$query .= "ON ";
				$query .= " Studylog.id = Studytime.studylog_id ";
				$query .= "JOIN ";
				$query .= " accounts AS Account ";
				$query .= "ON ";
				$query .= " Studylog.account_id = Account.id ";
				$query .= "WHERE ";
				$query .= " Studylog.date = '" . $date . "' ";
				$query .= "AND ";
				$query .= " Studylog.account_id = " . $friendId . " ";
				$query .= "  ";
				$result[] = $this->Studylog->query($query);
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result
			));
	}



	public function saveComment() {
		$this->layout = 'ajax';
		$this->autoRender = false;

		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$loginId = $this->Session->read('Auth.id');
				$postId = $_POST['post_id'];
				$text = $_POST['text'];

				$data = array(
					'Comment' => array(
						'account_id' => $loginId,
						'post_id' => $postId,
						'text' => $text
						)
					);
				$this->Comment->saveAll($data);
			}
		} else {
		// 不正処理
		}
	}
}
