<?php
class Todo extends AppModel {
	public $useTable = 'todo';
	public $belongsTo = array('Target');
}
