<?
class Fluxograma extends AppModel{
	var $useTable = 'tb_fluxo_historico';

    public $belongsTo = array(
		'Pl' => array(
			'className'     => 'Pl',
			'foreignKey'    => 'pl_id',
			'dependent' 	=> true,
			'fields'		=> array('id', 'numero_da_pl', 'ano'),
		),
		'PlType' => array(
			'className'     => 'PlType',
			'foreignKey'	=> 'tipo_id',
			'dependent' 	=> true,
			'fields'		=> array('id', 'tipo'),
		),
	);

	// public $hasAndBelongsToMany = array(
	// 	'FluxogramaEtapaLogFluxo' 	 => array(
	// 		'className'              => 'FluxogramaEtapa',
	// 		'joinTable' 			 => 'tb_fluxo_log_origem_pl_tb_fluxo_etapa',
	// 		'foreignKey'             => 'fluxo_log_origem_id',
	// 		'associationForeignKey'  => 'fluxo_etapa_id',
	// 		'fields'				 => array('id', 'etapa', 'descricao', 'FluxogramaEtapaLogFluxo.ordem'),
	// 		'order'					 => array('FluxogramaEtapaLogFluxo.ordem' => 'ASC')
	// 	),
	// );

}
