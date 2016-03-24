<?php
class PlSituacao extends AppModel{
    var $useTable = 'tb_pl_situacao';
    public $hasMany = array(
		'Pl' => array(
			'className'				=> 'Pl',
			//tabela do relacionamento
			// 'joinTable'             => 'tb_pl_foco',
			'foreignKey'            => 'situacao_id',
			//chave de associação
			// 'associationForeignKey' => 'pl_id',
			'dependent' => true,
		),
	);
}
?>
