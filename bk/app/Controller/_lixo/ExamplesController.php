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

class ExamplesController extends AppController {
	var $name = "Examples";
	public $helpers = array('Html', 'Session', 'Form');
	var $scaffold = 'admin';
	var $transformUrl = array('url_amigavel' => 'titulo_ptbr');
	
	//public function admin_index() {
	//	$this->redirect('listar');
	//}
	
	function beforeFilter() {
		
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
									'id'			=> 'ID',
									'autor'			=> 'Autor',
									'data_inicio'	=> 'Data Inicio',
									'data_fim'		=> 'Data Fim',
									'status'		=> 'Status',
									'titulo_ptbr'	=> 'Titulo',
									'imagem_th_hidden'	=> 'Imagem',
									'url_amigavel_ptbr'	=> 'URL Amigável'
								);
			$showImage	=	array(
								'imagem_th_hidden'
							);
			
			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);
			
			$this->layout = 'admin';
		}
	}

	function admin_listar($acao = 1) {
		$this->set('title', 'Listar');
		//$tarefas = $this->Tarefa->find('all');
		$this->layout = 'admin';
		
		$offset  = false;
		$offsetNumber = 0;
		$curPage = 0;
		$registrosPorPagina = 20;
		
		if(is_Numeric($acao)) {
		   $offsetNumber = ($acao-1) * $registrosPorPagina;
		   $offset  = true;
		   $curPage = $acao;
		}
		
		$all = $this->Tarefa->find('all');
		$numeroDePaginas = ceil(count($all) / $registrosPorPagina);
        $paginacao = $this->paginacao($curPage, $numeroDePaginas, 'admin/tarefas', 'listar');

		$this->set('tarefas', $this->Tarefa->find('all', array('offset' => $offsetNumber ,'limit' => $registrosPorPagina) ));
		
		$this->set(compact('tarefas', 'showAll', 'numeroDePaginas', 'curPage', 'paginacao'));
		//$this->set('tarefas', $tarefas);
   }

	function admin_listarale($acao = 1) {
		$this->set('title', 'Listar');
		//$tarefas = $this->Tarefa->find('all');
		$this->layout = 'admin';
		
		$offset  = false;
		$offsetNumber = 0;
		$curPage = 0;
		$registrosPorPagina = 20;
		
		if(is_Numeric($acao)) {
		   $offsetNumber = ($acao-1) * $registrosPorPagina;
		   $offset  = true;
		   $curPage = $acao;
		}
		
		$all = $this->Tarefasale->find('all');
		$numeroDePaginas = ceil(count($all) / $registrosPorPagina);
        $paginacao = $this->paginacao($curPage, $numeroDePaginas, 'admin/tarefas', 'listar');
		
		$this->set('tarefas', $this->Tarefasale->find('all', array('offset' => $offsetNumber ,'limit' => $registrosPorPagina) ));
		
		$this->set(compact('tarefas', 'showAll', 'numeroDePaginas', 'curPage', 'paginacao'));
	}
	
	function admin_tarefa($nome = null) {
		$this->layout = 'admin';
		
		if($nome != null) {
			$tarefas = $this->Tarefa->findByAutor($nome);
			
			$tarefa = array($tarefas);
		} else {
			$tarefa = $this->Tarefa->find('all');
		}
		//$tarefa = $this->Tarefa->find('all', array('conditions' => array('Tarefa.autor' => $nome) ));
		
		$this->set('tarefa', $tarefa);
	}
}

