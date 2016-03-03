<?php
class PlType extends AppModel{
    var $useTable = 'tb_pl_types';
    public $hasMany = array(
		'Pl' => array(
			'className'	 => 'Pl',
			'foreignKey' => 'tipo_id',
			'dependent'  => true,
		),
		'FluxogramaEtapa' => array(
			'className'	 => 'FluxogramaEtapa',
			'foreignKey' => 'pl_type_id',
			'dependent'  => true,
            'fields'     => array('id', 'etapa', 'descricao', 'ordem')
		),
	);

    // public $belongsTo = array(
        // 'FluxogramaOrdem' => array(
        // 	'className'	   => 'FluxogramaOrdem',
        // 	'foreignKey'   => 'pl_type_id',
        // 	'dependent'    => true,
        // ),
    // );
}
?>
