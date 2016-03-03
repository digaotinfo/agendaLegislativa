<?
class Conteudo extends AppModel{
	var $useTable = 'tb_conteudo';

	public $virtualFields = array(
	   							 'total_galeria' => '(SELECT count(Galeria.id) as "total" FROM tb_galeria Galeria WHERE Galeria.conteudo_id = Conteudo.id)'
	   							 	 );

    public $hasAndBelongsToMany = array(
				'Setor' => array(
					'className'             => 'Setor',
					//tabela do relacionamento
					'joinTable'             => 'tb_conteudo_setores',
					'foreignKey'            => 'conteudo_id',
					//chave de associação
					'associationForeignKey' => 'setor_id',
					'fields'				=> array('id', 'setor')
				),
	);
	
	public $belongsTo = array(
			'Categoria' => array(
				'className'             => 'Categoria',
				//tabela do relacionamento
				//'joinTable'             => 'tb_conteudo_empresas',
				//'foreignKey'            => 'conteudo_id',
				//chave de associação
				'associationForeignKey' => 'categoria_id',
				'fields'				=> array('id', 'categoria')
			),
	);
	
	public $validate = array(
		'categoria_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar a Categoria',
			)
		),
		
		/*
		'Setor' => array( 
            'multiple' => array( 
                'rule' => array('multiple',array('min' => 1)), 
                'required' => true,
                'message' => 'Por favor, escolha quais setores terão acesso a este conteúdo'), 
        ),
        */
        
		'titulo' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar o título',
			)
		),
		
		'texto' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar o texto',
			)
		),
	);

	public function afterSave($modified) {

		$registro_assunto_id = $this->data['Conteudo']['id'];

		$setor_id = $this->data['Setor']['Setor'];

		$e_ids = '';
		foreach ($setor_id as $id) {
			$e_ids .= "|{$id}|";
		}

		///CREATE
		$this->query("INSERT INTO tb_log_alteracoes (data_alteracao, id_alterado, tipo, setor_ids) VALUES (now(),{$registro_assunto_id},'conteudo','{$e_ids}' )");

	}


	public function beforeDelete($modified) {
		
		//print_r($this->id);
		$registro = $this->findById($this->id);
		//print_r($registro);
		//die();
		
		$registro_assunto_id = $this->id;

		//$empresa_id = $this->data['Setor']['Setor'];
		$e_ids = '';
		foreach ($registro['Setor'] as $id) {
			//echo '|'. $id['id'] .'|';
			$e_ids .= "|". $id['id'] ."|";
		}
		
		$sql = "INSERT INTO tb_log_alteracoes (data_alteracao, id_alterado, tipo, setor_ids) VALUES (now(),{$registro_assunto_id},'conteudo','{$e_ids}' )";
		//print_r($sql);
		//die();
		
		///CREATE
		$this->query($sql);

	}
}
