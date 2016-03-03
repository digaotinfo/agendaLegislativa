<? 
class Setor extends AppModel{
	var $useTable = 'tb_setores';
    //public $actsAs = array('Containable');
    
    public $hasAndBelongsToMany = array(
		'Conteudo' => array(
				'className'             => 'Conteudo',
				//tabela do relacionamento
				'joinTable'             => 'tb_conteudo_setores',
				'foreignKey'            => 'setor_id',
				//chave de associação  
				'associationForeignKey' => 'conteudo_id',
				/*'fields'				=> array('id') */
		),
		// 'User' => array(
		// 		'className'             => 'User',
		// 		//tabela do relacionamento
		// 		'joinTable'             => 'usuarios_setores',
		// 		'foreignKey'            => 'setor_id',
		// 		//chave de associação  
		// 		'associationForeignKey' => 'user_id',
		// 		/*'fields'				=> array('id') */
		// ),
	);
	
	
	//public $hasMany = array('User');
}