<?
class OqueE extends AppModel{
	var $useTable = 'tb_o_que_e';

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
			'className'				=> 'LogAtualizacaoPl',
			'foreignKey'            => 'model_id',
			'dependent' => true,
		),
	);

}
