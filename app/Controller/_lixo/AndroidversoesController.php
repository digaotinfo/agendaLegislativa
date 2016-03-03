<?php
class AndroidversoesController extends AppController {
	public $name = 'Androidversoes';
	public $helpers = array('Html', 'Session', 'Form', 'Tinymce', 'Time');
	public $uses = array('Androidversao');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('mostrarversao');
	}
	
	
	public function admin_index() {
		$model = 'Androidversao';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------
		
		$registro = $this->$model->find('first', array(
													'order' => array(
														'id' => 'desc'
													),
												));
		$this->set('registro', $registro);
	}

	/*  ADD */
	function admin_add(){
		$model = 'Androidversao';
		$this->set('model', $model);
		
		
		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post')){
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
			
				/// Gravando dados na base de ados
	            if ($this->$model->save($this->request->data)){
					
					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
		            $this->Session->setFlash('Versão adicionada com sucesso!');
	            	
	            	// Redirecionando o usuário para a listagem dos registros
	                $this->redirect(array('action' => 'index', 'admin' => true));
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
				$this->Session->setFlash($mensagem_erros);
					
			}   
        }

    }
    /* END ADD */

    /* EDIT */
	function admin_edit($id=null){
		$model = 'Androidversao';
		$this->set('model', $model);
		
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
	            	$this->Session->setFlash('Versão alterada com sucesso!');
	            	
	            	// Redirecionando o usuário para a listagem dos registros
					$this->redirect(array('action' => 'index'));
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
				$this->Session->setFlash($mensagem_erros);
					
			}
		}
		
		
		/// Seta o request data com as informações que a Model possui.
		$this->request->data = $this->$model->read(null, $id);

	}
	/*  END EDIT */
	
	
	function mostrarversao() {
		$model = 'Androidversao';
		
        $this->autoRender = false ;
        $this->response->type('json');
        
    	$versao = $this->$model->find('first', array(
    											'order' => array(
													'id' => 'desc'
												),
    										));
        
        $resultado = array();
        if (!empty($versao)) {
             $resultado = array(
                 'android_versao' => $versao[$model]['versao'],
                 'url' => 'http://dashboardcopa14.com.br/new-update/'
             );
        } else {

             $resultado = array(
                 'android_versao' => 1,
                 'url' => 'http://dashboardcopa14.com.br/new-update/'
             );
        }
        //echo json_encode($login);
        $json = json_encode($resultado);
        $this->response->body($json);
	}

}
