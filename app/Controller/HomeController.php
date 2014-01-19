<?php

class HomeController extends AppController {


	public $components = array('MyAuth');	// コントローラーの処理を拡張するcomponentを指定
	public $uses = array('Account');				// 使用するモデル


	public function beforeFilter() {

		// ログイン認証回避
		$allowArr = array(
			'index'
			);
		if ($this->MyAuth->allowAuth($this->action, $this->Session->check('Auth'), $allowArr)) {
			$this->redirect(array('controller' => 'home', 'action' => 'index'));
		}
	}

	public function index() {
		// ログイン済みの場合の処理
		if ($this->Session->check('Auth.id')) $this->redirect(homeUrl);

		$this->layout = 'top';
		$this->set('title_for_layout', '');
	}

	public function top() {
		$this->set('title_for_layout', '');
	}

	public function fsearch() {
		$this->set('title_for_layout', ' | 勉強仲間を探す');
	}
}
