<?php
class Loguser extends AppModel {
	// public $name = 'Loguser';
	var $useTable = 'tb_usuario_log';

	// var $order = array(
	// 	"created" => "DESC",
	// );

	var $belongsTo = array(
		'User' => array(
			'className'             => 'User',
			'foreignKey'            => 'usuario_id',
			'dependent' => true,
		),
	);


}
