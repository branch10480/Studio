<?php
class Comrade extends AppModel {
	public $useTable = array('t_comrade');
	public $primaryKey = array('f_followed_id', 'f_follower_id');
}
