<? 
class Estado extends AppModel{
	var $useTable = 'tb_estado';
	
/* 	public $displayField = 'nome'; */
	
	public $hasMany = 'Cidade';
}