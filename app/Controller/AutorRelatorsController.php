<?php
App::import('Vendor', 'excel/PHPExcel');
App::import('Vendor', 'excel/PHPExcel/IOFactory.php');
// App::import('Vendor', 'excel/PHPExcel/Writer/Excel2007');
// App::import('Vendor', 'excel/PHPExcel/Reader/Excel2007');

class AutorRelatorsController extends AppController{
    var $name = "AutorRelators";
    public $helpers = array('Html', 'Session', 'Form', 'Paginator');
    public $uses = array('AutorRelator', 'Pl', 'AutorRelatorImport');
    var $scaffold = 'admin';
    //var $transformUrl = array('url_amigavel' => 'titulo_ptbr');

    var $paginate = array(
                            'limit'  => 10,

                           );

       //// Nescessário ter o beforeFilter
       function beforeFilter() {
           parent::beforeFilter();
           $this->Auth->allow('admin_alterarAutorRelator');


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
        $model = 'AutorRelator';
        $this->set('model' , $model);

        $this->paginate = array(
            'order' => array(
                'nome' => 'ASC'
            )
        );
        // >>> FILTRO
        $conditions = array();
        if( $this->request->is('post') || $this->request->is('put') ){
            $buscar = $this->request->data[$model]['search'];
            if( !empty($buscar) ):
                $conditions = array(
                    $model.'.nome Like' => '%'.$buscar.'%',
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }

        $this->paginate['conditions'] = array($conditions);
        $regitros = $this->paginate($model);



        $this->set('registros', $regitros );
    }

    public function admin_add(){
        $model = 'AutorRelator';
        $this->set('model' , $model);

        /// Verifica se houve post para salvar as informações
        if ($this->request->is('post')){

            /// Seta a model com as informações que vieram do post
            $this->$model->set($this->request->data);

            /// Verifica se a Model está válida.
            /// OBS.: caso estejamos utilizando algum validate da Model, o Cake irá printar o que há de errado no ELSE deste script
            if($this->$model->validates()){
                /// Gravando dados na base de ados
                if ($this->$model->save($this->request->data)){

                    // Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
                    $this->Session->setFlash('Autor/Relator adicionado com sucesso!');

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
        $model = 'AutorRelator';
        $this->set('model' , $model);

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
                    $this->Session->setFlash('Autor/Relator alteradoAutorRelator com sucesso!');

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

    /* DELETE     */
    function admin_delete($id){
    	$model = 'AutorRelator';

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
			$this->Session->setFlash('Autor/Relator excluído com sucesso!');

			// Redirecionando o usuário para a listagem dos registros
			$this->redirect(array('action' => 'index'));
		}
    }

    /*
    * pegar o nome do autor e settar no campo autor_bk
    * o nome do relator e settar no campo relator_bk
    * utilizar como BK do BD Original
    */
    // DOCS
    //>>> rodar este sql até o DIE();
    /*
        ALTER TABLE `arearestrita`.`tb_pls`
        ADD COLUMN `autor_bk` VARCHAR(255) NULL AFTER `relator`,
        ADD COLUMN `relator_bk` VARCHAR(255) NULL AFTER `autor_bk`;
        ============================================================================+
        CREATE TABLE `arearestrita`.`tb_autor_relator` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `nome` VARCHAR(300) NULL,
          `ativo` TINYINT(1) NULL DEFAULT 1,
          `created` DATETIME NULL,
          `modified` DATETIME NULL,
          PRIMARY KEY (`id`));


        ALTER TABLE `arearestrita`.`tb_autor_relator`
        ADD FULLTEXT INDEX `ix_autornome_fulltext` (`nome` DESC);
        ============================================================================+
    //<<< rodar este sql até o DIE();

    //>>> comentar isso na model de Pl
        'Autor' => array(
            'className'             => 'Autor',
            'foreignKey'            => 'autor_id',
            'dependent' => true,
        ),
        'Relator' => array(
            'className'             => 'Relator',
            'foreignKey'            => 'relator_id',
            'dependent' => true,
        ),
    //<<< comentar isso na model de Pl





        ///////////////////
        ///
        apos rodar as querys e esta function, comentar este trecho de codigo
        pois, não da tempo de execultar de primeira.
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////
        // //>>> fazer bk dos campos autor/relator_bk
        // if(!empty($autor)){
        //     $this->Pl->saveField('autor_bk', $autor);
        // }
        // if(!empty($relator)){
        //     $this->Pl->saveField('relator_bk', $relator);
        // }
        ///////
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        ///
        ///////////////////


    */
    //<<< rodar este sql até o DIE();
    public function admin_alterarAutorRelator(){
        $this->autoRender = false;
        // die('VERIFIQUE OS COMENTARIOS ANTES DE CONTINUAR');
        // $model = 'Autor';
        //
        // $listAutoresRelatores = $this->Pl->find('all', array(
        //     'fields' => array(
        //         'Pl.id',
        //         'Pl.autor',
        //         'Pl.relator',
        //         'Pl.autor_bk',
        //         'Pl.relator_bk',
        //     )
        // ));
        //
        //
        //
        // /*
        // * listar todos os autores e relatores
        // */
        // foreach( $listAutoresRelatores as $AutorRelator ){
        //     $this->Pl->id = $AutorRelator['Pl']['id'];
        //     $autor = $AutorRelator['Pl']['autor'];
        //     $relator = $AutorRelator['Pl']['relator'];
        //
        //     ////////////////////////////////////////////////////////////////////////////////////////////////////
        //     // ///////
        //     // //>>> fazer bk dos campos autor/relator_bk
        //     //     if(!empty($autor)){
        //     //         $this->Pl->saveField('autor_bk', $autor);
        //     //     }
        //     //     if(!empty($relator)){
        //     //         $this->Pl->saveField('relator_bk', $relator);
        //     //     }
        //     // ///////
        //     ////////////////////////////////////////////////////////////////////////////////////////////////////
        // }
        //
        //
        //
        // /*
        // * 1 - tratar os compos de autor_bk e relator_bk montando em um array() sem registros empty()
        // * 2 - remover as duplicidades do campo
        // * 3 - Inserir os dados na tabela da model AutorRelator
        // * 4 - pegar o Pl.id e salvar em PlAutorRelator.pl_id, se Pl.autor_bk set PlAutorRelator.autor = 1  Pl.relator_bk  set set PlAutorRelator.relator = 1
        // */
        // /////////////////////////
        // // >>> etapa 1
        // $autor_relator_string = '';
        // $countElements = count($listAutoresRelatores);
        // $countAux = 0;
        // foreach( $listAutoresRelatores as $AutorRelator ){
        //     $autor = $AutorRelator['Pl']['autor_bk'];
        //     $relator = $AutorRelator['Pl']['relator_bk'];
        //     if(end($listAutoresRelatores) !== $AutorRelator){
        //         $autor_relator_string = $autor_relator_string.$autor.','.$relator.',';
        //     }else{
        //         $autor_relator_string = $autor_relator_string.$autor.','.$relator;
        //     }
        // }
        //
        // $a_autor_relator = explode(",", $autor_relator_string);//<<< transformar conteudo em array()
        // $a_autor_relator = array_filter($a_autor_relator);//<<< remover conteudo empty
        //
        // // <<< etapa 1
        // /////////////////////////
        //
        // /////////////////////////
        // // >>> etapa 2
        // $remove_duplicate = array_unique($a_autor_relator);
        // // <<< etapa 2
        // /////////////////////////
        //
        // /////////////////////////
        // // >>> etapa 3
        // foreach($remove_duplicate as $elemet){
        //     $a_AutorRelatorMigrate['AutorRelator'] = array(
        //         'nome' => $elemet
        //     );
        //     $this->AutorRelator->create();
        //     $this->AutorRelator->save($a_AutorRelatorMigrate);
        // }
        // // <<< etapa 3
        // /////////////////////////
        //
        //
        //
        //
        //
        //
        // ///////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////
        // echo 'Total de nomes migrado: '.count($remove_duplicate). " ";
        // die();
        // DOCS
        /*
        *
        >>> comentar todo o codigo acima e rodar o seuinte sql


        ALTER TABLE `arearestrita`.`tb_pls`
            CHANGE COLUMN `autor` `autor_id` VARCHAR(255) NULL DEFAULT NULL ,
            CHANGE COLUMN `relator` `relator_id` VARCHAR(255) NULL DEFAULT NULL ;






        <<< comentar todo o codigo acima e rodar o seuinte sql
        */
        ///////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////




        /////////////////////////
        // <<< etapa 4
        $listAutoresRelatores = $this->Pl->find('all', array(
            'fields' => array(
                'Pl.id',
                'Pl.autor_bk',
                'Pl.relator_bk',
                'Pl.numero_da_pl',
            )
        ));
        foreach( $listAutoresRelatores as $AutorRelator ){
            $this->Pl->id = $AutorRelator['Pl']['id'];
            // $this->Pl->read(null, $AutorRelator['Pl']['id']);
            $autor = $AutorRelator['Pl']['autor_bk'];
            $relator = $AutorRelator['Pl']['relator_bk'];
            $numeroPl = $AutorRelator['Pl']['numero_da_pl'];

            if( !empty($autor) ){
                $acharAutorRelator = $this->AutorRelator->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'AutorRelator.nome' => $autor
                    )
                ));
                $this->Pl->saveField('autor_id', $acharAutorRelator['AutorRelator']['id']);
                // $this->Pl->saveField('numero_da_pl', $numeroPl);
            }
            if( !empty($relator) ){
                $acharAutorRelator = $this->AutorRelator->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'AutorRelator.nome' => $relator
                    )
                ));

                $this->Pl->saveField('relator_id', $acharAutorRelator['AutorRelator']['id']);


            }

        }
        // <<< etapa 4
        /////////////////////////









        die('Concluido');
    }


    public function admin_import(){
        $model = 'AutorRelator';
        $this->set('model', $model);

        if( $this->request->is('post') ){

            $this->request->data['AutorRelatorImport'] = $this->request->data['AutorRelator'];
            // inicia validação da Model
			$this->AutorRelatorImport->set($this->request->data);

			if ($this->AutorRelatorImport->validates()) {
                if( $this->AutorRelatorImport->save($this->request->data) ){
                    $arquivoLastID = $this->AutorRelatorImport->getLastInsertID();
                    $buscarArquivoInserido = $this->AutorRelatorImport->find('first', array(
                        'fields' => array('id', 'arquivo', 'dir'),
                        'conditions' => array(
                            'AutorRelatorImport.id' => $arquivoLastID
                        )
                    ));
                    $arquivoCaminhoAbsoluto = $_SERVER['DOCUMENT_ROOT'].$this->webroot.'app/webroot/'.$buscarArquivoInserido['AutorRelatorImport']['dir'].'/'.$buscarArquivoInserido['AutorRelatorImport']['arquivo'];

                    //>>> leitura do arquivo .xlsx
                    $objReader = new PHPExcel_Reader_Excel2007();
                    $objReader->setReadDataOnly(true);
                    $objPHPExcel = $objReader->load($arquivoCaminhoAbsoluto);
                    //<<< leitura do arquivo .xlsx
                    if($this->_activeSheetIndex == 0):
                        if( $objPHPExcel->setActiveSheetIndex(0) ):
                            //>>> abrindo arquivo pra leitura
                            $objPHPExcel->setActiveSheetIndex(0);
                            $dataArray = $objPHPExcel->getActiveSheet()->toArray();
                            //<<< abrindo arquivo pra leitura

                            foreach ($dataArray as $key => $value) {
                                if($dataArray[$key] != $dataArray[0]){
                                    $nome = $value[0]. ' - ' . $value[1] .' - ' .$value[2];
                                    // $nome = $value[0];

                                    /*
                                    *
                                    * para evitar duplicidade de nomes
                                    * verificar se o mesmo ja existe no BD
                                    */
                                    $buscarAutorRelator = $this->$model->find('first', array(
                                        'fields' => array('id', 'nome'),
                                        'conditions' => array($model.'.nome' => $nome)
                                    ));

                                    if( empty($buscarAutorRelator) ):
                                        $a_newAutorRelator[$model] = array(
                                            'nome' => $nome,
                                            'ativo' => true
                                        );
                                        /*
                                        *
                                        * criar novo autor/relator
                                        */
                                        $this->$model->create();
                                        $this->$model->save($a_newAutorRelator);
                                    endif;
                                }
                            }

                        endif;
                    endif;

                    $this->Session->setFlash('Concluido com Sucesso.');
                    $this->redirect(array('action' => 'admin_import'));
                }
            }
        }


    }
}

?>
