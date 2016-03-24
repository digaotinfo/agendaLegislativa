<?
CakePlugin::load('MeioUpload');
App::uses('CakeEmail', 'Network/Email');

class PlsController extends AppController{
 	var $name = "Pls";
	public $helpers = array('Html', 'Session', 'Form', 'Time', 'Js');
	public $uses = array('Pl', 'Foco', 'OqueE', 'Situacao', 'NossaPosicao', 'StatusType', 'User', 'LogAtualizacaoPl', 'PlType', 'PlSituacao', 'Relatorio', 'Tema', 'AutorRelator', 'PlAutorRelator', 'Tarefa', 'TarefaPl', 'NotasTecnica');
	var $scaffold = 'admin';
	// var $transformUrl = array('url_amigavel' => 'numero_da_pl');

	var $paginate = array(
	                        'limit'  => 10,
                            'order' => array(
                                'id' => 'DESC'
                            )
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


    public function admin_add(){
        $model = 'Pl';
    		$this->set('model', $model);
            $tipos = $this->PlType->find('list', array(
                'fields' => array(
                    'id',
                    'tipo'
                ),
                'order' => array(
                    'id' => 'DESC'
                )
            ));
            $this->set('tipos', $tipos);

            $nossaPosicao = $this->StatusType->find('list', array(
                'fields' => array(
                    'id',
                    'status_name'
                )
            ));
            $this->set('nossaPosicao', $nossaPosicao);

            $temas = $this->Tema->find('list', array(
                'fields' => array(
                    'id',
                    'tema_name'
                ),
                'order' => array(
                    'id' => 'DESC'
                )
            ));
            $this->set('temas', $temas);


    		/// Verifica se houve post para salvar as informações
    		if ($this->request->is('post')){

    			/// Seta a model com as informações que vieram do post
    			$this->$model->set($this->request->data);

    			/// Verifica se a Model está válida.
    			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
    			if($this->$model->validates()){
                    if(!empty($this->request->data[$model]['arquivo'])){
                        $this->request->data[$model]['arquivo'] = 'uploads/arquivos_PLs/'.$this->request->data[$model]['arquivo'];
                    }

    				/// Gravando dados na Model Pai
                    $pl_salva = $this->$model->save($this->request->data);
                    $lastPlID = $this->$model->getLastInsertID();
                    $this->$model->id = $lastPlID;


                    //>>> verificar se ja existe este autor/relator
                    $requestAutor = $this->request->data[$model]['autor'];
                    $requestRelator = $this->request->data[$model]['relator'];

                    /*
                    *
                    * RequestAutor
                    */
                    if( !empty($requestAutor) ){
                        $buscarAutorRelator = $this->AutorRelator->find('first', array(
                            'conditions' => array(
                                'AutorRelator.nome' => $requestAutor
                            )
                        ));
                        if(!empty($buscarAutorRelator)):
                            $a_saveAutorRelator['Pl'] = array(
                                'numero_da_pl' => $this->request->data['Pl']['numero_da_pl'],
                                'autor_id' => $buscarAutorRelator['AutorRelator']['id'],
                            );

                            $this->Pl->save($a_saveAutorRelator);
                        else:
                            //>>> created new autor_relator
                            $a_saveAutorRelator['AutorRelator'] = array(
                                'nome' => $requestAutor,
                                'ativo' => 1
                            );
                            $this->AutorRelator->create();
                            $this->AutorRelator->save($a_saveAutorRelator);
                            $lastAutorRelatorID = $this->AutorRelator->getLastInsertID();


                            $a_saveAutorRelator['Pl'] = array(
                                'numero_da_pl' => $this->request->data['Pl']['numero_da_pl'],
                                'autor_id' => $lastAutorRelatorID,
                            );

                            $this->Pl->save($a_saveAutorRelator);
                        endif;
                    }

                    /*
                    *
                    * RequestRelator
                    */
                    if( !empty($requestRelator) ){
                        $buscarAutorRelator = $this->AutorRelator->find('first', array(
                            'conditions' => array(
                                'AutorRelator.nome' => $requestRelator
                            )
                        ));
                        if(!empty($buscarAutorRelator)):
                            $a_saveAutorRelator['Pl'] = array(
                                'numero_da_pl' => $this->request->data['Pl']['numero_da_pl'],
                                'relator_id' => $buscarAutorRelator['AutorRelator']['id'],
                            );

                            $this->Pl->save($a_saveAutorRelator);
                        else:
                            //>>> created new autor_relator
                            $a_saveAutorRelator['AutorRelator'] = array(
                                'nome' => $requestRelator,
                                'ativo' => 1
                            );
                            $this->AutorRelator->create();
                            $this->AutorRelator->save($a_saveAutorRelator);
                            $lastAutorRelatorID = $this->AutorRelator->getLastInsertID();


                            $a_saveAutorRelator['Pl'] = array(
                                'numero_da_pl' => $this->request->data['Pl']['numero_da_pl'],
                                'relator_id' => $lastAutorRelatorID,
                            );

                            $this->Pl->save($a_saveAutorRelator);
                        endif;
                    }


    	            if (!empty($pl_salva)){
                        /// Recuperando último ID da Model principal
                        $novo_id = $lastPlID;

                        /// Array com o nome das outras Models Relacionadas
                        $a_models = array("Foco", "OqueE", "Situacao", "NossaPosicao");
                        foreach ($a_models as $model_r) {

                            /// Setando o ID da Model Principal para criar o relacionamento
                            $this->request->data[$model_r]['pl_id'] = $novo_id;
                            /////*********************///////
                            ///====>>> setar campo da imagem aqui
                            /////*********************///////

                            /// Salvando a Model Relacionada com o ID da Principal
                            $this->$model->$model_r->save($this->request->data);
                        }
                    }

                    /*
                    * >>> Salvar log de criação
                    */
                    $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                    $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');
                    $this->request->data['LogAtualizacaoPl']['pl_id'] = $this->Pl->getInsertID();
                    $this->request->data['LogAtualizacaoPl']['model_id'] = 0;
                    $this->request->data['LogAtualizacaoPl']['tipo_id'] = $this->request->data['Pl']['tipo_id'];
                    $this->request->data['LogAtualizacaoPl']['nome_da_model'] = "Nova Proposição";
                    $this->request->data['LogAtualizacaoPl']['name_block'] = "Nova Proposição";
                    $this->request->data['LogAtualizacaoPl']['txt'] = "Nova Proposição";

                    $this->LogAtualizacaoPl->save($this->request->data);
                    /*
                    * <<< Salvar log de criação
                    */




    				// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
    	            $this->Session->setFlash('PL adicionada com sucesso!');

                	// Redirecionando o usuário para a listagem dos registros
                    $this->redirect(array('controller' => 'index', 'action' => 'index', 'admin' => true));

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

    public function admin_ver_completo($id=null){
        $model = 'Pl';
        $this->set('model', $model);
        $registro = $this->$model->find('first', array(
            'conditions' => array(
                'Pl.id' => $id
            ),
            'recursive' => 1
        ));

        $tipos = $this->PlType->find('list', array(
            'fields' => array(
                'id',
                'tipo'
            ),
            'order' => array(
                'id' => 'DESC'
            )
        ));
        $this->set('tipos', $tipos);



        $temas = $this->Tema->find('list', array(
            'fields' => array(
                'id',
                'tema_name'
            ),
            'order' => array(
                'id' => 'DESC'
            )
        ));
        $this->set('temas', $temas);

        $nossaPosicao = $this->StatusType->find('list', array(
            'fields' => array(
                'id',
                'status_name'
            )
        ));
        $this->set('nossaPosicao', $nossaPosicao);

        $usuariosLista = $this->User->find('list', array(
            'fields' => array(
                'id',
                'username'
            ),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => ''
            )
        ));
        $this->set('usuariosLista', $usuariosLista);

        /// Array com o nome das outras Models Relacionadas
        $a_models = array("Pl", "Foco", "OqueE", "Situacao", "NossaPosicao");

    	/// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }else{
            // $this->$model->recursive = 2;
            $proposicao = $this->$model->find('first', array(
                'conditions' => array(
                    'Pl.ativo' => 1,
                    'Pl.id' => $id
                ),
                'recursive' => 2
            ));

            $this->set('proposicao', $proposicao);
        }
        if ($this->request->is('post') || $this->request->is('put')){
  			/// Seta a model com as informações que vieram do post
  			$this->$model->set($this->request->data);

  			/// Verifica se a Model está válida.
  			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
  			if($this->$model->validates()):
                foreach ($a_models as $model_r) {
                    if(!empty($this->request->data[$model_r])):
                        /// Setando o ID da Model Principal para criar o relacionamento
                        $this->request->data[$model_r]['pl_id'] = $id;

                        if(!empty($this->request->data[$model_r]['txt'])){
                            $this->request->data[$model_r]['txt'] = $this->request->data[$model_r]['txt'];
                        }
                        if(!empty($this->request->data[$model_r]['arquivo'])){
                            $this->request->data[$model_r]['arquivo'] = $this->request->data[$model_r]['arquivo'];
                        }
                        $this->request->data[$model_r]['created'] = date("Y-m-d H:i:s");
                        $this->request->data[$model_r]['modified'] = date("Y-m-d H:i:s");

                        /// Salvando a Model Relacionada com o ID da Principal
                        if($model_r == 'Pl'){
                            /*
                            * HORA DA GAMBIARRA BISARRA...rsss
                            * NAO ME MPERGUNTE COMO SO SEI Q FUNCIONA...rsss
                            */

                            $requestAutor = $this->request->data['Autor']['nome'];
                            $requestRelator = $this->request->data['Relator']['nome'];

                            /*
                            *
                            * RequestAutor
                            */
                            if( !empty($requestAutor) ){
                                $buscarAutorRelator = $this->AutorRelator->find('first', array(
                                    'conditions' => array(
                                        'AutorRelator.nome' => $requestAutor
                                    )
                                ));
                                if(!empty($buscarAutorRelator)):
                                    $a_saveAutorRelator['Pl'] = array(
                                        'autor_id' => $buscarAutorRelator['AutorRelator']['id'],
                                    );

                                    $this->Pl->save($a_saveAutorRelator);
                                else:
                                    //>>> created new autor_relator
                                    $a_saveAutorRelator['AutorRelator'] = array(
                                        'nome' => $requestAutor,
                                        'ativo' => 1
                                    );
                                    $this->AutorRelator->create();
                                    $this->AutorRelator->save($a_saveAutorRelator);
                                    $lastAutorRelatorID = $this->AutorRelator->getLastInsertID();


                                    $a_saveAutorRelator['Pl'] = array(
                                        'autor_id' => $lastAutorRelatorID,
                                    );

                                    $this->Pl->save($a_saveAutorRelator);
                                endif;
                            }

                            /*
                            *
                            * RequestRelator
                            */
                            if( !empty($requestRelator) ){
                                $buscarAutorRelator = $this->AutorRelator->find('first', array(
                                    'conditions' => array(
                                        'AutorRelator.nome' => $requestRelator
                                    )
                                ));
                                if(!empty($buscarAutorRelator)):
                                    $a_saveAutorRelator['Pl'] = array(
                                        'relator_id' => $buscarAutorRelator['AutorRelator']['id'],
                                    );

                                    $this->Pl->save($a_saveAutorRelator);
                                else:
                                    //>>> created new autor_relator
                                    $a_saveAutorRelator['AutorRelator'] = array(
                                        'nome' => $requestRelator,
                                        'ativo' => 1
                                    );
                                    $this->AutorRelator->create();
                                    $this->AutorRelator->save($a_saveAutorRelator);
                                    $lastAutorRelatorID = $this->AutorRelator->getLastInsertID();


                                    $a_saveAutorRelator['Pl'] = array(
                                        'relator_id' => $lastAutorRelatorID,
                                    );

                                    $this->Pl->save($a_saveAutorRelator);
                                endif;
                            }


                            if(!empty($this->request->data[$model_r]['arquivo'])){
                                $notasExplode = explode('uploads/arquivos_PLs/', $this->request->data['Pl']['arquivo']);
                                if( !empty($notasExplode[1]) ){
                                    $this->request->data['Pl']['arquivo'] = 'uploads/arquivos_PLs/'.$notasExplode[1];
                                }else{
                                    $this->request->data[$model_r]['arquivo'] = 'uploads/arquivos_PLs/'.$this->request->data[$model_r]['arquivo'];
                                }
                            }
                            $this->request->data[$model_r]['tipo_id'] = $this->request->data[$model_r]['tipo_id'];

                            /*
                            * >>> Salvar log de edição
                            */
                            $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                            $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                            $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');
                            $this->request->data['LogAtualizacaoPl']['pl_id'] = $id;
                            $this->request->data['LogAtualizacaoPl']['model_id'] = $id;
                            $this->request->data['LogAtualizacaoPl']['tipo_id'] = $this->request->data['Pl']['tipo_id'];
                            $this->request->data['LogAtualizacaoPl']['nome_da_model'] = $model_r;
                            $this->request->data['LogAtualizacaoPl']['name_block'] = "";
                            $this->request->data['LogAtualizacaoPl']['txt'] = "";

                            $this->LogAtualizacaoPl->save($this->request->data);
                            /*
                            * <<< Salvar log de edição
                            */

                            $this->$model_r->save($this->request->data);

                        }else{
                            $this->$model->$model_r->save($this->request->data);
                        }
                    endif;
                }
            endif;
        }
        $this->request->data = $this->$model->read(null, $id);


        // echo '<pre>';
        // print_r($registro);
        // echo '</pre>';
        // die();
        $this->set('registro', $registro);
    }

    public function admin_ver_completo_edit_block($pl_id=null, $nameModel=null, $id=null, $tipo_id=null){
        $model = $nameModel;
        $this->autoRender = false;
    	/// Verifica se esse ID existe ou não
        if( ($nameModel == 'Foco') || ($nameModel == 'OqueE') || ($nameModel == 'NossaPosicao') ){
		    $this->$model->id = $id;
            $limit = 1;
        }else{
            $this->request->data[$model]['pl_id'] = $pl_id;
            $limit = '';
            // $limit = 5;
        }

        if ($this->request->is('post') || $this->request->is('put')){
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			if($this->$model->validates()):
                if(!empty($this->request->data[$model]['arquivo'])){
                    $this->request->data[$model]['arquivo'] = $this->request->data[$model]['arquivo'];
                }


                if($this->$model->save($this->request->data)){
                    // >>> LOG
                    if( ($nameModel == 'Foco') || ($nameModel == 'OqueE') || ($nameModel == 'NossaPosicao') ){
                        // $existe_este_log = $this->LogAtualizacaoPl->find('first', array(
                        //     'conditions' => array(
                        //         'pl_id' => $pl_id,
                        //         'nome_da_model' => $nameModel,
                        //         'model_id'  => $id
                        //     )
                        // ));
                        //
                        // if(!empty($existe_este_log)){
                        //     $this->LogAtualizacaoPl->id = $existe_este_log['LogAtualizacaoPl']['id'];
                        // }

                        $this->request->data['LogAtualizacaoPl']['pl_id'] = $pl_id;
                        $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                        $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');
                        $this->request->data['LogAtualizacaoPl']['model_id'] = $id;
                        $this->request->data['LogAtualizacaoPl']['tipo_id'] = $tipo_id;
                        $this->request->data['LogAtualizacaoPl']['nome_da_model'] = $nameModel;
                        $this->request->data['LogAtualizacaoPl']['name_block'] = $this->request->data[$nameModel]['name_block'];
                        $this->request->data['LogAtualizacaoPl']['txt'] = $this->request->data[$nameModel]['txt'];

                        $this->LogAtualizacaoPl->save($this->request->data);
                    }else{
                        $this->request->data['LogAtualizacaoPl']['pl_id'] = $pl_id;
                        $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                        $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');
                        $this->request->data['LogAtualizacaoPl']['model_id'] = $this->$model->getLastInsertId();
                        $this->request->data['LogAtualizacaoPl']['tipo_id'] = $tipo_id;
                        $this->request->data['LogAtualizacaoPl']['nome_da_model'] = $nameModel;
                        $this->request->data['LogAtualizacaoPl']['name_block'] = $this->request->data[$nameModel]['name_block'];
                        $this->request->data['LogAtualizacaoPl']['txt'] = $this->request->data[$nameModel]['txt'];
                        if(!empty($this->request->data[$nameModel]['arquivo'])):
                            $this->request->data['LogAtualizacaoPl']['arquivo'] = 'uploads/arquivos_PLs/'.$this->request->data[$nameModel]['arquivo'];
                        endif;

                        $this->LogAtualizacaoPl->save($this->request->data);
                    }
                    // <<< LOG

                    $result = $this->Foco->LogAtualizacaoPl->find('all', array(
                        'conditions' => array(
                            'pl_id' => $pl_id,
                            'LogAtualizacaoPl.nome_da_model' => $model
                        ),
                        'recursive' => 2,
                        'limit' => $limit,
                        'order' => array(
                            'Pl.id' => 'DESC',
                            'LogAtualizacaoPl.id' => 'DESC'
                        ),
                    ));
                    return json_encode($result);
                    die();
                }else{
                    echo false;
                    die();
                }
            endif;
        }
        $this->request->data = $this->$model->read(null, $id);
    }

    public function admin_ver_completo_add_tarefa($pl_id=null){
        // $model = $nameModel;
        $this->autoRender = false;

        // print_r($this->request->data);
        // die();
        if( ($this->request->data['nameModel'] == 'Tarefa')  ){
            $model = 'Tarefa';
            $this->request->data['Tarefa'] = $this->request->data;
            $dataEntrega = $this->formatDateBD($this->request->data['Tarefa']['entrega']);
            $this->request->data['Tarefa']['entrega'] = $dataEntrega;
            $this->request->data['Tarefa']['pl_id'] = $pl_id;
        }

        // print_r($this->request->data);
        // die();

        if ($this->request->is('post') || $this->request->is('put')){
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			if($this->$model->validates()):

                if($this->$model->save($this->request->data)){
                    $lastTarefaID = $this->$model->getLastInsertID();
                    // $a_tarefaPl = array(
                    //     'tarefa_id' => $lastTarefaID,
                    //     'pl_id' => $pl_id
                    // );
                    // $this->TarefaPl->create();
                    // $this->TarefaPl->save($a_tarefaPl);
                    // >>> LOG
                    if( ($model == 'Tarefa') ){
                        $this->request->data['LogAtualizacaoPl']['pl_id'] = $pl_id;
                        $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                        $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');
                        $this->request->data['LogAtualizacaoPl']['model_id'] = $lastTarefaID;
                        $this->request->data['LogAtualizacaoPl']['nome_da_model'] = $model;
                        $this->request->data['LogAtualizacaoPl']['name_block'] = $this->request->data[$model]['nameBlock'];
                        $this->request->data['LogAtualizacaoPl']['txt'] = $this->request->data[$model]['descricao'];

                        $this->LogAtualizacaoPl->save($this->request->data);
                    }
                    // <<< LOG
                    $result = $this->Tarefa->find('all', array(
                        'conditions' => array(
                            'Tarefa.pl_id' => $pl_id
                        ),
                        'order' => array(
                            'Tarefa.entrega' => 'ASC'
                        )
                    ));
                    array_unshift($result, array(
                        'lastIDTarefa' => $lastTarefaID
                    ));
                    return json_encode($result);
                    die();
                }else{
                    echo false;
                    die();
                }
            endif;
        }
        $this->request->data = $this->$model->read(null, $id);
    }


    public function admin_ver_completo_edit_tarefa( $id=null ){
        $this->autoRender = false;
        $model      = $this->request->data['nameModel'];
        $idTarefa   = $this->request->data['idDaTarefa'];
        $nameBlock  = $this->request->data['nameBlock'];
        $idProposicao  = $id;
    	/// Verifica se esse ID existe ou não
        if( ($model == 'Tarefa') ){
            $model = "Tarefa";
		    $this->$model->id = $idTarefa;
            $this->request->data['Tarefa'] = $this->request->data;

            $dataEntrega = $this->formatDateBD($this->request->data['Tarefa']['entrega']);
            $this->request->data['Tarefa']['entrega'] = $dataEntrega;
        }

        if ($this->request->is('post') || $this->request->is('put')){
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			if($this->$model->validates()):


                if($this->$model->save($this->request->data)){

                    if( ($model == 'Tarefa') ){
                        $this->request->data['LogAtualizacaoPl']['pl_id'] = $id;
                        $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                        $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                        $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');
                        $this->request->data['LogAtualizacaoPl']['model_id'] = $id;
                        // $this->request->data['LogAtualizacaoPl']['tipo_id'] = $tipo_id;
                        $this->request->data['LogAtualizacaoPl']['nome_da_model'] = $model;
                        $this->request->data['LogAtualizacaoPl']['name_block'] = $nameBlock;
                        $this->request->data['LogAtualizacaoPl']['txt'] = $this->request->data['Tarefa']['titulo'];

                        $this->LogAtualizacaoPl->save($this->request->data);
                    }

                    return json_encode(true);
                    die();
                }else{
                    echo false;
                    die();
                }
            endif;
        }
        $this->request->data = $this->$model->read(null, $id);
    }

    public function admin_ver_completo_tarefa_enviar_email($idTarefa=null){
        $this->autoRender = false;
        $model = 'Tarefa';
        $tarefa = $this->$model->find('first', array(
            'conditions' => array(
                'Tarefa.id' => $idTarefa
            ),
            'recursive' => 2
        ));


        $poposicao = $tarefa['Pl']['PlType']['tipo']. ' ' .$tarefa['Pl']['numero_da_pl']. '/' .$tarefa['Pl']['ano'];
        $tarefaTitulo = $tarefa[$model]['titulo'];
        $tarefaDescricao = $tarefa[$model]['descricao'];
        $tarefaEntregarDia = date('d/m/Y',strtotime( $tarefa[$model]['entrega']));
        $tarefaAlterada = date('d/m/Y \á\s H:i',strtotime( $tarefa[$model]['modified']));
        $logoTop = 'http://abear.com.br/uploads/img/logo/header_logo-abear.png';
        $tituloDoEmail = 'Atualização de Tarefa';

        $allUsersAdmin = $this->User->find('all', array(
            'fields' => array('id', 'email', 'name'),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => '',
                'User.role_id' => 1,
            )
        ));

        if( !empty($allUsersAdmin) ){
            foreach( $allUsersAdmin as $user ){
                $nome = $user['User']['name'];
                $msg = '

                        <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
                        <tbody>
                        <tr>
                        <td align="left" width="130">
                        <img src="'.$logoTop.'">
                        </td>
                        <td colspan="2">
                        <table style="background-color: #ffd600 !important;" height="115" width="570">
                        <tbody>
                        <tr>
                        <td align="center" style="font-size: 24px;text-transform: uppercase;font-weight: 500;color: #000;">
                        <strong>Agenda Legislativa</strong>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </td>
                        </tr>
                        </tbody>
                        </table>

                        <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
                            <tbody>
                                <tr>
                                    <td>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <table cellpadding="0" cellspacing="0" width="600" align="center">
                                            <tbody>
                                                <tr>
                                                    <td height="100">
                                                    <p style="font-size: 18px;color: #000;">
                                                    Olá <strong>'.$nome.'.</strong>
                                                    </p>
                                                    <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <p style="font-size: 16px;color:#747474">
                                                        <strong>'.$poposicao.'</strong> foi alterada.<br>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><strong>Ação ABEAR</strong> atualizada em '.$tarefaAlterada.'Hs.</p>
                                                        <p style="font-size: 16px;color:#747474">
                                                            <strong>'.$tarefaTitulo.'</strong><br><br>
                                                            '.$tarefaDescricao.'
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <br>
                                                        <p>
                                                            Deverá ser realizada até: '.$tarefaEntregarDia.'
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                ';


                $this->envio_email($user['User']['email'], $tituloDoEmail, $msg);
            }
            return true;
        }else{
            return false;
        }

    }

    public function admin_autocomplete(){
        $this->autoRender = false;
        $model = 'AutorRelator';

        $result = $this->$model->find('all', array(
            'fields' => array(
                $model.'.nome'
            )
        ));

        $nomes = array();
        for($i=0; $i<count($result); $i++){
            array_push($nomes, $result[$i][$model]['nome']);
        }

        $uniqueRegistro = $nomes;
        echo json_encode($uniqueRegistro);
    }

    public function admin_enviar_atualizacao_pl_por_email($pl_id=null, $nameModel=null, $idLog=null, $nameBlock=null){
        $this->autoRender = false;
        $model = $nameModel;
        $pl = $this->Pl->find('first', array(
            'fields' => array('Pl.id', 'PlType.tipo', 'Pl.numero_da_pl', 'Pl.ano'),
            'conditions' => array(
                'Pl.id' => $pl_id
            )
        ));

        $logAtualizacao = $this->LogAtualizacaoPl->find('first', array(
            'fields' => array('id', 'usuario_nome', 'txt', 'modified'),
            'conditions' => array(
                'LogAtualizacaoPl.id' => $idLog
            )
        ));


        //>>> PEGANDO OS IDS DE USUARIOS
        $a_ids = '';
        $last_key = end(array_keys($this->request->data['idUsuarios']));

        $countArray = count($this->request->data['idUsuarios']);
        foreach($this->request->data['idUsuarios'] as $key => $idUsuarios){
            if ($key != $last_key) {
                $a_ids = $a_ids.$this->request->data['idUsuarios'][$key].', ';
            }else{
                $a_ids = $a_ids.$this->request->data['idUsuarios'][$key];
            }
        }
        //<<< PEGANDO OS IDS DE USUARIOS





        $allUsers = $this->User->find('all', array(
            'fields' => array('id', 'email', 'name'),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => '',
                "User.id in ({$a_ids})",
            )
        ));

        $logoTop = 'http://abear.com.br/uploads/img/logo/header_logo-abear.png';
        $tituloDoEmail = 'Atualização de PL';
        foreach($allUsers as $user){
            $email = $user['User']['email'];
            if($this->validaEmail($email)){
                $nome = $user['User']['name'];
                $PlNumero = $pl['PlType']['tipo'].' '.$pl['Pl']['numero_da_pl'].'/'.$pl['Pl']['ano'];
                $PlTxt = $logAtualizacao['LogAtualizacaoPl']['txt'];
                $PlUsuarioQueAlterou = $logAtualizacao['LogAtualizacaoPl']['usuario_nome'];
                $PlAlteradaEm = date('d/m/Y à\s H:i',strtotime($logAtualizacao['LogAtualizacaoPl']['modified']));
                $PlVerCompleto = Router::url('/ver-pl/'.$pl['Pl']['id'], true);

                $msg = '

                    <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
                        <tbody>
                            <tr>
                                <td align="left" width="130">
                                    <img src="'.$logoTop.'">
                                </td>
                                <td colspan="2">
                                    <table style="background-color: #ffd600 !important;" height="115" width="570">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="font-size: 24px;text-transform: uppercase;font-weight: 500;color: #000;">
                                                    <strong>Agenda Legislativa</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                    <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
                        <tbody>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <table cellpadding="0" cellspacing="0" width="600" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="100">
                                                    <p style="font-size: 18px;color: #000;">
                                                        Olá <strong>'.$nome.'.</strong>
                                                    </p>
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p style="font-size: 16px;color:#747474">
                                                        <strong>'.$PlNumero.'</strong> foi alterada.<br>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>'.$PlUsuarioQueAlterou.' realizou uma alteração em '.$PlAlteradaEm.'Hs.</p>
                                                    <p style="font-size: 16px;color:#747474">
                                                        <strong>'.$nameBlock.'</strong><br><br>
                                                        '.$PlTxt.'
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <br>
                                                    <p>
                                                        <a href="'.$PlVerCompleto.'" style="border-style: solid;border-width: 0px;cursor: pointer;font-weight: normal;line-height: normal;margin: 0 0 1.25rem;position: relative;text-decoration: none;text-align: center;display: inline-block;padding-top: 1rem;padding-right: 2rem;padding-bottom: 1.0625rem;padding-left: 2rem;font-size: 1.2rem;background-color: #2E7D32;border-color: #097b61;color: white;-moz-transition: background-color 300ms ease-out;transition: background-color 300ms ease-out;padding-top: 1.0625rem;padding-bottom: 1rem;-webkit-appearance: none;font-weight: normal !important;-moz-border-radius: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
                                                            Ver Alteração
                                                        </a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                ';
                $this->envio_email($email, $tituloDoEmail, $msg);
            }
        }
        $this->LogAtualizacaoPl->id = $logAtualizacao['LogAtualizacaoPl']['id'];
        $this->LogAtualizacaoPl->saveField('enviado_por_email', true);
        return true;

    }

