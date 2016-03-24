<?
CakePlugin::load('MeioUpload');
// CakePlugin::load('Upload');
class ArquivosController extends AppController{
 	var $name = "Arquivos";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $uses = array('Arquivo');
	var $scaffold = 'admin';
	// var $transformUrl = array('url_amigavel' => 'numero_da_pl');

	var $paginate = array(
	                        'limit'  => 20,
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


			$this->set('schemaTable', $this->Arquivo->schema());
		}
		*/
	}

    public function admin_index(){
        $model = 'Arquivo';
        $this->set('model', $model);
        $this->paginate = array(
            'order' => array(
                'id' => 'DESC'
            )
        );

        // >>> FILTRO
        $conditions = array();
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    'OR'=> array($model.'.nome Like' => '%'.$buscar.'%', $model.'.descricao Like' => '%'.$buscar.'%', $model.'.arquivo Like' => '%'.$buscar.'%'),
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }

        $this->paginate['conditions'] = array($conditions);
        $registros = $this->paginate($model);
        // <<< FILTRO

        $this->set('registros', $registros);

    }



    public function admin_add(){
        $model = 'Arquivo';
		$this->set('model', $model);

		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post')){

			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			/// Verifica se a Model está válida.
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				/// Gravando dados na Model Pai
                // print_r($this->request->data);
                // die();
                $pl_salva = $this->$model->save($this->request->data);


				// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
	            $this->Session->setFlash('Arquivo adicionado com sucesso!');

            	// Redirecionando o usuário para a listagem dos registros
                $this->redirect(array('action' => 'index', 'admin' => true));

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

    public function admin_edit($id){
        $model = 'Arquivo';
		$this->set('model', $model);

        /// Verifica se esse ID existe ou não
		$this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }

		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post') || $this->request->is('put')){

			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			/// Verifica se a Model está válida.
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				/// Gravando dados na Model Pai
                $pl_salva = $this->$model->save($this->request->data);


				// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
	            $this->Session->setFlash('Arquivo editado com sucesso!');

            	// Redirecionando o usuário para a listagem dos registros
                $this->redirect(array('action' => 'index', 'admin' => true));

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

}
