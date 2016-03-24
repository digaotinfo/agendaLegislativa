<?
class Relator extends AppModel{
	var $useTable = 'tb_autor_relator';

    public $hashMany = array(
        'Pl' => array(
            'className'	=> 'Pl',
            'foreignKey'=> 'relator_id',
            'dependent' => true,
        )
    );
}
