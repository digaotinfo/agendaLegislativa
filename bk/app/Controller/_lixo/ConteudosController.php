<?
App::import('Controller', 'Notificacoes');

class ConteudosController extends AppController{
	var $name = "Conteudos";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $uses = array('Conteudo', 'ConteudoSetor', 'Galeria', 'Mapa', 'Categoria', 'Setor', 'Pushfrase');
	var $scaffold = 'admin';
	//var $transformUrl = array('url_amigavel' => 'titulo_ptbr');
	var $paginate = array(
	                        'limit'  => 10,
	                        'order'  => array(
	                                        'id' => 'DESC'
	                        ),
	                        'contain' => array(
	                        	'Categoria',
	                        	'Setor'
	                        ),

                        );



	function beforeFilter() {
		parent::beforeFilter();

		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
                                    'id'	 => 'ID',
                                    'titulo' => 'Titulo',
                                    'texto'	 => 'Texto',
                                    'create' => 'Data'
								);
			$showImage	=	array(
								''
							);

			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);


			$this->set('schemaTable', $this->Setor->schema());
		}
	}
	
	function admin_index($categoria_id = null){
		$model = 'Conteudo';
		$this->set('model', $model);
		$this->set('categoria_id', $categoria_id);

		/// ==> Lista das Categorias existentes
		$categorias = $this->Categoria->find('list', array(
														'fields' => array(	'id',
																			'categoria',
																			)
		));

		$setores = $this->Setor->find('list', array(
														'fields' => array(
																		'id',
																		'setor'
																			),
														'conditions' => array(
																		'ativo' => 1
																				)
		));

		$this->set(array(
						'categorias' => $categorias,
						'setores' => $setores,
						//'Conteudoempresa' => $Conteudoempresa
		));

		//print_r($this->request->data);
		
		
		
		
		///++++=====>>>> AREA DE BUSCA
		///====================================================================
		///====================================================================
		/// Variáveis alocadas:
		$array_conditions = array();
		
		///====================================================================
		/// ==> Find dos registros de empresas selecionada
		if (!empty($this->request->data['filtro']['Setores'])) {
			$ids_setores = '';
			foreach($this->request->data['filtro']['Setores'] as $r){
				$ids_setores = $ids_setores.$r. ',';					
			}
			$sql_conteudo_id = "SELECT DISTINCT Conteudo.id
								FROM tb_conteudo as Conteudo
								INNER JOIN
								tb_conteudo_setores as CE ON (CE.conteudo_id=Conteudo.id)
								INNER JOIN
								tb_setores as Setor ON (CE.setor_id=Setor.id) WHERE Setor.id IN (" .substr_replace($ids_setores, '', -1, 1). ")";
					
			$conteudos = $this->$model->query($sql_conteudo_id);
						
			//////============>>>
			//Desmontar Array
			$conteudo_id = Set::classicExtract($conteudos, '{n}.Conteudo.id');
			/////////////////
			
			array_push($array_conditions, array('Conteudo.id' => $conteudo_id));
		}
		
		/// ==> Find dos registros da categoria selecionada
		if (!empty($this->request->data['filtro']['categorias'])) {
			array_push($array_conditions, array('Conteudo.categoria_id' => $this->request->data['filtro']['categorias']));
		}
		
		/// ==> Find dos campo de busca
		if (!empty($this->request->data['filtro']['busca'])) {
			array_push($array_conditions, array(
											'OR' => array(
												'Conteudo.titulo like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Conteudo.texto like "%'. $this->request->data['filtro']['busca'] .'%" ',
											),
										));
		}
		
		
		/// Verifica se existe algo na busca
		if (!empty($array_conditions)) {
			$this->paginate['conditions'] = $array_conditions;
		}
		
		///====================================================================
		///====================================================================
	
		$this->set('conteudos', $this->paginate($model));
		
	}

	//ADD
	function admin_add(){
		//print_r($this->request->data['Empresa']);
		//die();
	
		$model = 'Conteudo';
		$this->set('model', $model);


		$meses = array(
			'January' => 'Janeiro',
			'February' => 'Fevereiro',
			'March' => 'Março',
			'April' => 'Abril',
			'May' => 'Maio',
			'June' => 'Junho',
			'July' => 'Julho',
			'August' => 'Agosto',
			'September' => 'Setembro',
			'October' => 'Outubro',
			'November' => 'Novembro',
			'December' => 'Dezembro'
		);
		$this->set('meses', $meses);
		
		$dia_semana = array(
			'Monday' => 'Segunda-feira',
			'Tuesday' => 'Terça-feira',
			'Wednesday' => 'Quarta-feira',
			'Thursday' => 'Quinta-feira',
			'Friday' => 'Sexta-feira',
			'Saturday' => 'Sábado',
			'Sunday' => 'Domingo'
		);
		$this->set('dia_semana', $dia_semana);
		
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
		$this->set('categorias', $this->Categoria->find('list', array(
																'fields' => array(
																						'id',
																						'categoria'
																						),
																		)
																	));

		//print_r($this->request);
		//die();

		if ($this->request->is('post')) {
			
			$this->$model->set($this->request->data);
			if ($this->$model->validates()) {
				
				if (empty($this->request->data[$model]['categoria_id'])) {
					$this->Session->setFlash('Favor informar a categoria.', 'default', array('class' => 'alert'));
				} else {
					
					//print_r($this->request->data);
					//die();
					if (empty($this->request->data['Setor']['Setor'])) {
						$this->Session->setFlash('Favor informar quais são os setores que terão acesso a este conteúdo.', 'default', array('class' => 'alert'));
					} else {
						if ($this->$model->saveAll($this->request->data)){
		           		
				            	$this->Session->setFlash('Conteúdo adicionado com sucesso!');
				           		
				           		/// Realiza o Post para a controller de Notificacoes para enviar o Push.
				           		if ($this->request->data[$model]['enviarpush'] == '1') {
					           		$Notificacoes = new NotificacoesController;
					           		
									$Notificacoes->admin_enviarpushautomatizado($this->request->data[$model]['push_frase'], $this->request->data['Setor']);
									//$Notificacoes->admin_enviarpushandroid($this->request->data[$model]['push_frase'], $this->request->data['Setor']['Setor']);
									
									$this->Session->setFlash('Conteúdo adicionado e Notification enviado com sucesso!');
				           		}
				           		
				           		
					           	$this->redirect(array('action' => 'index', 'admin' => true));
			
			              }
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
    //END ADD

    //EDIT
	function admin_edit($id=null){
		$model = 'Conteudo';
		$this->set('model', $model);
		
		/// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }

		$meses = array(
			'January' => 'Janeiro',
			'February' => 'Fevereiro',
			'March' => 'Março',
			'April' => 'Abril',
			'May' => 'Maio',
			'June' => 'Junho',
			'July' => 'Julho',
			'August' => 'Agosto',
			'September' => 'Setembro',
			'October' => 'Outubro',
			'November' => 'Novembro',
			'December' => 'Dezembro'
		);
		$this->set('meses', $meses);
		
		$dia_semana = array(
			'Monday' => 'Segunda-feira',
			'Tuesday' => 'Terça-feira',
			'Wednesday' => 'Quarta-feira',
			'Thursday' => 'Quinta-feira',
			'Friday' => 'Sexta-feira',
			'Saturday' => 'Sábado',
			'Sunday' => 'Domingo'
		);
		$this->set('dia_semana', $dia_semana);


		$setores = $this->$model->Setor->find('list', array(
																'fields' => array(
																				'id',
																				'setor'
																			),
																'conditions' => array(
																				'ativo' => 1
																			)
															)
													);

		$categorias = $this->Categoria->find('list', array(
																'fields' => array(
																						'id',
																						'categoria'
																						),
																		)
																	);

		$this->set(array(
						'setores'  => $setores,
						'categorias' => $categorias
				));

		/// Verifica se houve post e se foi de alteração
		if ($this->request->is('post') || $this->request->is('put')) {
			
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);
			
			/// Verifica se a Model está válida. 
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				
	            if (empty($this->request->data[$model]['categoria_id'])) {
						$this->Session->setFlash('Favor informar a categoria.', 'default', array('class' => 'alert'));
				} else {
			
					if (empty($this->request->data['Setor']['Setor'])) {
						$this->Session->setFlash('Favor informar quais são os setores que terão acesso a este conteúdo.', 'default', array('class' => 'alert'));
					} else {

		           
	            
			            if ($this->$model->saveAll($this->request->data)){
			           		
			            	$this->Session->setFlash('Conteúdo alterado com sucesso!');
			           		
			           		/// Realiza o Post para a controller de Notificacoes para enviar o Push.
			           		if ($this->request->data[$model]['enviarpush'] == '1') {
				           		$Notificacoes = new NotificacoesController;
				           		
								$Notificacoes->admin_enviarpushautomatizado($this->request->data[$model]['push_frase'], $this->request->data['Setor']);
								//$Notificacoes->admin_enviarpushandroid($this->request->data[$model]['push_frase'], $this->request->data['Setor']['Setor']);
								
								$this->Session->setFlash('Conteúdo adicionado e Notification enviado com sucesso!');
			           		}
			           		
			           		
			                $this->redirect(array('action' => 'index', 'admin' => true));
		                }
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
	 //END EDIT

	//DELETE
    function admin_delete($id){
    	$model = 'Conteudo';
    	
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

        if ($this->$model->delete($id)) {
			$this->Session->setFlash('Conteúdo excluído com sucesso!');
        	$this->redirect(array('action' => 'index'));
        }
    }
    /* END DELETE */

	//VISUALIZAR
	function admin_visualizar($id){
		$model = 'Conteudo';
		$this->set('model', $model);
		
		/// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }

		$meses = array(
			'January' => 'Janeiro',
			'February' => 'Fevereiro',
			'March' => 'Março',
			'April' => 'Abril',
			'May' => 'Maio',
			'June' => 'Junho',
			'July' => 'Julho',
			'August' => 'Agosto',
			'September' => 'Setembro',
			'October' => 'Outubro',
			'November' => 'Novembro',
			'December' => 'Dezembro'
		);
		$dia_semana = array(
			'Monday' => 'Segunda-feira',
			'Tuesday' => 'Terça-feira',
			'Wednesday' => 'Quarta-feira',
			'Thursday' => 'Quinta-feira',
			'Friday' => 'Sexta-feira',
			'Saturday' => 'Sábado',
			'Sunday' => 'Domingo'
		);

		$this->set('meses', $meses);
		$this->set('dia_semana', $dia_semana); 

		$conteudoVisualizar = $this->$model->find('first', array(
																'conditions' => array($model.'.id' => $id),
															));

		$galeria = $this->Galeria->find('all', array(
													'fields' => array('id', 'conteudo_id', 'img_file', 'legenda'),
													'conditions' => array(
																		'Galeria.conteudo_id' => $id
																	)
												));

		$this->set(array(
						'conteudoVisualizar' => $conteudoVisualizar,
						'galerias' => $galeria
					));

	}
	//END VISUALIZAR

	//GALERIA
	function admin_galeria($id){
		$model = 'Galeria';
		$this->set('model', $model);
		$this->set('conteudo_id', $id);

		$this->set('medidas_imagens', $this->$model->info_files);

		$conteudo = $this->Conteudo->find('first', array(
															'fields' => array(
																			'Conteudo.titulo',
																		),
															'conditions' => array(
																			'Conteudo.id' => $id
																		),
															));

		$galeria = $this->$model->find('all', array(
														'fields' => array(
																	'id',
																	'conteudo_id',
																	'img_file',
																	'legenda',
																			),
														'conditions' => array(
																				'conteudo_id' => $id
																				),
														));
		$this->set(array(
							'conteudo' => $conteudo, 
							'galeria' => $galeria
						));


		if($this->request->is('post')){

			/////////////
			$this->$model->set($this->request->data);
			/////////////
			if($this->$model->validates()){
				if(!empty($this->request->data[$model]['img_file']['name'])){
					///////////////////////////
					// realiza o upload
					$a_files = array('img_file');
					foreach ($a_files as $inputFile):
						if ($this->request->data[$model][$inputFile]['name'] != '') {
							$this->request->data[$model][$inputFile] = $this->subirImagem($model, $inputFile, $inputFile, 'add', '');
							$this->request->data[$model][str_replace('_file','', $inputFile).'_th_hidden'] = $this->thumbPath($this->request->data[$model][$inputFile]);
						} else {
							$this->request->data[$model][$inputFile] = '';
						}
					endforeach;
					///////////////////////////
					//////////////////////////


					if($this->$model->saveAll($this->request->data)){
						$this->redirect(array('controller' => 'conteudos', 'action' => 'galeria', 'admin' => true, $id));
					}
				}else{
					echo "<script>alert('Selecione uma Imagem.')</script>";
				}
			}
		}


	}
	//END GALERIA

	//GALERIA DELETE
    function admin_galeriaDelete($id){
    	$model = 'Galeria';
    	
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

        if ($this->$model->delete($id)) {
        	$this->redirect(array('action' => 'visualizar'));
        }
    }/* END GALERIA DELETE */

    //EDIT LEGENDA
    function admin_edit_legenda($id){
    	$model = 'Galeria';
    	$this->set('model', $model);

		$imagem = $this->$model->find('first', array(
													'fields' => array(
																'id',
																'img_file',
																'legenda',
																'conteudo_id'
																	),
													'conditions' => array(
																		'id' => $id
																			)
														));

		$conteudo = $this->Conteudo->find('first', array(
															'fields' => array(
																			'Conteudo.titulo',
																		),
															'conditions' => array(
																			'Conteudo.id' => $imagem[$model]['conteudo_id']
																		),
															));

		$this->set(array(
							'imagem' 	=> $imagem,
							'conteudo' 	=> $conteudo,
						));

        $this->$model->id = $id;

	    if ($this->request->is($id)) {
        	$this->request->data = $this->$model->read();
        }else{
	        if($this->request->is('post')) {
				$this->$model->set($this->request->data);

				if ($this->$model->validates()) {
		            if ($this->$model->save($this->request->data[$model])){
		                $this->redirect(array('action' => 'galeria', 'admin' => true, $imagem[$model]['conteudo_id']));
	                }
		        }
	        }
	    }
    }//END EDIT LEGENDA

    
}
