<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class AjaxeventsController extends AppController {
	var $name 			= "Ajaxevents";
	public $helpers 	= array('Html', 'Session', 'Form', 'Time');
	public $components 	= array('RequestHandler');
	public $uses		= array();
	
	function beforeFilter() {
		//parent::beforeFilter();
			
		
	}
	
	
	public function uploadAjax() {
		$this->autoRender = false;
		
		$requests = $this->request;
		//print_r($requests);
		//die();
		
		$model 	= $requests->data[0];
		$coluna	= $requests->data[1];
		$acao	= $requests->data[2];
		$campo 	= $requests->params['form'][$coluna];
		$dir	= $requests->data[3];
		$size	= $requests->data[4];
		$th		= $requests->data[5];
		$ext	= $requests->data[6];
		$id		= '';
		
		//print_r($campo);
		//die();
		/*
		$dir   -> Diretório de Destino do arquivo
		$file  -> Arquivo
		$ext   -> Extensões permitidas para esse arquivo. (Array)
		$force -> Se TRUE, força a existência de um arquivo.
		$resize-> Chama a funcao resizeImage() se passado como array
		$fileName -> Se TRUE, impõe um novo nome ao arquivo.
		$toLower -> Se TRUE, força o nome do arquivo a ser minusculo.
		*/
		$nome_imagem = $this->uploadFile(
										$dir, 
										$campo, 
										$ext, 
										$size, 
										$force=false, 
										$fileName="", 
										$createDir = true, 
										$action=array('action' => $acao, 'id' => $id), 
										$toLower=true, 
										$th
									);
		
		//print_r ($nome_imagem);
		//echo $nome_imagem['1'];
		//die();
		//print_r($this->$model->info_files[$coluna]['dir'].$this->request->data[$model][$campo]['name']);
		
		//return $this->$model->info_files[$coluna]['dir'].$this->request->data[$model][$campo]['name'];
		return $nome_imagem['1'];
		
		
		//print_r($retorno);
	}

}

