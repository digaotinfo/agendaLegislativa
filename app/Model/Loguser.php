<?php
class Loguser extends AppModel {
	var $useTable = 'tb_usuario_log';

	var $belongsTo = array(
		'User' => array(
			'className'             => 'User',
			'foreignKey'            => 'usuario_id',
			'dependent' => true,
		),
	);


}
