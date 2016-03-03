<?
class Pl extends AppModel{
	var $useTable = 'tb_pls';
	var $name = 'Pl';

	var $transformUrl = array(
							'url_amigavel' => 'numero_da_pl'
						);


	public $belongsTo = array(
		'StatusType' => array(
			'className'             => 'StatusType',
			'foreignKey'            => 'status_type_id',
			'dependent' => true,
		),
		'PlType' => array(
			'className'             => 'PlType',
			'foreignKey'            => 'tipo_id',
			'dependent' => true,
		),
		'Tema' => array(
			'className'             => 'Tema',
			'foreignKey'            => 'tema_id',
			'dependent' => true,
		),
		'Autor' => array(
			'className'             => 'Autor',
			'foreignKey'            => 'autor_id',
			'dependent' => true,
		),
		'Relator' => array(
			'className'             => 'Relator',
			'foreignKey'            => 'relator_id',
			'dependent' => true,
		),
	);
	public $hasMany = array(
		'Foco' => array(
			'className'				=> 'Foco',
			'foreignKey'            => 'pl_id',
			'dependent' => true,
		),
		'OqueE' => array(
			'className'				=> 'OqueE',
			'foreignKey'            => 'pl_id',
			'dependent' => true,
		),
		'Situacao' => array(
			'className'		=> 'Situacao',
			'foreignKey'	=> 'pl_id',
			'dependent' 	=> true,
			// 'limit'			=> 5,
			'order'			=> array('id' => 'ASC')
		),
		'NossaPosicao' => array(
			'className'				=> 'NossaPosicao',
			'foreignKey'            => 'pl_id',
			'dependent' => true,
			'limit'			=> 5,
			'order'			=> array('id' => 'DESC')
		),
		'LogAtualizacaoPl' => array(
			'className'				=> 'LogAtualizacaoPl',
			'foreignKey'            => 'pl_id',
			'dependent' 			=> true,
			// 'limit'				=> 1,
			'order'					=> array('id' => 'ASC')
		),
		'Justificativa' => array(
            'className'             => 'Justificativa',
            'foreignKey'            => 'pl_id',
            'dependent' 			=> true,
			'order'					=> array('id' => 'DESC')
        ),
		'Tarefa' => array(
		    'className'             => 'Tarefa',
		    'foreignKey'            => 'pl_id',
		    'dependent' 			=> true,
			'order'					=> array('realizado' => 'ASC', 'entrega' => 'ASC'),
			'conditions' 			=> array('Tarefa.delete' => 0, 'Tarefa.ativo' => 1),
		),
		'NotasTecnica' => array(
		    'className'             => 'NotasTecnica',
		    'foreignKey'            => 'pl_id',
		    'dependent' 			=> true,
			'order'					=> array('id' => 'DESC'),
		),
	);


}
