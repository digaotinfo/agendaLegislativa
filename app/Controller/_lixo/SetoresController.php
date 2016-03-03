<?
class SetoresController extends AppController{
 	var $name = "Setores";
	public $helpers = array('Html', 'Session', 'Form');
	public $uses = array('Setor', 'ConteudoSetor');
	//var $scaffold = 'admin';
	//var $transformUrl = array('url_amigavel' => 'titulo_ptbr');

	var $paginate = array(
	                        'limit'  => 10,

                        );

	function beforeFilter() {
		parent::beforeFilter();

		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
                                    'id'	  	=> 'ID',
                                    'setor' 	=> 'Setor',
								);
			$showImage	=	array(
								''
							);

			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);


			$this->set('schemaTable', $this->Setor->schema());
		}
	}

	function admin_index(){
		$model = 'Setor';
		$this->set('model', $model);


		$this->paginate['fields'] = array('id',
									'setor',
									'ativo'
									);

		$this->set('registros', $this->paginate($model));
	}

	/*  ADD */
	function admin_add(){
		$model = 'Setor';
		$this->set('model', $model);

		if ($this->request->is('post')){
			$this->$model->set($this->request->data);
			
			if($this->$model->validates()){
	            if ($this->$model->save($this->request->data[$mode])){
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
		$model = 'Setor';
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
				
				if($this->$model->save($this->request->data)){
	            	$this->Session->setFlash('Setor alterados com sucesso!');
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
    	$model = 'Setor';
    	
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
        	$this->Session->setFlash('Setor excluído com sucesso!');
			$this->redirect(array('action' => 'index'));
		}
    }
    /* END DELETE */

    public function admin_visualizar() {

	}



}
