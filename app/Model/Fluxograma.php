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
}
