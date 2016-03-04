<?php
class Empresa extends AppModel{
	var $useTable = 'tb_empresas';

    public $hasMany = array(
		'User' => array(
			'className'				=> 'User',
			//tabela do relacionamento
			//'joinTable'             => 'tb_conteudo_empresas',
			'foreignKey'            => 'empresa_id',
			//chave de associação
			//'associationForeignKey' => 'id',
			'dependent' => true,
		),
	);
}
?>
