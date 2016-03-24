<?
CakePlugin::load('MeioUpload');
// CakePlugin::load('Upload');
class NotasTecnicasController extends AppController{
 	var $name = "NotasTecnicas";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $uses = array('NotasTecnica', 'Pl');
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
        $model = 'NotasTecnica';
        $this->set('model', $model);
        $this->paginate = array(
            'order' => array(
                'id' => 'DESC'
            ),
            'recursive' => 2
        );

        // >>> FILTRO
        $conditions = array();
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    'OR'=> array($model.'.nome Like' => '%'.$buscar.'%', $model.'.arquivo Like' => '%'.$buscar.'%'),
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }

        $this->paginate['conditions'] = array($conditions);
        $registros = $this->paginate($model);
        // <<< FILTRO

        $this->set('registros', $registros);

    }

    public function admin_add($pl_id=null){
        $model = 'NotasTecnica';
		$this->set('model', $model);

        if( !empty($pl_id) ){
            $pl_id = $pl_id;
        }
        $this->set('pl_id', $pl_id);
        //>>> pegando a lista
        $list = $this->Pl->query("
            SELECT
                `Pl`.`id`,
                (CONCAT(PlType.tipo, ' ', `Pl`.`numero_da_pl`, '/',`Pl`.`ano`)) AS `Pl_concat`
            FROM
                `tb_pls` AS `Pl`
                LEFT JOIN `tb_pl_types` AS `PlType` ON (`Pl`.`tipo_id` = `PlType`.`id`)
            WHERE
                `Pl`.`delete` = '0'
                AND `Pl`.`ativo` = '1'
            ORDER BY
                Pl.numero_da_pl
            ");

        $indiceValue = '';
        $last_key = end(array_keys($list));
        foreach($list as $key => $prop){
            if ($key != $last_key) {
                $indiceValue = $indiceValue.$prop['Pl']['id'].'=>'.$prop[0]['Pl_concat'].',';
            }else{
                $indiceValue = $indiceValue.$prop['Pl']['id'].'=>'.$prop[0]['Pl_concat'];
            }
        }
        //<<< pegando a lista


        //>>> colocando no formato correto para o select
        $indiceValueFinal = array();
        $a_indiceValue = explode(',', $indiceValue);
        $last_key = end(array_keys( $a_indiceValue ));
        foreach($a_indiceValue as $key => $prop){
            $desmontandoString = explode('=>', $prop);
            if( $last_key == $key ){
               $indiceValueFinal[$desmontandoString[0]] = $desmontandoString[1];
           }else{
               $indiceValueFinal[$desmontandoString[0]] = $desmontandoString[1];
                unset ( $a_indiceValue[$key]);

           }
        }
        //<<< colocando no formato correto para o select

        $this->set('proposicao', $indiceValueFinal);


		/// Verifica se houve post para salvar as informações
		if ($this->request->is('post')){

			/// Seta a model com as informações que vieram do post
			$this->$model->set($this->request->data);

			/// Verifica se a Model está válida.
			/// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
			if($this->$model->validates()){
				/// Gravando dados na Model Pai
                if( $this->$model->save($this->request->data) ){
                    // Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
    	            $this->Session->setFlash('Arquivo adicionado com sucesso!');

                    if( !empty($pl_id) ){
                        $this->redirect(array('controller' => 'pls', 'action' => 'ver_completo', 'admin' => true, $this->request->data[$model]['pl_id']));
                    }else{
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

    public function admin_edit($id){
        $model = 'NotasTecnica';
		$this->set('model', $model);

        $list = $this->Pl->query("
            SELECT
                `Pl`.`id`,
                (CONCAT(PlType.tipo, ' ', `Pl`.`numero_da_pl`, '/',`Pl`.`ano`)) AS `Pl_concat`
            FROM
                `tb_pls` AS `Pl`
                LEFT JOIN `tb_pl_types` AS `PlType` ON (`Pl`.`tipo_id` = `PlType`.`id`)
            WHERE
                `Pl`.`delete` = '0'
                AND `Pl`.`ativo` = '1'

            ORDER BY
                Pl.numero_da_pl
            ");

        //>>> pegando a lista
        $indiceValue = '';
        $last_key = end(array_keys($list));
        foreach($list as $key => $prop){
            if ($key != $last_key) {
                $indiceValue = $indiceValue.$prop['Pl']['id'].'=>'.$prop[0]['Pl_concat'].',';
            }else{
                $indiceValue = $indiceValue.$prop['Pl']['id'].'=>'.$prop[0]['Pl_concat'];
            }
        }
        //<<< pegando a lista


        //>>> colocando no formato correto para o select
        $indiceValueFinal = array();
        $a_indiceValue = explode(',', $indiceValue);
        $last_key = end(array_keys( $a_indiceValue ));
        foreach($a_indiceValue as $key => $prop){
            $desmontandoString = explode('=>', $prop);
            if( $last_key == $key ){
               $indiceValueFinal[$desmontandoString[0]] = $desmontandoString[1];
           }else{
               $indiceValueFinal[$desmontandoString[0]] = $desmontandoString[1];
                unset ( $a_indiceValue[$key]);

           }
        }
        //<<< colocando no formato correto para o select

        $this->set('proposicao', $indiceValueFinal);


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

    public function admin_delete($id = null, $pl_id=null) {
		$model = 'NotasTecnica';

		//===-----> Apoio View
		$this->set('model', $model);
		//==----------------------------------------

        print_r('teste de delete');
        die();

        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Nota Tecnica inválida'));
        }
        if ($this->$model->delete()) {
            $this->Session->setFlash(__('Nota Tecnica excluída com sucesso.'));
            if( !empty($pl_id) ){
                $this->redirect(array('controller' => 'pls', 'action' => 'ver_completo', 'admin' => true, $pl_id));
            }else{
                $this->redirect(array('controller' => 'notasTecnicas', 'action' => 'index', 'admin' => true));
            }
        }
        $this->Session->setFlash(__('Nota Tecnica não excluida.'));
        $this->redirect(array('action' => 'index'));
    }

    /*
    *
    * comentar na model NotasTecnica o trecho de MEIO UPLOAD para concluir a migracao
    */
    public function admin_migrarArquivos(){
        $model = 'NotasTecnica';

        $listPlArquivos = $this->Pl->find('all', array(
            'fields' => array('Pl.id', 'Pl.arquivo'),
            'conditions' => array(
                'Pl.arquivo <>' => '',
                'Pl.delete' => 0
            ),
            'recursive' => -2
        ));

        foreach( $listPlArquivos as $arquivo){
            $pl_id = $arquivo['Pl']['id'];
            $explodeFileString = explode('/', $arquivo['Pl']['arquivo']);
            $nomeArquivo = $explodeFileString[2];
            $nomeArquivoExplode = explode('.', $nomeArquivo);
            $tituloArquivo = $nomeArquivoExplode[0];
            $dirArquivo = $explodeFileString[0].'/'.$explodeFileString[1];

            $a_newFile = array(
                'pl_id' => $pl_id,
                'nome' => $tituloArquivo,
                'arquivo' => $nomeArquivo,
                'dir' => $dirArquivo
            );
            // echo '<pre>';
            // print_r($a_newFile);
            // echo '</pre>';
            // die();


            $this->$model->create();
            $this->$model->save($a_newFile);
        }
    }

}