    public function admin_enviar_atualizacao_pl_generica_por_email($pl_id=null){
        $this->autoRender = false;

        $pl = $this->Pl->find('first', array(
            'fields' => array('Pl.id', 'PlType.tipo', 'Pl.numero_da_pl', 'Pl.ano'),
            'conditions' => array(
                'Pl.id' => $pl_id
            )
        ));

        $logAtualizacao = $this->LogAtualizacaoPl->find('first', array(
            'fields' => array('id', 'usuario_nome', 'txt', 'modified'),
            'conditions' => array(
                'LogAtualizacaoPl.pl_id' => $pl_id,
            ),
            'order' => array(
                'LogAtualizacaoPl.id' => 'DESC',
            )
        ));

        // print_r($logAtualizacao);
        // echo "teste";
        // die();

        //>>> PEGANDO OS IDS DE USUARIOS
        $a_ids = '';
        $last_key = end(array_keys($this->request->data['idUsuarios']));

        $countArray = count($this->request->data['idUsuarios']);
        foreach($this->request->data['idUsuarios'] as $key => $idUsuarios){
            if ($key != $last_key) {
                $a_ids = $a_ids.$this->request->data['idUsuarios'][$key].', ';
            }else{
                $a_ids = $a_ids.$this->request->data['idUsuarios'][$key];
            }
        }
        //<<< PEGANDO OS IDS DE USUARIOS





        $allUsers = $this->User->find('all', array(
            'fields' => array('id', 'email', 'name'),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => '',
                "User.id in ({$a_ids})",
            )
        ));


