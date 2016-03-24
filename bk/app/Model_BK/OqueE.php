<?
class OqueE extends AppModel{
	var $useTable = 'tb_o_que_e';

    // public $belongsTo = array('Pl');
    public $belongsTo = array(
		'Pl' => array(
			'className'             => 'Pl',
			//tabela do relacionamento
			// 'joinTable'             => 'tb_pl_foco',
			'foreignKey'            => 'pl_id',
			//chave de associação
			// 'associationForeignKey' => 'pl_id',
			//'fields'				=> array('id', 'nome'),
			'dependent' => true,
		)
	);


	public $hasMany = array(
		'LogAtualizacaoPl' => array(
			'className'				=> 'LogAtualizacaoPl',
			//tabela do relacionamento
			// 'joinTable'             => 'tb_pl_foco',
			'foreignKey'            => 'model_id',
			//chave de associação
			// 'associationForeignKey' => 'pl_id',
			'dependent' => true,
		),
	);

}
