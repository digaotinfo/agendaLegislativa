<?php

App::uses('CakeTime', 'Utility');

class JsonsController extends AppController{
    var $name = "Jsons";
    public $helpers = array('Html', 'Session', 'Time');
    public $uses = array('Conteudo', 'Conteudoempresa', 'Empresa');



    function admin_login(){
        $login = array();
        $this->autoRender = false ;
        if ($this->request->is('post'))	{
            if( $this->Auth->login()) {
                 $keypass = $this->Auth->user('empresa_id')*2313231323132313;
                 $login = array(
                     'acesso' => 1,
                     'empresa_id' => $this->Auth->user('empresa_id'),
                     'post_keypass' => 'BL'.$keypass.'AC'
                 );
            } else {

                 $login = array(
                     'acesso' => 0,
                     'empresa_id' => '',
                     'post_keypass' => ''
                 );
            }
        }
        echo json_encode($login);
    }

    function admin_genericos(){
            // $keypass = $this->Auth->user('empresa_id')*2313231323132313;
            // $login = array(
            //     'acesso' => 1,
            //     'empresa_id' => $this->Auth->user('empresa_id'),
            //     'post_keypass' => 'BL'.$keypass.'AC'
            // );
        $this->autoRender = false ;

        $model = 'Conteudo';
        $this->set('model', $model);



        $keypass = $this->params->query['keypass'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;

        $sql = "SELECT c.*, e.empresa_id FROM tb_conteudo as c JOIN tb_conteudo_empresas as e ON c.id = e.conteudo_id WHERE e.empresa_id = {$empresa_id}";


        $all = $this->$model->query($sql);

        $json_rdy["conteudos"] = array();

        foreach($all as $content){
            $created = CakeTime::format('%d | %e de %B',$content['c']['created']);
            $json_rdy["conteudos"] = array(
                    "id" => $content['c']['id'],
                    "categoria_id" => $content['c']['categoria_id'],
                    "titulo" => $content['c']['titulo'],
                    "texto" => $content['c']['texto'],
                    "created" => $created
            );
        }

        echo "<pre>";
        print_r($json_rdy);

    }
}
