<?
class ConteudoSetor extends AppModel{
	var $useTable = 'tb_conteudo_setores';

	public $hasAndBelongsToMany = array(
				'Conteudo' => array(
						'className'             => 'Conteudo',
						//tabela do relacionamento
						'joinTable'             => 'tb_conteudo_setores',
						'foreignKey'            => 'setor_id',
						//chave de associação
						'associationForeignKey' => 'conteudo_id',
/* 						'fields'				=> array('id') */
						)
				);
}
