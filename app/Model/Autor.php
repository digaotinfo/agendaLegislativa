<?
class Autor extends AppModel{
	var $useTable = 'tb_autor_relator';

    public $hashMany = array(
        'Pl' => array(
            'className'	=> 'Pl',
            'foreignKey'=> 'autor_id',
            'dependent' => true,
        )
    );
}
