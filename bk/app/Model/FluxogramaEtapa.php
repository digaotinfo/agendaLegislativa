<?
class FluxogramaEtapa extends AppModel{
	var $useTable = 'tb_fluxo_etapa';

	public $belongsTo = array(
		'PlType' => array(
        	'className'	   	=> 'PlType',
        	'foreignKey'   	=> 'pl_type_id',
        	'dependent'		=> true,
			'fields'		=> array('id', 'tipo', 'ativo', 'modified')
        ),
	);
	public $hasMany = array(
		'FluxogramaSubEtapa' => array(
			'className'		=> 'FluxogramaSubEtapa',
			'foreignKey'    => 'etapa_id',
			'dependent' 	=> true,
			'fields'		=> array('id', 'etapa_id', 'subetapa', 'descricao', 'ordem'),
			'order'			=> array('ordem' => 'ASC')
		),

		'Pl' => array(
			'className'	   => 'Pl',
			'foreignKey'   => 'etapa_id',
			'dependent'    => true,
		),
		'LogAtualizacaoPl' => array(
        	'className'	   => 'LogAtualizacaoPl',
        	'foreignKey'   => 'etapa_id',
        	'dependent'    => true,
        ),
	);

	// public $hasAndBelongsToMany = array(
	// 	'FluxogramaEtapaSubEtapaLog' 	 => array(
	// 		'className'              => 'FluxogramaSubEtapa',
	// 		'joinTable' 			 => 'tb_fluxo_logetapa_subetapa',
	// 		'foreignKey'             => 'logetapa_id',
	// 		'associationForeignKey'  => 'subetapa_id',
	// 		'fields'				 => array('id', 'subetapa', 'descricao', 'ordem'),
	// 		// 'order'					 => array('FluxogramaEtapaSubEtapaLog.ordem' => 'ASC')
	// 	),
	// );
}
