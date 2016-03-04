<?
class Justificativa extends AppModel{
	var $useTable = 'tb_justificativas';

	public $belongsTo = array(
		'Pl' => array(
            'className'             => 'Pl',
            'foreignKey'            => 'pl_id',
            'dependent' => true,
        ),
		'StatusType' => array(
            'className'             => 'StatusType',
            'foreignKey'            => 'status_type_id',
            'dependent' => true,
        ),
	);

}
