<?
class Foco extends AppModel{
	var $useTable = 'tb_foco';

    public $belongsTo = array(
		'Pl' => array(
			'className' => 'Pl',
			'foreignKey'=> 'pl_id',
			'dependent' => true,
			'fields'	=> array('id', 'numero_da_pl', 'ano'),
		)
	);
	public $hasMany = array(
		'LogAtualizacaoPl' => array(
			'className'	=> 'LogAtualizacaoPl',
			'foreignKey'=> 'model_id',
			'dependent' => true,
		),
	);
}
