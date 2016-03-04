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

class ConfiguracoesController extends AppController {
	var $name 			= "Configuracoes";
	public $helpers 	= array('Html', 'Session', 'Form');
	var $scaffold 		= 'admin';
	
	
	function beforeFilter() {
		parent::beforeFilter();
			
		/*
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
		
			$showThisFields	=	array(
									'tag_title'				=> 'Title',
									'tag_keywords'			=> 'Keywords',
									'tag_description'		=> 'Description',
									'facebook_image_file'	=> 'Imagem no Facebook',
									'google_analytics'		=> 'Código do Analytics',
									'email_destinatario'	=> 'E-mail Destinatário',
									'email_remetente'		=> 'E-mail Remetente',
								);
			$showImage	=	array(
								'facebook_image_file'
							);
			
			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);
			
			$this->set('schemaTable', $this->Configuracao->schema());
			
		}
		*/
	}


	
	
	/* LIST */
	function admin_index(){
		$model = 'Configuracao';
		$this->set('model', $model);
		
		
		$registro = $this->$model->find('first', array(
													'fields' => array('id'),
													'recusive' => -1
												));

		$this->redirect(array('action' => 'edit', $registro[$model]['id']));
	}
	/* END LIST */

	/*  ADD */
	function admin_add(){
		$this->redirect(array('action' => 'index'));

    }
    /* END ADD */

    /* EDIT */
	function admin_edit($id=null){
		$model = 'Configuracao';
		$this->set('model', $model);

		$this->set('medidas_imagens', $this->$model->type_files);
		
		/// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }
        
		
		/// Verifica se houve post e se foi de alteração
		if ($this->request->is('post') || $this->request->is('put')) {
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				
				/// Gravando dados na base de ados
				if($this->$model->save($this->request->data)){
					
					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
	            	$this->Session->setFlash('Conteúdo alterado com sucesso!');
	            	
	            	// Redirecionando o usuário para a listagem dos registros
					$this->redirect(array('action' => 'edit', $id));
				}
			} else {
				
				/// Listando os erros que a Model está informando.
				$erros = $this->$model->validationErrors;
				$mensagem_erros = '';
				foreach ($erros as $erro):
					$index_name = key($erro);
					$mensagem_erros .= '&bull; ' . $erro[$index_name] . '</br>';
				endforeach;
				 
				 /// Colocando os erros na sessão ativa para ser mostrado ao usuário
				$this->Session->setFlash($mensagem_erros, 'default', array('class' => 'alert'));
					
			}
		}
		
		
		/// Seta o request data com as informações que a Model possui.
		$this->request->data = $this->$model->read(null, $id);

	}
	/*  END EDIT */

	/* DELETE     */
    function admin_delete($id){
		$this->redirect(array('action' => 'index'));
    }
    /* END DELETE */


}