        $logoTop = 'http://abear.com.br/uploads/img/logo/header_logo-abear.png';
        $tituloDoEmail = 'Atualização de PL';

        foreach($allUsers as $user){
            $email = $user['User']['email'];
            if($this->validaEmail($email)){
                $nome = $user['User']['name'];
                $PlNumero = $pl['PlType']['tipo'].' '.$pl['Pl']['numero_da_pl'].'/'.$pl['Pl']['ano'];
                $PlTxt = $logAtualizacao['LogAtualizacaoPl']['txt'];
                $PlUsuarioQueAlterou = $logAtualizacao['LogAtualizacaoPl']['usuario_nome'];
                $PlAlteradaEm = date('d/m/Y à\s H:i',strtotime($logAtualizacao['LogAtualizacaoPl']['modified']));
                $PlVerCompleto = Router::url('/ver-pl/'.$pl['Pl']['id'], true);

                $msg = '

                    <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
                        <tbody>
                            <tr>
                                <td align="left" width="130">
                                    <img src="'.$logoTop.'">
                                </td>
                                <td colspan="2">
                                    <table style="background-color: #ffd600 !important;" height="115" width="570">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="font-size: 24px;text-transform: uppercase;font-weight: 500;color: #000;">
                                                    <strong>Agenda Legislativa</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                    <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
                        <tbody>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <table cellpadding="0" cellspacing="0" width="600" align="center">
                                        <tbody>
                                            <tr>
                                                <td height="100">
                                                    <p style="font-size: 18px;color: #000;">
                                                        Olá <strong>'.$nome.'.</strong>
                                                    </p>
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <p style="font-size: 16px;color:#747474">
                                                        <strong>'.$PlNumero.'</strong> foi alterada.<br>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <br>
                                                    <p>
                                                        <a href="'.$PlVerCompleto.'" style="border-style: solid;border-width: 0px;cursor: pointer;font-weight: normal;line-height: normal;margin: 0 0 1.25rem;position: relative;text-decoration: none;text-align: center;display: inline-block;padding-top: 1rem;padding-right: 2rem;padding-bottom: 1.0625rem;padding-left: 2rem;font-size: 1.2rem;background-color: #2E7D32;border-color: #097b61;color: white;-moz-transition: background-color 300ms ease-out;transition: background-color 300ms ease-out;padding-top: 1.0625rem;padding-bottom: 1rem;-webkit-appearance: none;font-weight: normal !important;-moz-border-radius: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
                                                            Ver Alteração
                                                        </a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                ';
                $this->envio_email($email, $tituloDoEmail, $msg);
            }
        }
        $this->LogAtualizacaoPl->id = $logAtualizacao['LogAtualizacaoPl']['id'];
        $this->LogAtualizacaoPl->saveField('enviado_por_email', true);
        return true;

    }

    public function envio_email($email_to=null, $title=null, $msg=null) {
    	$this->autoRender = false;

        $Email = new CakeEmail();
    		$Email->emailFormat('html');
    		$Email->from(array('nao-responda@zoio.net.br' => 'Agenda Legislativa ABEAR'));
    		$Email->to($email_to);
    		$Email->subject($title);
    		$Email->send($msg);
    }

    /* DELETE     */
    function admin_delete($id){
        $this->autoRender = false;
        $model = 'Pl';

        /// Segurança:
        ///=================================================
        /// - Verifica se a requisição a este método está sendo feito por um post.
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        /// Apaga os registros da base de dados

        $this->$model->read(null, $id);
        $this->$model->set(array(
              'delete' => true,
        ));
        if ($this->$model->save()) {
            $result = array('sucess' => true);
            return json_encode($result);
        }


    }
    /* END DELETE */


    /* DELETE     */
    function admin_deleteNT($id = null, $pl_id=null){
        $this->autoRender = false;
        $model = 'NotasTecnica';

		//===-----> Apoio View
		$this->set('model', $model);
		//==----------------------------------------

        $this->$model->id = $id;

        if ($this->$model->delete()) {
            $this->Session->setFlash(__('Nota Tecnica excluída com sucesso.'));
            if( !empty($pl_id) ){
                return true;
            }
        }else{
            return false;
        }

    }
    /* END DELETE */

    public function validaEmail($email){
        $conta = "^[a-zA-Z0-9\._-]+@";
        $domino = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$";
        $pattern = $conta.$domino.$extensao;
        if (ereg($pattern, $email)){
            return true;
        }else{
            return false;
        }
    }

    public function format_date($date=null){
        $date = explode(" ",$date);
        $_texto_para_mes = array(
            'Janeiro' => '01',
            'Fevereiro' => '02',
            'Março' => '03',
            'Abril' => '04',
            'Maio' => '05',
            'Junho' => '06',
            'Julho' => '07',
            'Agosto' => '08',
            'Setembro' => '09',
            'Outubro' => '10',
            'Novembro' => '11' ,
            'Dezembro' => '12'
        );

        $texto = substr($date[1], 0, -1);
        if($date[0] < 10){
            $date[0] = '0'.$date[0];
        }
        $formatDateFinal = $date[2].'/'.$_texto_para_mes[$texto].'/'.$date[0];
        // $formatDateFinal = $date[0].'/'.$_texto_para_mes[$texto].'/'.$date[2];

        return $formatDateFinal;
    }
    public function formatDateBD($date=null){
        $date = explode(" ",$date);

        $_texto_para_mes = array(
            'Janeiro' => '01',
            'Fevereiro' => '02',
            'Março' => '03',
            'Abril' => '04',
            'Maio' => '05',
            'Junho' => '06',
            'Julho' => '07',
            'Agosto' => '08',
            'Setembro' => '09',
            'Outubro' => '10',
            'Novembro' => '11' ,
            'Dezembro' => '12'
        );

        $texto = substr($date[1], 0, -1);
        if($date[0] < 10){
            $date[0] = '0'.$date[0];
        }
        $formatDateFinal = $date[2].'-'.$_texto_para_mes[$texto].'-'.$date[0];
        // $formatDateFinal = $date[0].'/'.$_texto_para_mes[$texto].'/'.$date[2];

        return $formatDateFinal;
    }

    public function admin_buscarContent($id=null){
        $this->autoRender = false;
        $model = $this->request->data["nameModel"];
        if( !empty($this->request->data["idTarefa"]) ){
            $idTarefa = $this->request->data["idTarefa"];
        }

        if( ($model == 'TarefaPl') ){
            $resultBusca = $this->$model->find('first', array(
                'fields' =>array(
                    // $model.'.pl_id',
                    // $model.'.txt'
                ),
                'conditions' => array(
                    $model.'.pl_id' => $id,
                    $model.'.tarefa_id' => $idTarefa,
                ),
            ));

            if(!empty($resultBusca)){
                return json_encode($resultBusca);
                die();
            }else{
                return json_encode("");
                die();
            }
        }else{
            $resultBusca = $this->$model->find('first', array(
                'fields' =>array(
                    $model.'.pl_id',
                    $model.'.txt'
                ),
                'conditions' => array(
                    $model.'.pl_id' => $id
                ),
                "recursive" => -2
            ));

            if(!empty($resultBusca)){
                return json_encode($resultBusca);
                die();
            }else{
                return json_encode("");
                die();
            }
        }
    }
}
