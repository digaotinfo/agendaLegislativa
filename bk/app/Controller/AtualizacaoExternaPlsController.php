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
    // public function admin_atualizacaoCamara(){
    //     $this->autoRender = false;
    //     // die('teste');
    //     $corpo = $this->request->data['txt'];
    //
    //     $tipo = '';
    //     $tipoID = '';
    //     $tiposId = '';
    //     $tiposName = '';
    //     $numero_da_pl = '';
    //     $ano = '';
    //     $pl_id = '';
    //     $jaExiste = '';
    //     $anoPl = '';
    //     $acheiTipo = 0;
    //     $propCompleta = '';
    //     $txt = '';
    //
    //     $tipos = $this->PlType->find('all', array(
    //         'fields' => array(
    //             'PlType.id',
    //             'PlType.tipo',
    //         ),
    //         'recursive' => -2
    //     ));
    //     foreach( $tipos as $index => $tipo ){
    //         $index++;
    //         if( count($tipos) == $index ){
    //             $tiposName = $tiposName.$tipo['PlType']['tipo'];
    //             $tiposId = $tiposId.$tipo['PlType']['id'];
    //         }else{
    //             $tiposName = $tiposName.$tipo['PlType']['tipo'].',';
    //             $tiposId = $tiposId.$tipo['PlType']['id'].',';
    //         }
    //     }
    //
    //     $a_prop = array();
    //     $a_propNew = array();
    //     $tipo = '';
    //     $acheiTipo = '';
    //     $acheiTipo = '';
    //     $explodeType = '';
    //     foreach(explode(',', $tiposName) as $tipo){
    //         $tipo = $tipo.'-';
    //         $acheiTipo = strripos( $corpo, $tipo );
    //         $acheiTipo = intval($acheiTipo);
    //         $explodeType = '';
    //
    //         if( $acheiTipo > 0 ){
    //             $tratarStr = substr($corpo, $acheiTipo);
    //             $explodeType = explode('/', $tratarStr);
    //             $tipo = str_Replace('-', '', $tipo);
    //             // $tipoFindId = $this->PlType->find('first', array(
    //             //     'fields' => array(
    //             //         'PlType.id',
    //             //         'PlType.tipo'
    //             //     ),
    //             //     'conditions' => array(
    //             //         'PlType.tipo' => $tipo
    //             //         ),
    //             //         'recursive' => -2
    //             // ));
    //             $a = array(
    //                 'tipo' => $tipo
    //             );
    //             array_push($a_prop, $a);
    //         }
    //         echo "<pre>";
    //         print_r( $explodeType );
    //         echo "</pre>";
    //     }
    //
    //     die();
    // // }

}

?>
