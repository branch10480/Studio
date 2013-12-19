<?php
class Post extends AppModel {
	public $primaryKey = array('account_id', 'post_datetime');
	public $belongsTo = array('Account');
}
