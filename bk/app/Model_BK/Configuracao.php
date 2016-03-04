<?php
class Configuracao extends AppModel {
	var $useTable = 'tb_configuracao';
	

	// Informações que serão recuperadas no momento do upload do(s) arquivo(s)
	public $type_files = array(
                            'facebook_logo' => array(
                                                    'ext' 	=> array(
                                                                    'gif', 
                                                                    'jpeg', 
                                                                    'png', 
                                                                    'jpg',
                                                                ),
                                                    'dir' 	=> 'uploads/',
                                                    'size'	=> array('w'=> 400, 'h' => 400, 'force' => false),
                                                    'th' 	=> array('width' => 100, 'height' => 100)
                                                )
                        );

	var $order = array("Configuracao.id" => "DESC");
}