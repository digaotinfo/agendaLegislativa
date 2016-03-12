<?
class FluxogramasController extends AppController {
	public $name 	= 'Fluxogramas';
	public $helpers = array('Html', 'Session', 'Paginator', 'Time', 'Text');
	public $uses 	= array('Fluxograma', 'Pl', 'PlType', 'FluxogramaEtapa', 'FluxogramaSubEtapa', 'LogAtualizacaoPl');

	public $paginate = array(
		'limit' => 10,
	);

	function beforeFilter() {
		parent::beforeFilter();

	}

    public function admin_index($pl_id=null){
        $model = 'Pl';
        $this->set('model', $model);
		if( empty($pl_id) ){
			$pl_id = 0;
		}
		/*
		*
		* localizar proposição
		*/
		$prop = $this->$model->find('first', array(
			'conditions' => array(
				'Pl.id' => $pl_id
			),
			'fields' => array(
				'PlType.id',
				'PlType.tipo',
				'Pl.numero_da_pl',
				'Pl.ano',
				'Pl.id',
				'Pl.etapa_id',
				'Pl.subetapa_id',
				'Pl.modified',
				'FluxogramaEtapa.id',
				'FluxogramaEtapa.etapa',
				'FluxogramaEtapa.descricao',
				'FluxogramaEtapa.ordem',
			),
			'recursive' => -2
		));
		$this->set('proposicao', $prop);

			$registros = $this->PlType->find('first', array(
			'fields' => array(
				'PlType.id',
				'PlType.tipo',
			),
			'conditions' => array(
				'PlType.id' => $prop['PlType']['id']
			),
			'recursive' => 2,
		));
		$this->set(array(
			'registros' => $registros,
		));
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////


		$etapas = $this->FluxogramaEtapa->find('list', array(
			'fields' => array('id', 'etapa'),
			'conditions' => array(
				'FluxogramaEtapa.pl_type_id' => $prop['PlType']['id']
			)
		));
		$this->set('etapas', $etapas);


		/*
		*
		*
		* historico >>>
		*/
		$historico = $this->Fluxograma->find('all', array(
			'fields' => array(
				'PlType.id',
				'PlType.tipo'
			),
			'conditions' => array(
				'Fluxograma.pl_id' => $pl_id,
				"NOT" => array(
					'Fluxograma.tipo_id' => $prop['PlType']['id'],
				)
			),
			'group' => array('Fluxograma.tipo_id'),
			'order' => array(
				'Fluxograma.id' => 'DESC'
			)
		));

		$a_idsPlType = '';
		foreach( $historico as $index => $idHistorico ){
			$index++;
			if( count($historico) == $index++ ){
				$a_idsPlType = $a_idsPlType.$idHistorico['PlType']['id'];
			}else{
				$a_idsPlType = $a_idsPlType.$idHistorico['PlType']['id'].',';
			}
		}
		$a_idsPlType = explode(',', $a_idsPlType);

		$historicoRegistros = $this->PlType->find('all', array(
			'fields' => array(
				'PlType.id',
				'PlType.tipo',
			),
			'conditions' => array(
				'PlType.id' => $a_idsPlType
			),
			'order' => array(
				'PlType.id' => 'ASC'
			),
			'recursive' => 2,
		));
		$this->set(array(
			'historicoRegistros' => $historicoRegistros,
		));

		$settarUltimaPosicaoOrdem = 0;
		if( $this->request->is('post') ){
			if( !empty($pl_id) ){
				if( !empty($this->request->data['FluxogramaEtapa']['fluxo_etapa_id']) && !empty($this->request->data['FluxogramaEtapa']['fluxo_log_origem_id']) ):
					$fluxogramaEtapaOrdem = $this->TbFluxoLogOrigemPlTbFluxoEtapa->find('all', array(
													'conditions' => array(
														'fluxo_log_origem_id' => $this->request->data['FluxogramaEtapa']['fluxo_log_origem_id']
													),
													'order' => array('ordem' => 'DESC')
												));
					$settarUltimaPosicaoOrdem = $fluxogramaEtapaOrdem[0]['TbFluxoLogOrigemPlTbFluxoEtapa']['ordem']+1;
					$a_save['FluxogramaEtapaLogFluxo'] = array(
						'fluxo_etapa_id' 		=> $this->request->data['FluxogramaEtapa']['fluxo_etapa_id'],
						'fluxo_log_origem_id' 	=> $this->request->data['FluxogramaEtapa']['fluxo_log_origem_id'],
						'ordem' 				=> $settarUltimaPosicaoOrdem
					);
					$this->TbFluxoLogOrigemPlTbFluxoEtapa->create();
					$this->TbFluxoLogOrigemPlTbFluxoEtapa->save($a_save['FluxogramaEtapaLogFluxo']);

					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
					$this->Session->setFlash('Etapa de Fluxograma adicionada com sucesso!');

					// // Redirecionando o usuário para o fluxograma
					$this->redirect(array('controller' => 'fluxogramas', 'action' => 'index', 'admin' => true, $pl_id ));

				else:
					/*
					*
					* salvando nova Sub-etapa para determinada proposicao >>>
					*/
					if( !empty($this->request->data['FluxogramaNovaSubEtapa']) ){
						$etapa_id = $this->request->data['FluxogramaNovaSubEtapa']['etapa_id'];
						$subEtapa = $this->request->data['FluxogramaNovaSubEtapa']['subetapa'];
						$descricao = $this->request->data['FluxogramaNovaSubEtapa']['descricao'];
						if( !empty($subEtapa) && !empty($descricao) ){
							$a_save['FluxogramaNovaSubEtapa'] = array(
								'subetapa' 		 => $subEtapa,
								'descricao' 	 => $descricao
							);
							$this->FluxogramaSubEtapa->create();
							$this->FluxogramaSubEtapa->save($a_save['FluxogramaNovaSubEtapa']);

							$lastIdSubEtapa = $this->FluxogramaSubEtapa->getLastInsertID();

							// Relacionamento para mostrar a sub-etapa ligada a esta etapa_id  >>>
							$a_save['FluxogramaEtapa_SubEtapaLog'] = array(
								'subetapa_id' 	=> $lastIdSubEtapa,
								'etapa_id' 	 	=> $etapa_id
							);
							$this->TbFluxoLogetapaSubetapa->create();
							$this->TbFluxoLogetapaSubetapa->save($a_save['FluxogramaEtapa_SubEtapaLog']);
							// >>> Relacionamento para mostrar a sub-etapa ligada a esta etapa_id

							// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
							$this->Session->setFlash('Sub-Etapa adicionada com sucesso!');

							// // Redirecionando o usuário para o fluxograma
							$this->redirect(array('controller' => 'fluxogramas', 'action' => 'index', 'admin' => true, $pl_id ));
						}
					}
					/*
					*
					* <<< salvando nova Sub-etapa para determinada proposicao
					*/

				endif;
			}
		}

		$this->set('pl_id', $pl_id);
	}


