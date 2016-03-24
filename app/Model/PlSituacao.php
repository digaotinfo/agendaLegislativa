<?php
class PlSituacao extends AppModel{
    var $useTable = 'tb_pl_situacao';
    public $hasMany = array(
		'Pl' => array(
			'className'	=> 'Pl',
			'foreignKey'=> 'situacao_id',
			'dependent' => true,
		),
	);
}
?>
