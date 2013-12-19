<?php

/* --------------------------------------------------------------------------

ログイン認証回避のためのコンポーネント
ver1.0
今枝

-------------------------------------------------------------------------- */

App::uses('Component', 'Controller');
class MyAuthComponent extends Component {

	// このクラス内で使用するコンポーネント
	// public $components = array('Session');

	// 自作プロパティ
	public $allowArr;


	/**
	* ログイン認証を回避を判断
	*/
	public function allowAuth($actionName, $sessionFlg, $allowArr) {

		// ログイン認証するかしないかの判断
		$allowFlg = false;
		$this->setAllowArr($allowArr);
		for ($i = 0; $i < count($this->allowArr); $i++) {
			if ($actionName == $this->allowArr[$i]) {
				$allowFlg = true;
				break;
			}
		}

		// ログイン済みか判断
		$redirectFlg = true;
		if ($sessionFlg || $allowFlg) {
			$redirectFlg = false;
		}

		return $redirectFlg;
    }


    public function setAllowArr($allowArr) {
    	$this->allowArr = $allowArr;
    }
}