<?php
class Studytime extends AppModel {
	public $belongsTo = array('Studylog', 'Target');
}
