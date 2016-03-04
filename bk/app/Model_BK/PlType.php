<?php
class PlType extends AppModel{
    var $useTable = 'tb_pl_types';
    public $hasMany = array(
		'Pl' => array(
			'className'				=> 'Pl',
			//tabela do relacionamento
			// 'joinTable'             => 'tb_pl_foco',
			'foreignKey'            => 'tipo_id',
			//chave de associação
			// 'associationForeignKey' => 'pl_id',
			'dependent' => true,
		),
	);
}
?>
