<?php
App::uses('AppHelper', 'View/Helper');

class PluralHelper extends AppHelper {
    public $helpers = array('Html');
	
	public function ize($s) {
		return Inflector::pluralize($s);
	}
}
?>