	/*
	*
	* Listar Tipos >>>
	*/
	public function admin_fluxogramaTipos( $tipo_id=null ){
		$model = "PlType";
		$this->set('model', $model);

		$this->paginate = array(
			'fields' => array(
				'PlType.id',
				'PlType.tipo',
				'PlType.ativo',
			),
			'order' => array(
				'id' => 'DESC'
			),
			'recursive' => -2
		);
		// >>> FILTRO
        $conditions = array();
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    $model.'.tipo Like' => '%'.$buscar.'%',
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }
		$registros = $this->paginate($model);
		$this->set('registros', $registros);
	}

	public function admin_fluxoGeralTipo(){
		$model = "PlType";
		$this->set('model', $model);

		$this->paginate = array(
			'fields' => array(
				'PlType.id',
				'PlType.tipo',
				'PlType.ativo',
			),
			'order' => array(
				'id' => 'DESC'
			),
		);
		// >>> FILTRO
        $conditions = array();
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    $model.'.tipo Like' => '%'.$buscar.'%',
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }
		$registros = $this->paginate($model);
		$this->set('registros', $registros);
	}

	public function admin_fluxoGeralVerGeral( $tipo_id=null ){
		$model = 'PlType';

		$registros = $this->$model->find('first', array(
			'conditions' => array(
				'PlType.id' => $tipo_id
			),
			'recursive' => 3
		));
		$this->set('registros', $registros);

		$tipos = $this->FluxogramaEtapa->find('list', array(
			'fields' => array(
				'PlType.id',
				'PlType.tipo',
			),
			'group' => array('PlType.tipo'),
			'recursive' => -2
		));
		$this->set('tipos', $tipos);

	}

	/*
	*
	* <<< Listar Tipos
	*/


	/*
	*
	* ETAPAS >>>
	*/
	public function admin_fluxoEtapasList( $tipo_id=null ){
		$model = "FluxogramaEtapa";
		$this->set('model', $model);


		$tipo = $this->PlType->find('first', array(
			'conditions' => array(
				'PlType.id' => $tipo_id
			),
			'recursive' => -2
		));
		$this->set('tipo', $tipo);

		$this->paginate = array(
			'conditions' => array(
				'FluxogramaEtapa.pl_type_id' => $tipo_id
			),
			'order' => array(
				'ordem' => 'ASC'
			)
		);

		// >>> FILTRO
		if( $this->request->is('post') || $this->request->is('put') ){
			$buscar = $this->request->data[$model]['search'];
			if( !empty($buscar) ):
				$conditions = array(
					'OR' => array(
						array('etapa Like' => '%'.$buscar.'%'),
						array('descricao Like' => '%'.$buscar.'%')
					)
				);
				$this->paginate['conditions'] = array($conditions);
			endif;
		}

		$registros = $this->paginate($model);

		$this->set('registros', $registros);
	}

	public function admin_fluxoEtapasAdd( $tipo_id=null ){
		$model = 'FluxogramaEtapa';
        $this->set('model', $model);

		$tipo = $this->PlType->find('first', array(
			'conditions' => array(
				'PlType.id' => $tipo_id
			)
		));
		$this->set('tipo', $tipo);

		$lastOrdem = $this->FluxogramaEtapa->find('all', array(
			'fields' => array('FluxogramaEtapa.ordem'),
			'conditions' => array(
				'FluxogramaEtapa.pl_type_id' => $tipo['PlType']['id']
			),
			'order' => array(
				'FluxogramaEtapa.ordem' => 'DESC'
			),
			'recursive' => -2
		));
		$lastOrdemEtapa = 1;
		if( !empty($lastOrdem) ){
			$lastOrdemEtapa = $lastOrdem[0]['FluxogramaEtapa']['ordem']+1;
		}
		$this->set('lastOrdemEtapa', $lastOrdemEtapa);

		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post')){
			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			/// Verifica se a Model está válida.
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				$etapas = $this->$model->find('all', array(
					'fields' => array('FluxogramaEtapa.ordem'),
					'conditions' => array(
						'FluxogramaEtapa.pl_type_id' => $tipo_id
					),
					'order' => array(
						'FluxogramaEtapa.ordem' => 'DESC'
					),
					'recursive' => -2
				));
				$settarUltimaEtapa = 1;
				if( !empty($etapas) ){
					$settarUltimaEtapa = $etapas[0]['FluxogramaEtapa']['ordem']+1;
				}
				$this->request->data[$model]['ordem'] = $settarUltimaEtapa;

				/// Gravando dados na base de ados
				if ($this->$model->save($this->request->data)){
					$lastID = $this->$model->getLastInsertID();

					////////////////////////////////////////////
					// Log fluxograma Etapa variaveis >>>
					$a_logHistorico['FluxogramaEtapa'] = array();
					$a_logHistorico['FluxogramaSubEtapa'] = array();
					//<<< Log fluxograma Etapa variaveis
					////////////////////////////////////////////


					$sub = $this->request->data['FluxogramaSubEtapa'];
					if( !empty($sub['subetapa']) ){
						$subEtapas = $this->FluxogramaSubEtapa->find('all', array(
							'fields' => array('FluxogramaSubEtapa.ordem'),
							'conditions' => array(
								'FluxogramaSubEtapa.etapa_id' => $lastID
							),
							'order' => array(
								'FluxogramaSubEtapa.ordem' => 'DESC'
							),
							'recursive' => -2
						));

						$settarUltimaSubEtapa = 1;
						if( !empty($subEtapas) ){
							$settarUltimaSubEtapa = $subEtapas[0]['FluxogramaSubEtapa']['ordem']+1;
						}

						$a_save = array(
							'etapa_id' 		=> $lastID,
							'subetapa' 		=> $sub['subetapa'],
							'descricao'     => $sub['descricao'],
							'ordem'     	=> $settarUltimaSubEtapa
						);
						$this->FluxogramaSubEtapa->create();
						$this->FluxogramaSubEtapa->save($a_save);

						////////////////////////////////////////////
						// Log fluxograma Sub-Etapa >>>
						$lastFluxogramaSubEtapaID = $this->FluxogramaSubEtapa->getLastInsertID();
						$a_logHistorico['FluxogramaSubEtapa'] = array(
							'etapa_id'			=> $lastID,
							'etapa' 			=> $this->request->data['FluxogramaEtapa']['etapa'],
							'etapa_descricao' 	=> $this->request->data['FluxogramaEtapa']['descricao'],
							'etapa_ordem' 		=> $this->request->data['FluxogramaEtapa']['ordem'],
							'subetapa_id'		=> $lastFluxogramaSubEtapaID,
							'subetapa' 			=> $this->request->data['FluxogramaSubEtapa']['subetapa'],
							'subetapa_descricao' => $this->request->data['FluxogramaSubEtapa']['descricao'],
							'subetapa_ordem' 	=> $settarUltimaSubEtapa,
							'pl_type_id'		=> $tipo_id,
							'fluxo_etapa_add'	=> 1,
							'fluxo_subetapa_add'=> 1,
							'nome_da_model'		=> 'FluxogramaEtapa',
							'model_id'			=> $lastID
						);
						$this->admin_fluxoLog($a_logHistorico['FluxogramaSubEtapa']);
						//<<< Log fluxograma Sub-Etapa
						////////////////////////////////////////////
					}else{

						////////////////////////////////////////////
						// Log fluxograma Etapa >>>
						$a_logHistorico['FluxogramaEtapa'] = array(
							'etapa_id'			=> $lastID,
							'etapa' 			=> $this->request->data['FluxogramaEtapa']['etapa'],
							'etapa_descricao' 	=> $this->request->data['FluxogramaEtapa']['descricao'],
							'etapa_ordem' 		=> $this->request->data['FluxogramaEtapa']['ordem'],
							'pl_type_id'		=> $tipo_id,
							'fluxo_etapa_add' 	=> 1,
							'nome_da_model'		=> 'FluxogramaEtapa',
							'model_id'			=> $lastID
						);

						$this->admin_fluxoLog($a_logHistorico['FluxogramaEtapa'][0]);
						// <<< Log fluxograma Etapa
						////////////////////////////////////////////
					}


					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
					$this->Session->setFlash('Etapa adicionada com sucesso!');

					$this->redirect(array('action' => 'fluxoEtapasList', 'admin' => true, $tipo_id));
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

	public function admin_fluxoEtapasEdit( $tipo_id=null, $etapa_id=null ){
		$model = 'FluxogramaEtapa';
        $this->set('model', $model);

		$subEtapas = $this->FluxogramaSubEtapa->find('all', array(
			'fields' => array('FluxogramaSubEtapa.ordem'),
			'conditions' => array(
				'FluxogramaSubEtapa.etapa_id' => $etapa_id
			),
			'order' => array(
				'FluxogramaSubEtapa.ordem' => 'DESC'
			),
			'recursive' => -2
		));
		$settarUltimaSubEtapa = 0;
		if( !empty($subEtapas) ){
			$settarUltimaSubEtapa = $subEtapas[0]['FluxogramaSubEtapa']['ordem']+1;
		}
		$this->set('settarUltimaSubEtapa', $settarUltimaSubEtapa);

		/// Verifica se esse ID existe ou não
        $this->$model->id = $etapa_id;
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
					if( !empty($this->request->data['FluxogramaSubEtapa']['subetapa']) ):
						$subAdd = $this->request->data['FluxogramaSubEtapa'];

						$subEtapas = $this->FluxogramaSubEtapa->find('all', array(
							'fields' => array('FluxogramaSubEtapa.ordem'),
							'conditions' => array(
								'FluxogramaSubEtapa.etapa_id' => $etapa_id
							),
							'order' => array(
								'FluxogramaSubEtapa.ordem' => 'DESC'
							),
							'recursive' => -2
						));
						$settarUltimaSubEtapa = $subEtapas[0]['FluxogramaSubEtapa']['ordem']+1;

						$a_subEtapa = array(
							'etapa_id' 	=> $etapa_id,
			                'subetapa'	=> $subAdd['subetapa'],
			                'descricao' => $subAdd['descricao'],
							'ordem'		=> $settarUltimaSubEtapa
			            );

			            $this->FluxogramaSubEtapa->create();
			            $this->FluxogramaSubEtapa->save($a_subEtapa);
						////////////////////////////////////////////
						// Log fluxograma Sub-Etapa >>>
						$lastFluxogramaSubEtapaID = $this->FluxogramaSubEtapa->getLastInsertID();
						$a_logHistorico['FluxogramaSubEtapa'] = array(
							'etapa_id'			=> $etapa_id,
							'etapa' 			=> $this->request->data['FluxogramaEtapa']['etapa'],
							'etapa_descricao' 	=> $this->request->data['FluxogramaEtapa']['descricao'],
							'etapa_ordem' 		=> $this->request->data['FluxogramaEtapa']['ordem'],
							'subetapa_id'		=> $lastFluxogramaSubEtapaID,
							'subetapa' 			=> $this->request->data['FluxogramaSubEtapa']['subetapa'],
							'subetapa_descricao' => $this->request->data['FluxogramaSubEtapa']['descricao'],
							'subetapa_ordem' 	=> $settarUltimaSubEtapa,
							'pl_type_id'		=> $tipo_id,
							'fluxo_etapa_edit'	=> 1,
							'fluxo_subetapa_add'=> 1,
							'nome_da_model'		=> 'FluxogramaEtapa',
							'model_id'			=> $etapa_id
						);
						$this->admin_fluxoLog($a_logHistorico['FluxogramaSubEtapa']);
						//<<< Log fluxograma Sub-Etapa
						////////////////////////////////////////////

						// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
						$this->Session->setFlash('Sub-Etapa alterada com sucesso!');

						// Redirecionando o usuário para a listagem dos registros
						$this->redirect(array('action' => 'fluxoEtapasEdit', 'admin' => true, $tipo_id, $etapa_id));
					else:
						$subEdit = $this->request->data['FluxogramaSubEtapaEdit'];
						if( !empty($subEdit) ){
							$this->FluxogramaSubEtapa->id = $subEdit['subetapa_id'];
							$this->request->data['FluxogramaSubEtapa'] = $subEdit;
							$this->FluxogramaSubEtapa->save($this->request->data);
							////////////////////////////////////////////
							// Log fluxograma Etapa >>>
							$a_logHistorico['FluxogramaEtapa'] = array();
							$a_logHistorico['FluxogramaSubEtapa'] = array();

							$lastFluxogramaSubEtapaID = $this->FluxogramaSubEtapa->getLastInsertID();
							$a_logHistorico['FluxogramaSubEtapa'] = array(
								'etapa_id'			=> $etapa_id,
								'subetapa_id'		=> $this->FluxogramaSubEtapa->id,
								'subetapa' 			=> $subEdit['subetapa'],
								'subetapa_descricao' => $subEdit['descricao'],
								'subetapa_ordem' 	=> $subEdit['ordem'],
								'pl_type_id'		=> $tipo_id,
								'fluxo_subetapa_edit'	=> 1,
								'nome_da_model'		=> 'FluxogramaEtapa',
								'model_id'			=> $etapa_id
							);
							$this->admin_fluxoLog($a_logHistorico['FluxogramaSubEtapa']);
							//<<< Log fluxograma Sub-Etapa
							////////////////////////////////////////////

							// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
							$this->Session->setFlash('Sub-Etapa alterada com sucesso!');

							// Redirecionando o usuário para a listagem dos registros
							$this->redirect(array('action' => 'fluxoEtapasEdit', 'admin' => true, $tipo_id, $etapa_id));
						}
						////////////////////////////////////////////
						// Log fluxograma Etapa >>>
						$a_logHistorico['FluxogramaEtapa'] = array(
							'etapa_id'			=> $etapa_id,
							'etapa' 			=> $this->request->data['FluxogramaEtapa']['etapa'],
							'etapa_descricao' 	=> $this->request->data['FluxogramaEtapa']['descricao'],
							'etapa_ordem' 		=> $this->request->data['FluxogramaEtapa']['ordem'],
							'pl_type_id'		=> $tipo_id,
							'fluxo_etapa_edit' 	=> 1,
							'nome_da_model'		=> 'FluxogramaEtapa',
							'model_id'			=> $etapa_id
						);

						$this->admin_fluxoLog($a_logHistorico['FluxogramaEtapa']);
						// <<< Log fluxograma Etapa
						//////////////////////////////////////////
					endif;

                    // Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
                    $this->Session->setFlash('Etapa alterada com sucesso!');

                    // Redirecionando o usuário para a listagem dos registros
                    $this->redirect(array('action' => 'fluxoEtapasList', 'admin' => true, $tipo_id));
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
        $this->request->data = $this->$model->find('first', array(
			'conditions' => array(
				'FluxogramaEtapa.id' => $etapa_id
			)
		));
        // $this->request->data = $this->$model->read(null, $etapa_id);
	}

	public function admin_fluxoEtapasDelete( $tipo_id=null, $etapa_id=null, $deleteEtapaTipo=null ){
		$this->autoRender = false;
		$model = 'FluxogramaEtapa';
		$this->set('model', $model);

		/// Segurança:
		///=================================================
		/// - Verifica se a requisição a este método está sendo feito por um post.
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		/// - Verifica se o registro realmente existe.
		$this->$model->id = $etapa_id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Registro inexistente'));
		}
		///=================================================

		/// Apaga os registros da base de dados
		if ($this->$model->delete($etapa_id)) {
			$subEtapas = $this->FluxogramaSubEtapa->find('all', array(
				'fields' => array(
					'FluxogramaSubEtapa.id'
				),
				'conditions' => array(
					'FluxogramaSubEtapa.etapa_id' => $etapa_id
				),
				'recursive' => -2
			));
			if( !empty($subEtapas) ){
				foreach( $subEtapas as $subEtapa ){
					$this->FluxogramaSubEtapa->id = $subEtapa['FluxogramaSubEtapa']['id'];
					$this->$model->delete($this->FluxogramaSubEtapa->id);
				}
			}

			////////////////////////////////////////////
			// Log fluxograma Sub-Etapa >>>
			$lastFluxogramaSubEtapaID = $this->FluxogramaSubEtapa->getLastInsertID();
			$a_logHistorico['FluxogramaEtapa'] = array(
				'etapa_id'			=> $etapa_id,
				'pl_type_id'		=> $tipo_id,
				'fluxo_etapa_delete'=> 1,
				'nome_da_model'		=> 'FluxogramaEtapa',
				'model_id'			=> $etapa_id
			);
			$this->admin_fluxoLog($a_logHistorico['FluxogramaEtapa']);
			//<<< Log fluxograma Sub-Etapa
			////////////////////////////////////////////

			// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
			$this->Session->setFlash('Etapa excluída com sucesso!');

			// Redirecionando o usuário para a listagem dos registros
			$a_redirect = array('action' => 'fluxoEtapasList', 'admin' => true, $tipo_id );
			if( !empty($deleteEtapaTipo) ){
				$a_redirect = array('controller' => 'PlTypes', 'action' => 'edit', 'admin' => true, $tipo_id );
			}
			$this->redirect( $a_redirect );
		}

	}

	public function admin_verificarEtapasDesteTipo( $idTipoProp=null ){
		$this->autoRender = false ;
        $model = 'FluxogramaEtapa';

        $registros = $this->$model->find('all', array(
            'fields' => array(
                'FluxogramaEtapa.id',
                'FluxogramaEtapa.pl_type_id',
                'FluxogramaEtapa.etapa',
                'FluxogramaEtapa.descricao',
            ),
            'conditions' => array(
                'FluxogramaEtapa.pl_type_id' => $idTipoProp
            ),
			'recursive' => -2,
			'order' => array(
				'FluxogramaEtapa.ordem' => 'ASC'
			),
        ));

        return json_encode($registros);
	}

	public function admin_verificarSubEtapasDesteTipo( $etapa_id=null ){
		$this->autoRender = false ;
        $model = 'FluxogramaSubEtapa';

        $registros = $this->$model->find('all', array(
            'fields' => array(
                'FluxogramaSubEtapa.id',
                'FluxogramaSubEtapa.etapa_id',
                'FluxogramaSubEtapa.subetapa',
                'FluxogramaSubEtapa.descricao',
            ),
            'conditions' => array(
                'FluxogramaSubEtapa.etapa_id' => $etapa_id
            ),
			'recursive' => -2,
			'order' => array(
				'FluxogramaSubEtapa.ordem' => 'ASC'
			),
        ));

        return json_encode($registros);
	}

	/*
	*
	* <<< ETAPAS
	*/




	/*
	*
	* SubEtapas >>>
	*/
	public function admin_fluxoSubEtapasDelete($tipo_id=null, $etapa_id=null, $subEtapa_id=null){
		$this->autoRender = false;
		$model = 'FluxogramaSubEtapa';
        $this->set('model', $model);


		/// Segurança:
    	///=================================================
    	/// - Verifica se a requisição a este método está sendo feito por um post.
    	if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

    	/// - Verifica se o registro realmente existe.
        $this->$model->id = $subEtapa_id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }
    	///=================================================





		////////////////////////////////////////////
		// Log fluxograma Sub-Etapa >>>
		$lastFluxogramaSubEtapaID = $this->FluxogramaSubEtapa->getLastInsertID();
		$a_logHistorico['FluxogramaSubEtapa'] = array(
			'subetapa_id'			=> $subEtapa_id,
			'pl_type_id'			=> $tipo_id,
			'fluxo_subetapa_delete'	=> 1,
			'nome_da_model'			=> 'FluxogramaSubEtapa',
			'model_id'				=> $etapa_id
		);
		$this->admin_fluxoLog($a_logHistorico['FluxogramaSubEtapa']);
		//<<< Log fluxograma Sub-Etapa
		////////////////////////////////////////////


		/// Apaga os registros da base de dados
		if ($this->$model->delete($subEtapa_id)) {

			// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
			$this->Session->setFlash('Sub-Etapa excluída com sucesso!');

			// Redirecionando o usuário para a listagem dos registros
			$this->redirect(array('action' => 'fluxoEtapasEdit', 'admin' => true, $tipo_id, $etapa_id ));
		}

	}
	/*
	*
	* <<< SubEtapas
	*/





	public function admin_fluxohtml(){
		echo "<pre>";
		$htmlFluxoPrint = '
			<html class="no-js" lang="en">
			    <head>
			        <meta charset="utf-8">
			    	<link rel="stylesheet" type="text/css" href="'.Router::url('/css/materialize.min.css', true).'">
			    	<link rel="stylesheet" type="text/css" href="'.Router::url('/css/zoio.css', true).'">



			    	<link rel="stylesheet" type="text/css" href="'.Router::url('/assets/js-graph-it/js-graph-it.css', true).'">
			    	<link rel="stylesheet" type="text/css" href="'.Router::url('/assets/js-graph-it/sf-homepage.css', true).'">
					<script type="text/javascript" src="'.Router::url('/js/jquery-print.js', true).'"></script>
					<script type="text/javascript" src="'.Router::url('/js/printThis.js', true).'"></script>
				</head>
				<body>
					<main>';

				$htmlFluxoPrint .= $this->request->data['table'];
				$htmlFluxoPrint .= '</main>
			    </body>
			</html>';


		$this->set('registro', $htmlFluxoPrint);
	}




	public function admin_fluxoScreenShot( $pl_id=null, $periodo=null ){
		$pl_id = 288;
		$periodo = '30 Fevereiro, 2016';
		$model = "Fluxograma";
		$this->set('model', $model);

		/*
		*
		* localizar data no historico >>>
		*/
		$requestDateFilter 	= '';
		$todosDadosPl 		= array();
		$conditions['date'] = array();
		$requestDateFilter = $this->formatDateToSQL($periodo);

		if( !empty($requestDateFilter) ){
			$conditionsNewDate = array(
				'Fluxograma.created <= ' => $requestDateFilter
			);
			array_push( $conditions['date'], $conditionsNewDate );
		}

		$fluxoHistorico = $this->$model->find('first', array(
			'conditions' => array(
				'Fluxograma.pl_id' => $pl_id,
				$conditions['date'][0]
			),
			'order' => array(
				'Fluxograma.id' => 'DESC'
			)
		));
		array_push( $todosDadosPl, $fluxoHistorico );

		//>>> MONTAR 1 ARRAY() COMPLETA COM TUDO
		$focoTrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['foco'] );
		$foco = array(
			'Foco' => $focoTrata
		);
		array_push( $todosDadosPl, $foco );

		$oqueETrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['oque_e'] );
		$oqueE = array(
			'Oque_e' => $oqueETrata
		);
		array_push( $todosDadosPl, $oqueE );

		$nossaPosicaoTrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['nossa_posicao'] );
		$nossaPosicao = array(
			'NossaPosicao' => $nossaPosicaoTrata
		);
		array_push( $todosDadosPl, $nossaPosicao );

		$justificativaTrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['justificativa'] );
		$justificativa = array(
			'Justificativa' => $justificativaTrata
		);
		array_push( $todosDadosPl, $justificativa );

		$situacaoTrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['situacao'] );
		$situacao = array(
			'Situacao' => $situacaoTrata
		);
		array_push( $todosDadosPl, $situacao );

		$tarefaTrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['tarefa'] );
		$tarefa = array(
			'Tarefa' => $tarefaTrata
		);
		array_push( $todosDadosPl, $tarefa );

		$notasTecnicasTrata = $this->trataRegsitroLogTexto( $fluxoHistorico[$model]['nostas_tecnicas'] );
		$notasTecnicas = array(
			'NotasTecnicas' => $notasTecnicasTrata
		);
		array_push( $todosDadosPl, $notasTecnicas );
		//<<< MONTAR 1 ARRAY() COMPLETA COM TUDO
		/*
		*
		* <<< localizar data no historico
		*/


	}



    /*
    *
    * alimentar a tabela tb_fluxo_log_origem_pl com as proposições ja existentes.
    * o ponto de partida da proposição, é o momento em que a mesma foi criada e
    * como ja existem proposições criadas, precisamos coloca-las na tabela do Fluxograma.php
    */
    public function admin_cargaFluxograma(){
        die('Este método deve ser usado apenas pegar o ponto de partida do fluxograma.');

        $this->autoRender = false;
        $model = 'Fluxograma';

        $plAll = $this->Pl->find('all', array(
            'fields' => array(
                'Pl.id',
                'Pl.tipo_id',
                'Pl.numero_da_pl',
                'Pl.ano',
                'Pl.created',
                'Pl.modified',
                'PlType.tipo'
            ),
            'order' => array('id' => 'DESC'),
            'recursive' => -2
        ));

        $plOrigem = '';
        foreach( $plAll as $pl ){
            if($pl['PlType']['tipo']){
                $plOrigem .= $pl['PlType']['tipo'].' ';
            }
            if($pl['Pl']['numero_da_pl']){
                $plOrigem .= $pl['Pl']['numero_da_pl'];
            }
            if($pl['Pl']['ano']){
                $plOrigem .= '/'.$pl['Pl']['ano'];
            }

            $a_fluxograma['Fluxograma'] = array(
                'pl_id'         => $pl['Pl']['id'],
                'pl_origem'     => $plOrigem,
                'tipo_id'       => $pl['Pl']['tipo_id'],
                'numero_da_pl'  => $pl['Pl']['numero_da_pl'],
                'ano'           => $pl['Pl']['ano'],
                'created'       => $pl['Pl']['created'],
                'modified'      => $pl['Pl']['created'],
            );

            $this->$model->create();
            $this->$model->save($a_fluxograma);
            $plOrigem = '';
        }
        die('Ok!');
    }
}
?>
