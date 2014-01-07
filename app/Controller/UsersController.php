<?php

class UsersController extends AppController {



	// public $components = array('DebugKit.Toolbar');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account', 'MyTarget', 'Target');				// 使用するモデル
	public $components = array('RequestHandler', 'MyAuth', 'requestHandler');



	public function beforeFilter() {
		// code
		define('controllerURL', rootUrl . 'users/');

		// ログイン認証回避
		$allowArr = array(
			'login',
			'login_comp',
			'checkRule',
			'new_account',
			'send_mail',
			'createProfile',
			'confirmNewacc',
			'account_regist',
			'autologin',
			'mailaddress_exists',
			'logout'
			);
		if ($this->MyAuth->allowAuth($this->action, $this->Session->check('Auth'), $allowArr)) {
			$this->redirect(array('controller' => 'home', 'action' => 'index'));
		}
	}



	public function index() {
		if ($this->Session->check('Auth')) {
			echo 'ログインしています';
		}
	}



	/**
	* Ajaxによるログイン処理
	*/
	public function login() {
		$this->layout = 'ajax';
		$result = 'false';
		$msg = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$options = array(
					'conditions' => array(
							'Account.mailaddress' => $_POST['id'],
							'Account.pass' => base64_encode($_POST['pass']),
							'Account.entry_flg' => '1'
						)
				);
				if ($this->Account->find('count', $options) == 1) {
					// ログイン成功
					$result = 'true';
					$data = $_POST['id'];
				} else {
					// ログイン失敗
					$msg = '※ ユーザ名またはパスワードが間違っています。';
				}
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result,
			'msg' => $msg,
			'mail' => base64_encode($_POST['id'])
			));
	}



	/**
	* ログイン完了処理
	*/
	public function login_comp() {

		if (!$this->request->is('post')) {
			$this->redirect(array('controller' => 'home', 'action' => 'index'));
		}

		// ユーザ情報の取り出し
		$params = array(
			'conditions' => array(
				'Account.mailaddress' => $_POST['loginEmail']
				)
			);
		$userInfo = $this->Account->find('all', $params);

		// セッション情報の書き込み
		$this->Session->write('Auth.id', $userInfo[0]['Account']['id']);
		$this->Session->write('Auth.mailaddress', $userInfo[0]['Account']['mailaddress']);
		$this->Session->write('Auth.name', $userInfo[0]['Account']['name']);
		$this->Session->write('Auth.img_ext', $userInfo[0]['Account']['img_ext']);

		// リダイレクト
		$this->redirect(array('controller' => 'home', 'action' => 'top'));
	}



	/**
	* ログアウト
	*/
	public function logout() {
		$this->Session->delete('Auth');
		$this->redirect(rootUrl);
	}



	/**
	* 規約確認ページ
	*/
	public function checkRule() {
		$this->layout = 'top';
		$this->set('title_for_layout', ' | 利用規約の確認');

		$this->set('nextURL', controllerURL . 'new_account/');
	}



	/**
	* 新規会員登録開始
	*/
	public function new_account() {
		$this->layout = 'top';
		if ($this->referer() == controllerURL . 'new_account/' && $this->request->is('post')) {
			/* 仮登録処理 */
			$pass = openssl_random_pseudo_bytes(6);
			$data = array(
					'Account' => array(
							'mailaddress' => $this->request->data['Account']['mailaddress'],
							'pass' => $pass
						)
				);
			$this->Account->save($data);

			/* ページ遷移 */
			$mail = base64_encode($this->request->data['Account']['mailaddress']);
			$this->redirect('send_mail/' . $mail . '/' . $pass);
		}
	}



	/**
	* メール送信処理
	*/
	public function send_mail($mail, $pass) {
		$this->layout = 'top';
		/* 表示変数格納 */
		$this->set(array(
			'title_for_layout' => ' | メール送信完了',
			'mail' => '',
			'url' => controllerURL . 'createProfile/' . $mail . '/' . $pass
			));
	}



	/**
	* プロフィール作成
	*/
	public function createProfile($mail_ = 0, $defpass_ = 0) {
		$this->layout = 'top';
		$this->set('title_for_layout', ' | プロフィール作成');

		$name = '';
		$pass = '';
		$introduction = '';
		$sex = '';
		$birthday = '';

		// 登録メールアドレス、仮passの保持
		if ($mail_ !== 0) {
			$this->Session->write('newAcc.mail', base64_decode($mail_));
			$this->Session->write('newAcc.defpass', $defpass_);
		}

		// 戻るで戻ってきた時のデータの受取
		if ($this->referer() == controllerURL . 'confirmNewacc') {
			$name = $this->Session->read('newAcc.name');
			$pass = $this->Session->read('newAcc.pass');
			$introduction = $this->Session->read('newAcc.introduction');
			$sex = $this->Session->read('newAcc.sex');
			$birthday = $this->Session->read('newAcc.birthday');
		}

		// リロード時
		if ($this->requestHandler->isPost()) {
			$name = $this->request->data['Account']['name'];
			$pass = $this->request->data['Account']['pass'];
			$sex = $this->request->data['Account']['sex'];
			$birthday = $this->request->data['Account']['birthday'];
			$introduction = $this->request->data['Account']['introduction'];

			// バリデーション

			// セッションへの保持
			$this->Session->write('newAcc.name', $name);
			$this->Session->write('newAcc.pass', $pass);
			$this->Session->write('newAcc.sex', $sex);
			$this->Session->write('newAcc.birthday', $birthday);
			$this->Session->write('newAcc.introduction', $introduction);

			// 遷移
			$this->redirect(array('action' => 'confirmNewacc'));
		}

		// 値の格納
		$this->set(array(
			'name' => $name,
			'pass' => $pass,
			'introduction' => $introduction,
			'sex' => $sex,
			'birthday' => $birthday,
			'mail' => $this->Session->read('newAcc.mail')
			));
	}



	/**
	* プロフィール作成確認
	*/
	public function confirmNewacc() {
		$this->layout = 'top';
		$this->set('title_for_layout', ' | プロフィール確認');

		// 遷移
		$this->set(array(
			'name' => $this->Session->read('newAcc.name'),
			'pass' => str_repeat('*', strlen($this->Session->read('newAcc.pass'))),
			'sex' => $this->Session->read('newAcc.sex'),
			'birthday' => $this->Session->read('newAcc.birthday'),
			'introduction' => $this->Session->read('newAcc.introduction'),
			'email' => $this->Session->read('newAcc.mail'),
			'returnURL' => controllerURL . 'createProfile/',
			'nextURL' => controllerURL . 'account_regist/'
			));
	}



	/**
	* アカウント本登録
	*/
	public function account_regist() {
		$this->layout = 'top';
		$mailaddress = $this->Session->read('newAcc.mail');
		$this->set('mailaddress', $mailaddress);

		// データ変数
		$pass = base64_encode($this->Session->read('newAcc.pass'));
		$name = $this->Session->read('newAcc.name');
		$introduction = $this->Session->read('newAcc.introduction');
		$sex = $this->Session->read('newAcc.sex');

		// 誕生日の整形
		$birthday = $this->Session->read('newAcc.birthday');
		$tmpArr = array();
		$tmpArr[] = substr($birthday, 0, 4);
		$tmpArr[] = substr($birthday, 4, 2);
		$tmpArr[] = substr($birthday, 6, 2);
		$birthday = implode('-', $tmpArr);

		/* 本登録処理 */
		$data = array(
				'Account.pass' => "'" . $pass . "'",
				'Account.name' => "'" . $name . "'",
				'Account.introduction' => "'" . $introduction . "'",
				'Account.sex' => "'" . $sex . "'",
				'Account.birthday' => "'" . $birthday . "'",
				'Account.entry_flg' => '1'
			);
		$conditions = array(
				'Account.mailaddress' => $mailaddress
			);
		$this->Account->updateAll($data, $conditions);

		$this->set(array(
			'name' => $name,
			'mail' => $this->Session->read('newAcc.mail'),
			'sex' => $sex,
			'birthday' => $tmpArr[0] . '年 ' . sprintf('%d', $tmpArr[1]) . '月 ' . sprintf('%d', $tmpArr[2]) . '日',
			'introduction' => $introduction,
			'autologinURL' => controllerURL . 'autologin/' . base64_encode($this->Session->read('newAcc.mail'))
			));

		// 新規会員登録用のセッションの削除
		$this->Session->delete('newAcc');
	}



	/**
	* 新規会員登録後の自動ログイン
	*/
	public function autologin($mail_ = 0) {
		// 不正アクセス対策
		if ($mail_ === 0) {
			header('location: ' . rootUrl);
			exit();
		}

		// ユーザ情報の取り出し
		$params = array(
			'conditions' => array(
				'Account.mailaddress' => base64_decode($mail_)
				)
			);
		$userInfo = $this->Account->find('all', $params);

		// セッション情報の書き込み
		$this->Session->write('Auth.id', $userInfo[0]['Account']['id']);
		$this->Session->write('Auth.mailaddress', $userInfo[0]['Account']['mailaddress']);
		$this->Session->write('Auth.name', $userInfo[0]['Account']['name']);
		$this->Session->write('Auth.img_ext', $userInfo[0]['Account']['img_ext']);

		// 遷移
		$this->redirect(homeUrl);
	}



	/**
	* Ajaxによるメールアドレス重複チェック
	*/
	public function mailaddress_exists() {
		$this->layout = 'ajax';
		$result = 'true';
		$msg = '';
		if ($this->RequestHandler->isAjax()) {
			// 正常処理
			if ($this->request->is('post')) {
				$options = array(
					'conditions' => array(
							'Account.mailaddress' => $_POST['mail']
						)
				);
				if ($this->Account->find('count', $options) == 1) {
					// メールアドレス重複あり
					$msg = '※ 既に使用されているメールアドレスです。';
					$result = 'false';
				} else {
					// メールアドレス重複なし
					$msg = 'このメールアドレスは使用できます。';
				}
			}
		} else {
			// 不正処理
		}
		$this->set(array(
			'result' => $result,
			'msg' => $msg
			));
	}



	/**
	* プロフィールページ
	*/
	public function profile( $userId_ = '00' ) {
		$userId = '';

		// 表示するユーザの決定
		if ($userId_ === '00') {
			$userId = $this->Session->read('Auth.id');
		} else {
			$userId = $userId_;
		}

		// userIdを元にユーザプロフィール取得
		$params = array(
					'conditions' => array(
						'Account.id' => $userId
						)
					);
		$result = $this->Account->find('first', $params);
		// if ($result) {
		// 	exit();
		// }
		$this->set(array(
			'title_for_layout' => ' | プロフィール',
			'user_id' => $result['Account']['id'],
			'user_name' => $result['Account']['name'],
			'user_introduction' => $result['Account']['introduction'],
			'user_img_ext' => $result['Account']['img_ext'],
			'user_sex' => $result['Account']['sex']
			));

		// 年齢の計算
		$now = date('Ymd');
		$birthday = str_replace('-', '', $result['Account']['birthday']);
		$age = floor(($now - $birthday) / 10000);
		$this->set('age', $age);

		// 目標を取得
		$query = 'SELECT ';
		$query .= ' Target.name ';
		$query .= 'FROM ';
		$query .= ' mytargets AS MyTarget ';
		$query .= 'JOIN ';
		$query .= ' accounts AS Account ';
		$query .= 'ON ';
		$query .= ' MyTarget.account_id = Account.id ';
		$query .= 'JOIN ';
		$query .= ' targets AS Target ';
		$query .= 'ON ';
		$query .= ' MyTarget.target_id = Target.id ';
		$query .= 'WHERE ';
		$query .= ' MyTarget.account_id = ' . $userId . ' ';
		$result = $this->MyTarget->query($query);
		$this->set('targets', $result);
	}
}
