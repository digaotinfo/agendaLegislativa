<?
class JustificativasController extends AppController{
 	var $name = "Justificativas";
	public $helpers = array('Html', 'Session', 'Form');
	public $uses = array('Justificativa', 'LogAtualizacaoPl', 'Pl');
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


    public function admin_salvar_justificativa_da_pl(){
        $model = 'Justificativa';
        $this->autoRender = false;

    	/// Verifica se esse ID existe ou não

        if ($this->request->is('post')){

            // print_r($this->request->data);
            // return json_encode($this->request->data);
            // die();

			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			if($this->$model->validates()):
                if($this->$model->save($this->request->data)){


                    $pl_id = $this->request->data[$model]['pl_id'];
                    $id = $this->$model->getLastInsertId();
                    $resultado_tipo_id = $this->Pl->find('first', array(
                        'fields' => array(
                            'tipo_id'
                        ),
                        'conditions' => array(
                            'id' => $pl_id,
                        ),
                        'recursive' => -1
                    ));

                    // >>> LOG
                    $existe_este_log = $this->LogAtualizacaoPl->find('first', array(
                        'conditions' => array(
                            'pl_id' => $pl_id,
                            'nome_da_model' => $model,
                            'model_id'  => $id
                        )
                    ));

                    if(!empty($existe_este_log)){
                        $this->LogAtualizacaoPl->id = $existe_este_log['LogAtualizacaoPl']['id'];
                    }

                    $this->request->data['LogAtualizacaoPl']['pl_id'] = $pl_id;

                    $this->request->data['LogAtualizacaoPl']['usuario_id'] = $this->Session->read('Auth.User.id');
                    $this->request->data['LogAtualizacaoPl']['usuario_nome'] = $this->Session->read('Auth.User.name');
                    $this->request->data['LogAtualizacaoPl']['usuario_username'] = $this->Session->read('Auth.User.username');

                    $this->request->data['LogAtualizacaoPl']['model_id'] = $id;
                    $this->request->data['LogAtualizacaoPl']['tipo_id'] = $resultado_tipo_id['Pl']['tipo_id'];
                    $this->request->data['LogAtualizacaoPl']['nome_da_model'] = $model;
                    $this->request->data['LogAtualizacaoPl']['name_block'] = 'Justificativa';
                    $this->request->data['LogAtualizacaoPl']['txt'] = $this->request->data[$model]['justificativa'];

                    $this->LogAtualizacaoPl->save($this->request->data);

                    // <<< LOG

                    return json_encode(array('sucesso' => true));
                    die();
                }else{
                    return json_encode(array('sucesso' => false));
                    die();
                }
            endif;
        }
    }

}
