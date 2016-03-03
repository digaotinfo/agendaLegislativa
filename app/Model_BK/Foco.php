<?
class Foco extends AppModel{
	var $useTable = 'tb_foco';

    public $belongsTo = array(
		'Pl' => array(
			'className'             => 'Pl',
			'foreignKey'            => 'pl_id',
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
