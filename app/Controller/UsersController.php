<?php

class UsersController extends AppController {



	// public $components = array('DebugKit.Toolbar');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account');				// 使用するモデル
	public $components = array('RequestHandler', 'MyAuth');



	public function beforeFilter() {
		// code
		define('controllerURL', rootUrl . 'users/');

		// ログイン認証回避
		$allowArr = array(
			'login',
			'login_comp',
			'new_account',
			'send_mail',
			'account_regist',
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
	* 新規会員登録開始
	*/
	public function new_account() {
		$this->layout = 'top';
		if ($this->referer() == controllerURL . 'new_account/' && $this->request->is('post')) {
			/* 仮登録処理 */
			$data = array(
					'Account' => array(
							'mailaddress' => $this->request->data['Account']['mailaddress'],
							'pass' => base64_encode($this->request->data['Account']['pass'])
						)
				);
			$this->Account->save($data);

			/* ページ遷移 */
			$mail = base64_encode($this->request->data['Account']['mailaddress']);
			$this->redirect('send_mail/' . $mail);
		}
	}



	/**
	* メール送信処理
	*/
	public function send_mail($mail) {

		/* 表示変数格納 */
		$this->set(array(
				'mail' => '',
				'url' => controllerURL . 'account_regist/' . $mail
			));
	}



	/**
	* アカウント本登録
	*/
	public function account_regist ($mail) {
		$mailaddress = base64_decode($mail);
		$this->set('mailaddress', $mailaddress);

		/* 本登録処理 */
		$data = array(
				'Account.entry_flg' => '1'
			);
		$conditions = array(
				'Account.mailaddress' => $mailaddress
			);
		$this->Account->updateAll($data, $conditions);
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
}