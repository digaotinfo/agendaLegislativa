<?
class NoticiasController extends AppController{
 	var $name = "Noticias";
	public $helpers = array('Html', 'Session', 'Form');
	public $uses = array('Noticia');
	var $scaffold = 'admin';
	//var $transformUrl = array('url_amigavel' => 'titulo_ptbr'); /* só utilizado em caso de Scaffold */
	
	var $paginate = array(
	                        'limit'  => 10,

                        );

    //// Nescessário ter o beforeFilter
	function beforeFilter() {
		parent::beforeFilter();
		
		
		/// Descomentar verificação abaixo apenas quando utilizar Scaffold
		/*
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
                                    'campo'	  	=> 'Nome do Campo',
                                    ...
                                 );
			$showImage	=	array(
								''
							);

			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);


			$this->set('schemaTable', $this->NomeDaModel->schema());
		}
		*/
	}
	
	
	
	
	/* LIST */
	function admin_index(){
		$model = 'Noticia';
		$this->set('model', $model);
		
		
		$this->paginate['fields'] = array(
										'Noticia.id',
										'Categoria.id',
										'Categoria.nome',
										'Noticia.titulo',
										'Noticia.chamada',
										'Noticia.ativo',
										'Noticia.created',
										'Noticia.modified',
									);




		
		
		///++++=====>>>> AREA DE BUSCA
		///====================================================================
		///====================================================================
		/// ==> Variáveis alocadas:
		$array_conditions = array();
		
		
		/// ==> Lista das Categorias existentes
		////////////////////////////////////////////////////////////////////
		$categorias = $this->$model->Categoria->find('list', array(
														'fields' => array(	'id',
																			'nome',
																		),
														'recursive' => -1
		));
		$this->set('categorias', $categorias);
		////////////////////////////////////////////////////////////////////
		

		/// ==> Find dos registros da categoria selecionada
		if (!empty($this->request->data['filtro']['categorias'])) {
			array_push($array_conditions, array('Noticia.categoria_id' => $this->request->data['filtro']['categorias']));
		}
		
		/// ==> Find dos campo de busca
		if (!empty($this->request->data['filtro']['busca'])) {
			array_push($array_conditions, array(
											'OR' => array(
												'Noticia.titulo like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Noticia.texto like "%'. $this->request->data['filtro']['busca'] .'%" ',
											),
										));
		}
		
		/// ==> Verifica se existe algo na busca
		if (!empty($array_conditions)) {
			$this->paginate['conditions'] = $array_conditions;
		}
		///====================================================================
		///====================================================================



		$this->set('registros', $this->paginate($model));
	}
	/* END LIST */

	/*  ADD */
	function admin_add(){
		$model = 'Noticia';
		$this->set('model', $model);

		$this->set('medidas_imagens', $this->$model->type_files);
		
		/// ==> Lista das Categorias existentes
		////////////////////////////////////////////////////////////////////
		$categorias = $this->$model->Categoria->find('list', array(
														'fields' => array(	'id',
																			'nome',
																		),
														'recursive' => -1
		));
		$this->set('categorias', $categorias);
		////////////////////////////////////////////////////////////////////



		///===> SETAR ID DA CATEGORIA JÁ PREVIAMENTE ESCOLHIDA
		////////////////////////////////////////////////////////////////////
		if (!empty($this->request->params['named'])) {
			if (!empty($this->request->params['named']['categoria_id'])) {
				$this->request->data[$model]['categoria_id'] = $this->request->params['named']['categoria_id'];
			}
		}
		////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////


		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post')){
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
			
				/// Gravando dados na base de ados
	            if ($this->$model->saveAll($this->request->data)){
					
					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
		            $this->Session->setFlash('Noticia adicionada com sucesso!');
	            	
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
				$this->Session->setFlash($mensagem_erros, 'default', array('class' => 'alert'));
					
			}   
        }

    }
    /* END ADD */

    /* EDIT */
	function admin_edit($id=null){
		$model = 'Noticia';
		$this->set('model', $model);
		
		$this->set('medidas_imagens', $this->$model->type_files);
		
		/// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }
        
		
		/// ==> Lista das Categorias existentes
		$categorias = $this->$model->Categoria->find('list', array(
														'fields' => array(	'id',
																			'nome',
																		),
														'recursive' => -1
		));
		$this->set('categorias', $categorias);
																	
		
		
		/// Verifica se houve post e se foi de alteração
		if ($this->request->is('post') || $this->request->is('put')) {
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				
				/// Gravando dados na base de ados
				if($this->$model->saveAll($this->request->data)){
					
					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
	            	$this->Session->setFlash('Noticia alterada com sucesso!');
	            	
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
				$this->Session->setFlash($mensagem_erros, 'default', array('class' => 'alert'));
					
			}
		}
		
		
		/// Seta o request data com as informações que a Model possui.
		$this->request->data = $this->$model->read(null, $id);

	}
	/*  END EDIT */

	/* DELETE     */
    function admin_delete($id){
    	$model = 'Noticia';
    	
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
			$this->Session->setFlash('Noticia excluída com sucesso!');
			
			// Redirecionando o usuário para a listagem dos registros
			$this->redirect(array('action' => 'index'));
		}
    	
    	
    }
    /* END DELETE */



}
