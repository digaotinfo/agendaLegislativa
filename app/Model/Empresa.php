<?php
class Empresa extends AppModel{
	var $useTable = 'tb_empresas';

    public $hasMany = array(
		'User' => array(
			'className'	=> 'User',
			'foreignKey'=> 'empresa_id',
			'dependent' => true,
		),
	);
}
?>
