<? 
class Telefone extends AppModel{
	var $useTable = 'tb_telefones';
    
    public $hasAndBelongsToMany = array(
		'Setor' => array(
				'className'             => 'Setor',
				//tabela do relacionamento
				'joinTable'             => 'tb_telefones_setores',
				'foreignKey'            => 'telefone_id',
				//chave de associação  
				'associationForeignKey' => 'setor_id',
				/*'fields'				=> array('id') */
		),
	);
	
	
	//telefones
	
	
	public $validate = array(
        
		'telefones' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Favor informar a lista de telefones',
			)
		),
	);
	
	

	public function afterSave($modified) {

		$registro_assunto_id = $this->data['Telefone']['id'];

		$setor_id = $this->data['Setor']['Setor'];

		$e_ids = '';
		foreach ($setor_id as $id) {
			$e_ids .= "|{$id}|";
		}

		///CREATE
		$this->query("INSERT INTO tb_log_alteracoes (data_alteracao, id_alterado, tipo, setor_ids) VALUES (now(),{$registro_assunto_id},'telefone','{$e_ids}' )");

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
		
		$sql = "INSERT INTO tb_log_alteracoes (data_alteracao, id_alterado, tipo, setor_ids) VALUES (now(),{$registro_assunto_id},'telefone','{$e_ids}' )";
		//print_r($sql);
		//die();
		
		///CREATE
		$this->query($sql);

	}
}