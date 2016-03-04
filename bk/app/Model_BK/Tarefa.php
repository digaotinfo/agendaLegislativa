<?
class Tarefa extends AppModel{
	var $useTable = 'tb_tarefas';

	public $order = array(
		"realizado" => "ASC",
	);

	public $belongsTo = array(
        'Pl' => array(
            'className'     => 'Pl',
            'foreignKey'    => 'pl_id',
            'dependent'     => true,
        ),
    );
}
