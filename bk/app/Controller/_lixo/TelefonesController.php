<?
class TelefonesController extends AppController{
 	var $name = "Telefones";
	public $helpers = array('Html', 'Session', 'Form');
	public $uses = array('Telefone', 'Setor');
	//var $scaffold = 'admin';
	//var $transformUrl = array('url_amigavel' => 'titulo_ptbr');
	
	var $paginate = array(
	                        'limit'  => 5,
	                        'order'  => array(
	                                        'id' => 'DESC'
	                        ),

                        );

    //// Nescessário ter o beforeFilter
	function beforeFilter() {
		parent::beforeFilter();
		
		
		/// Descomentar verificação abaixo apenas quando utilizar Scaffold
		/*
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
                                    'id'	  	=> 'ID',
                                    'telefones' => 'Telefones',
                                 );
			$showImage	=	array(
								''
							);

			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);


			$this->set('schemaTable', $this->Telefone->schema());
		}
		*/
	}
	
	
	
	/* LIST */
	function admin_index(){
		$model = 'Telefone';
		$this->set('model', $model);
		
        
		//// Find de apoio à listagem. Filtro 
		//// Relacionamento: 
		////	- Empresa
		//==============================================================
		$this->set('setores', $this->$model->Setor->find('list', array(
																	'fields' => array(
																					'id',
																					'setor'
																						),
																	'conditions' => array(
																					'ativo' => 1
																							)
																					)
																	));
		//==============================================================
		
		
		
		//// FILTRO: 
		//==============================================================
		if (!empty($this->request->data['filtro']['Setores'])) {
			$ids_empresas = '';
			foreach($this->request->data['filtro']['Setores'] as $r){
				$ids_empresas = $ids_empresas.$r. ',';					
			}
			$sql_conteudo_id = "SELECT DISTINCT Telefone.id
								FROM tb_telefones as Telefone
								INNER JOIN tb_telefones_setores as TE ON (TE.telefone_id = Telefone.id)
								INNER JOIN tb_setores as Setor ON (TE.setor_id = Setor.id) 
								WHERE Setor.id IN (" .substr_replace($ids_empresas, '', -1, 1). ")";
					
			$conteudos = $this->$model->query($sql_conteudo_id);
						
			//////============>>>
			//Desmontar Array
			$conteudo_id = Set::classicExtract($conteudos, '{n}.Telefone.id');
			/////////////////
			
		 	$this->paginate['contain'] = array('Setor');
			$this->paginate['conditions'] = array(
													'Telefone.id' => $conteudo_id,
													);
		}
		//==============================================================
		
		
		$this->paginate['fields'] = array( 	
										'id',
										'telefones',
										'ativo'
									);
		$this->set('registros', $this->paginate($model));
	}
	/* END LIST */

	/*  ADD */
	function admin_add(){
		$model = 'Telefone';
		$this->set('model', $model);
		
        
		//// Find de apoio ao form. 
		//// Relacionamento: 
		////	- Empresa
		//==============================================================
		$this->set('setores', $this->$model->Setor->find('list', array(
																	'fields' => array(
																					'id',
																					'setor'
																						),
																	'conditions' => array(
																					'ativo' => 1
																							)
																					)
																	));
		//==============================================================
		
		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post')){
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				
				
			
				if (empty($this->request->data['Setor']['Setor'])) {
					$this->Session->setFlash('Favor informar quais são os setores que terão acesso a estes telefones.', 'default', array('class' => 'alert'));
				} else {
					
					/// Gravando dados na base de ados
		            if ($this->$model->save($this->request->data)){
						
						// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
			            $this->Session->setFlash('Telefones adicionados com sucesso!');
		            	
		            	// Redirecionando o usuário para a listagem dos registros
		                $this->redirect(array('action' => 'index', 'admin' => true));
		            }
		            
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

    }
    /* END ADD */

    /* EDIT */
	function admin_edit($id=null){
		$model = 'Telefone';
		$this->set('model', $model);
		
		/// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }
        
		//// Find de apoio ao form. 
		//// Relacionamento: 
		////	- Empresa
		//==============================================================
		$this->set('setores', $this->$model->Setor->find('list', array(
																	'fields' => array(
																					'id',
																					'setor'
																				),
																	'conditions' => array(
																					'ativo' => 1
																							)
																					)
																	));
		//==============================================================
																	
		
		
		/// Verifica se houve post e se foi de alteração
		if ($this->request->is('post') || $this->request->is('put')) {
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
			
			
			
				if (empty($this->request->data['Setor']['Setor'])) {
					$this->Session->setFlash('Favor informar quais são os setores que terão acesso a estes telefones.', 'default', array('class' => 'alert'));
				} else {
					

				
					/// Gravando dados na base de ados
					if($this->$model->save($this->request->data)){
						
						// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
		            	$this->Session->setFlash('Telefones alterados com sucesso!');
		            	
		            	// Redirecionando o usuário para a listagem dos registros
						$this->redirect(array('action' => 'index'));
					}
					
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
    	$model = 'Telefone';
    	
    	/// Segurança:
    	///=================================================
    	/// - Verifica se a requisição a este método está sendo feito por um post.
    	if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
    	/// - Verifica se o registro realmente existe.
        $this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }
    	///=================================================
    	
    	
    	
    	/// Apaga os registros da base de dados
        if ($this->$model->delete($id)) {
        
			// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
        	$this->Session->setFlash('Telefones excluídos com sucesso!');
        	
        	// Redirecionando o usuário para a listagem dos registros
        	$this->redirect(array('action' => 'index'));
        }
    }
    /* END DELETE */



}
