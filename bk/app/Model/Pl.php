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
		'FluxogramaEtapa' => array(
		    'className'             => 'FluxogramaEtapa',
		    'foreignKey'            => 'etapa_id',
		    'dependent' 			=> true,
			// 'order'					=> array('id' => 'ASC'),
			// 'fields'				=> array('id', 'pl_origem', 'tipo_id', 'numero_da_pl', 'ano', 'created'),
		),
		'FluxogramaSubEtapa' => array(
		    'className'             => 'FluxogramaSubEtapa',
		    'foreignKey'            => 'subetapa_id',
		    'dependent' 			=> true,
			// 'order'					=> array('id' => 'ASC'),
			// 'fields'				=> array('id', 'pl_origem', 'tipo_id', 'numero_da_pl', 'ano', 'created'),
		),
	);

	public $hasMany = array(
		'Foco' => array(
			'className'				=> 'Foco',
			'foreignKey'            => 'pl_id',
			'dependent' => true,
			'fields'		=> array('id', 'txt', 'arquivo', 'modified')
		),
		'OqueE' => array(
			'className'				=> 'OqueE',
			'foreignKey'            => 'pl_id',
			'dependent' => true,
			'fields'		=> array('id', 'txt', 'arquivo', 'modified' )
		),
		'Situacao' => array(
			'className'		=> 'Situacao',
			'foreignKey'	=> 'pl_id',
			'dependent' 	=> true,
			// 'limit'			=> 5,
			'order'			=> array('id' => 'ASC'),
			'fields'		=> array('id', 'txt', 'arquivo', 'dir', 'modified')
		),
		'NossaPosicao' => array(
			'className'		=> 'NossaPosicao',
			'foreignKey'    => 'pl_id',
			'dependent' 	=> true,
			'limit'			=> 5,
			'order'			=> array('id' => 'DESC'),
			'fields'		=> array('id', 'status_posicao_id', 'txt', 'arquivo', 'modified')
		),
		'LogAtualizacaoPl' => array(
			'className'				=> 'LogAtualizacaoPl',
			'foreignKey'            => 'pl_id',
			'dependent' 			=> true,
			// 'limit'				=> 1,
			'order'					=> array('id' => 'ASC'),
			// 'fields'				=> array('id')
		),
		'Justificativa' => array(
            'className'             => 'Justificativa',
            'foreignKey'            => 'pl_id',
            'dependent' 			=> true,
			'order'					=> array('id' => 'DESC'),
			'fields'				=> array('id', 'status_type_id', 'justificativa')
        ),
		'Tarefa' => array(
		    'className'             => 'Tarefa',
		    'foreignKey'            => 'pl_id',
		    'dependent' 			=> true,
			'order'					=> array('realizado' => 'ASC', 'entrega' => 'ASC'),
			'conditions' 			=> array('Tarefa.delete' => 0, 'Tarefa.ativo' => 1),
			'fields'				=> array('id', 'titulo', 'descricao', 'entrega', 'realizado', 'enviado_por_email', 'modified')
		),
		'NotasTecnica' => array(
		    'className'             => 'NotasTecnica',
		    'foreignKey'            => 'pl_id',
		    'dependent' 			=> true,
			'order'					=> array('id' => 'DESC'),
			'fields'				=> array('id', 'nome', 'arquivo', 'dir')
		),
		// 'AtualizacaoExternaPl' => array(
		//     'className'             => 'AtualizacaoExternaPl',
		//     'foreignKey'            => 'pl_id',
		//     'dependent' 			=> true,
		// 	'order'					=> array('id' => 'DESC'),
		// 	// 'fields'				=> array('id', 'nome', 'arquivo', 'dir')
		// ),


	);




}
