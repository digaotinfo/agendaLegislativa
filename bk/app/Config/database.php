<?php
class DATABASE_CONFIG {

// public $default = array(
// 		'datasource' => 'Database/Mysql',
// 		'persistent' => false,
// 		'host' => 'mysql.meustestes.dreamhosters.com',
// 		'login' => 'digao',
// 		'password' => 'nogueira',
// 		'database' => 'arearestrita_dev',
// 		'prefix' => '',
// 		'encoding' => 'utf8',
// 	);

// public $default = array(
// 		'datasource' => 'Database/Mysql',
// 		'persistent' => false,
// 		'host' => 'mysql-zoio-bancos.jelastic.websolute.net.br',
// 		'login' => 'root',
// 		'password' => 'y8TF4Va1P2',
// 		'database' => 'arearestrita_dev',
// 		'prefix' => '',
// 		'encoding' => 'utf8',
// 	);

	///===> SERVER ZOIO
	///=====___ para criar as tabelas que o Cake Padrão precisa:
	///=====   .../_contructor/<usuario>/<senha>
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'mysql',
		'database' => 'arearestrita_dev',
		'prefix' => '',
		'encoding' => 'utf8',
	);
}
