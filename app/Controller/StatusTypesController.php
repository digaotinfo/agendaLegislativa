<?
class StatusTypesController extends AppController{
 	var $name = "StatusTypes";
	public $helpers = array('Html', 'Session', 'Form');
	public $uses = array('StatusType');
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



	/* LIST */
	function admin_index(){
		$model = 'StatusType';
		$this->set('model', $model);


		$this->paginate['fields'] = array(
										'id',
										'status_name',
										'exigir_justificativa',
										'ativo',
									);
		$this->paginate['recursive'] = -1;
		$this->paginate['order'] = array('id' => 'DESC');
        // >>> FILTRO
        $conditions = array();
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    $model.'.status_name Like' => '%'.$buscar.'%',
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }

        $this->paginate['conditions'] = array($conditions);
		$this->set('registros', $this->paginate($model));
	}
	/* END LIST */

	/*  ADD */
	function admin_add(){
		$model = 'StatusType';
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
                    // $lastID = $this->$model->getLastInsertId();
                    // $lastRegistro = $this->$model->find('first', array(
                    //         'conditions' => array(
                    //             'id' => $lastID
                    //         )
                    //     ));

					// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
		            $this->Session->setFlash('Status adicionado com sucesso!');


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
				// $this->Session->setFlash($mensagem_erros, 'default', array('class' => 'alert'));
                return false;
			}
        }

    }
    /* END ADD */

    /* EDIT */
	function admin_edit($id=null){
		$model = 'StatusType';
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
	            	$this->Session->setFlash('Status alterado com sucesso!');

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
    	$model = 'StatusType';

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
			$this->Session->setFlash('Status excluída com sucesso!');

			// Redirecionando o usuário para a listagem dos registros
			$this->redirect(array('action' => 'index'));
		}


    }
    /* END DELETE */


    function admin_verificaexigencia($id) {
    	$model = 'StatusType';
        $this->layout = 'ajax';
        $this->autoRender = false;

        $registro = $this->$model->findById($id);

        $json = json_encode($registro[$model]['exigir_justificativa']);
		$this->response->body($json);

    }

}
