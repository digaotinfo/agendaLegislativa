<?
class Justificativa extends AppModel{
	var $useTable = 'tb_justificativas';

	public $belongsTo = array(
		'Pl' => array(
            'className'     => 'Pl',
            'foreignKey'    => 'pl_id',
            'dependent' 	=> true,
			'fields'		=> array('id', 'numero_da_pl', 'ano'),
        ),
		'StatusType' => array(
            'className'     => 'StatusType',
            'foreignKey'    => 'status_type_id',
            'dependent' 	=> true,
			'fields'		=> array('id', 'status_name'),
        ),
	);

}
