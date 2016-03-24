<?php
App::import('Vendor', 'receiveMail/receiveMail');
class AtualizacaoExternaPlsController extends AppController{
    var $name = "AtualizacaoExternaPl";
    public $helpers = array('Html', 'Session', 'Form', 'Paginator');
    public $uses = array('AtualizacaoExternaPl', 'PlType');
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
        $model = 'AtualizacaoExternaPl';
        $this->set('model' , $model);

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
                    "OR" => array(
                        $model.'.remetente Like' => '%'.$buscar.'%',
                        $model.'.corpo Like' => '%'.$buscar.'%',
                        $model.'.assunto Like' => '%'.$buscar.'%',
                    )
                );
                $this->paginate['conditions'] = array($conditions);
            endif;
        }

        $this->paginate['conditions'] = array($conditions);
        $this->set('registros', $this->paginate($model));
    }

    public function admin_atualizacoesEmail(){
        $this->autoRender = false;
        // die('aki');
        $this->receiveMail();

    }

    public function admin_verAtualizacao( $id=null ){
        $model = 'AtualizacaoExternaPl';
        $this->set('model', $model);

        $registro = $this->$model->find('first', array(
            'conditions' => array(
                'AtualizacaoExternaPl.id' => $id
            )
        ));
        $this->set('registro', $registro);
        $this->$model->id = $id;
        $this->$model->saveField('lido', true);

    }


}

?>
