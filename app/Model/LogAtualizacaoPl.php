<?php
class LogAtualizacaoPl extends AppModel{
    var $useTable = 'tb_log_atualizacao_pl';

    public $belongsTo = array(
        'Pl' => array(
            'className' => 'Pl',
            'foreignKey'=> 'pl_id',
            'dependent' => true,
            'fields'    => array('id', 'numero_da_pl', 'ano'),
        ),
    );

    var $order = array("LogAtualizacaoPl.id" => "DESC");
}
?>
