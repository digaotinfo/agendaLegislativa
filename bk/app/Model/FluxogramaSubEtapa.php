<?
class FluxogramaSubEtapa extends AppModel{
	var $useTable = 'tb_fluxo_subetapa';

	var $order = array('FluxogramaSubEtapa.ordem' => 'ASC');

	public $hasMany = array(
		'Pl' => array(
			'className'	   => 'Pl',
			'foreignKey'   => 'subetapa_id',
			'dependent'    => true,
		),
	);
}
