<?php
class LogAtualizacaoPl extends AppModel{
    var $useTable = 'tb_log_atualizacao_pl';

    public $belongsTo = array(
        'Pl' => array(
            'className'             => 'Pl',
            //tabela do relacionamento
            // 'joinTable'             => 'tb_pl_foco',
            'foreignKey'            => 'pl_id',
            //chave de associação
            // 'associationForeignKey' => 'pl_id',
            //'fields'              => array('id', 'nome'),
            'dependent' => true,
        ), 
        // 'PlType' => array(
        //     'className'             => 'PlType',
        //     //tabela do relacionamento
        //     // 'joinTable'             => 'tb_pl_foco',
        //     'foreignKey'            => 'tipo_id',
        //     //chave de associação
        //     // 'associationForeignKey' => 'pl_id',
        //     //'fields'				=> array('id', 'nome'),
        //     'dependent' => true,
        // ),
    );

    var $order = array("LogAtualizacaoPl.id" => "DESC");
}
?>
