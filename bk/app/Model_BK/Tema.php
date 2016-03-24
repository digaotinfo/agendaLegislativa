<?
class Tema extends AppModel{
	var $useTable = 'tb_tema';

	public $hasMany = array(
		'Pl' => array(
            'className'             => 'Pl',
            'foreignKey'            => 'tema_id',
            'dependent' => true,
        ),
	);

}
