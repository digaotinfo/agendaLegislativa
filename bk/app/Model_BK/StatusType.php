<?
class StatusType extends AppModel{
	var $useTable = 'tb_status_types';

	public $hasMany = array(
		'Pl' => array(
            'className'             => 'Pl',
            'foreignKey'            => 'status_type_id',
            'dependent' => true,
        ),
		'Justificativa' => array(
            'className'             => 'Justificativa',
            'foreignKey'            => 'status_type_id',
            'dependent' => true,
        ),
	);

}
