<?php
class TarefasController extends AppController{
    var $name = "Tarefas";
    public $helpers = array('Html', 'Session', 'Form', 'Paginator' , 'Time');
    public $uses = array('Tarefa', 'TarefaPl', 'User');
    var $scaffold = 'admin';
    //var $transformUrl = array('url_amigavel' => 'titulo_ptbr');

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


            $this->set('schemaTable', $this->Empresa->schema());
        }
        */
    }


    public function admin_index(){
        $model = 'Tarefa';
        $this->set('model' , $model);
        $conditions = array();

        $this->paginate = array(
            'order' => array(
                'id' => 'DESC'
            ),
            'conditions' => array(
                'Tarefa.delete' => 0
            ),
            'recursive' => 1
        );

        // >>> FILTRO
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    $model.'.delete' => 0,
                    'OR' => array(
                        array('titulo Like' => '%'.$buscar.'%'),
                        array('descricao Like' => '%'.$buscar.'%')
                    )
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }

        // echo '<pre>';
        // print_r($this->paginate($model));
        // echo '</pre>';
        // die();
        $this->set('registros', $this->paginate($model));
    }

    public function admin_add(){
        $model = 'Tarefa';
        $this->set('model' , $model);

        $usuariosLista = $this->User->find('list', array(
                                        'fields' => array(
                                            'id', 'username'
                                        )
                                    ));
        $this->set('usuariosLista', $usuariosLista);

        /// Verifica se houve post para salvar as informações
        if ($this->request->is('post')){

            /// Seta a model com as informações que vieram do post
            $this->$model->set($this->request->data['Usuarios']);

            /// Verifica se a Model está válida.
            /// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
            if($this->$model->validates()){
                /// Gravando dados na base de ados
                if ($this->$model->save($this->request->data)){
                    $lastID = $this->$model->getLastInsertID();

                    ////////////////////
                    ///>>> save usuarios
                        $usuarios = $this->request->data['Usuarios'];
                        foreach($usuarios as $idUsuarios){
                            $a_save = array(
                                'usuario_id' => $idUsuarios,
                                'tarefas_id' => $lastID
                            );
                            $this->TarefaPl->create();
                            $this->TarefaPl->save($a_save);
                        }
                    ///<<< save usuarios
                    ////////////////////
                    // Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
                    $this->Session->setFlash('Tarefa adicionada com sucesso!');

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

    public function admin_edit($id=null){
        $model = 'Tarefa';
        $this->set('model' , $model);

        // $usuariosLista = $this->User->find('list', array(
        //                                 'fields' => array(
        //                                     'id', 'username'
        //                                 )
        //                             ));
        // $this->set('usuariosLista', $usuariosLista);

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


                $dataEntrega = $this->formatDateBD($this->request->data[$model]['entrega']);
                $this->request->data[$model]['entrega'] = $dataEntrega;
                if($this->$model->save($this->request->data)){
                    /*
                        pra nao ter problema de duplicidade,
                        toda a vez que for editar TODOS os registros deste ID serao removidos
                    */
                    // $tarefasDoUsuario = $this->TarefaPl->find('all', array(
                    //                                                     'conditions' => array(
                    //                                                         'TarefaUsuario.tarefas_id' => $id
                    //                                                     )
                    //                                                 ));
                    //
                    // foreach($tarefasDoUsuario as $tarefa){
                    //     $this->TarefaUsuario->delete($tarefa['TarefaUsuario']['id']);
                    // }

                    ////////////////////
                    ///>>> save usuarios
                    // $usuarios = $this->request->data['Usuarios'];
                    // foreach($usuarios as $idUsuarios){
                    //     $a_save = array(
                    //         'usuario_id' => $idUsuarios,
                    //         'tarefas_id' => $id
                    //     );
                    //     $this->TarefaPl->create();
                    //     $this->TarefaPl->save($a_save);
                    // }
                    ///<<< save usuarios
                    ////////////////////


                    // Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
                    $this->Session->setFlash('Tarefa alterada com sucesso!');

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


        $registro = $this->$model->find('first', array(
            'conditions' => array($model.'.id' => $id),
            'recursive' => 2
        ));

        // echo '<pre>';
        // print_r($registro);
        // echo '</pre>';
        // die();
        $this->request->data = $registro;
        // $this->request->data = $this->$model->read(null, $id);
    }

    /* DELETE     */
    function admin_delete($id){
    	$model = 'Tarefa';

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
		// if ($this->$model->delete($id)) {
		if ($this->$model->saveField('delete', true)) {

			// Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
			$this->Session->setFlash('Tarefa excluída com sucesso!');

			// Redirecionando o usuário para a listagem dos registros
			$this->redirect(array('action' => 'index'));
		}
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


}

?>
