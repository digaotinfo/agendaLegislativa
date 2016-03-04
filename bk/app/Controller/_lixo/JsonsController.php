<?php

App::uses('CakeTime', 'Utility');

class JsonsController extends AppController{
    var $name = "Jsons";
    public $helpers = array('Html', 'Session', 'Time');
    public $uses = array('User', 'Conteudo', 'ConteudoSetor', 'Setor', 'Mapa', 'Galeria', 'Log', 'Telefone', 'Categoria');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(
							'admin_login', 
							'admin_genericos', 
							'admin_manifestacoes', 
							'admin_galerias', 
							'admin_atualizacao', 
							'admin_contatos', 
							'admin_atualizacaoteste',
							'admin_loginandroid', 
							'admin_genericosandroid', 
							'admin_manifestacoesandroid', 
							'admin_galeriasandroid', 
							'admin_atualizacaoandroid', 
							'admin_contatosandroid',
                            'admin_categorias'
					);
	}

    function admin_login(){
        ini_set('display_errors', 'Off');
        $login = array();
        $this->autoRender = false ;
        $this->response->type('json');
        
        //print_r($this);
        //die();
        
        if ($this->request->is('post'))	{
        
        	$usuario = $this->User->find('first', array(
        											'fields' => array(
        												'User.id',
        											),
        											'conditions' => array(
        												'username' => $this->request->data['username'],
        												'password' => AuthComponent::password($this->request->data['password']),
        											),
        											'recursive' => -1,
        										));
        
        	//print_r($usuario);
        	//die();
            //if( $this->Auth->login()) {
            if (!empty($usuario)) {
                 $keypass = $usuario['User']['id']*2313231323132313;
                 $login = array(
                     'acesso' => 1,
                     'empresa_id' => '',
                     'usuario_id' => $usuario['User']['id'],
                     'post_keypass' => 'BL'.$keypass.'AC'
                 );
            } else {

                 $login = array(
                     'acesso' => 0,
                     'empresa_id' => '',
                     'usuario_id' => '',
                     'post_keypass' => ''
                 );
            }
        }
        //echo json_encode($login);
        $json = json_encode($login);
        $this->response->body($json);
    }

    function admin_categorias(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $model = 'Categoria';



        $keypass = $this->params->query['k'];
        $usuario_id = substr($keypass,2, -2);
        $usuario_id = $usuario_id / 2313231323132313;


        $sql = "SELECT DISTINCT
                    Categoria.id,
                    Categoria.categoria,
                    Categoria.documentos,
                    Categoria.noticias,
                    Categoria.missao_visao_valores

                FROM 
                    tb_categorias as Categoria
                    INNER JOIN tb_conteudo as Conteudo ON (Categoria.id = Conteudo.categoria_id)
                    INNER JOIN tb_conteudo_setores as ConteudoSetor ON (Conteudo.id = ConteudoSetor.conteudo_id)
                    INNER JOIN usuarios_setores as UsuarioSetor ON (ConteudoSetor.setor_id = UsuarioSetor.setor_id)

                WHERE 
                    UsuarioSetor.user_id = {$usuario_id} 
                    AND Conteudo.publicar = 1 

                ORDER BY 
                    Categoria.ordem ASC";

        // $sql = "SELECT 
        //             c.*, 
        //             e.empresa_id 
                
        //         FROM 
        //             tb_conteudo as c 
        //             JOIN tb_conteudo_empresas as e ON c.id = e.conteudo_id 

        //         WHERE 
        //             e.empresa_id = {$empresa_id} 
        //             AND c.publicar = 1 

        //         ORDER BY 
        //             c.id DESC";
        
        //print_r($sql);
        //die();

        $all = $this->$model->query($sql);

        $json_rdy["categorias"] = array();

        foreach($all as $content){
            //$texto = htmlentities($content['c']['texto']);
            //$texto = json_encode($content['c']['texto']);

            $conteudo = array(
                    "id" => $content['Categoria']['id'],
                    "categoria"             => $content['Categoria']['categoria'],
                    "documentos"            => $content['Categoria']['documentos'],
                    "noticias"              => $content['Categoria']['noticias'],
                    "missao_visao_valores"  => $content['Categoria']['missao_visao_valores']
            );
            array_push($json_rdy["categorias"], $conteudo);
        }

        // echo "<pre>";
        // print_r($json_rdy);

        //echo json_encode($json_rdy);
        $json = json_encode($json_rdy);
        $this->response->body($json);

    }

    function admin_genericos(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $meses = array(
            'January' => 'Janeiro',
            'February' => 'Fevereiro',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Setembro',
            'October' => 'Outubro',
            'November' => 'Novembro',
            'December' => 'Dezembro'
        );
        $dia_semana = array(
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        );

        $model = 'Conteudo';



        $keypass = $this->params->query['k'];
        $usuario_id = substr($keypass,2, -2);
        $usuario_id = $usuario_id / 2313231323132313;


        $sql = "SELECT DISTINCT
                    c.id,
                    c.categoria_id,
                    c.titulo,
                    c.texto,
                    c.modified

                FROM 
                    tb_conteudo as c 
                    INNER JOIN tb_conteudo_setores as e ON c.id = e.conteudo_id 
                    INNER JOIN usuarios_setores as us on e.setor_id = us.setor_id
                    

                WHERE 
                    us.user_id = {$usuario_id} 
                    AND c.publicar = 1 

                ORDER BY 
                    c.id DESC";

        // $sql = "SELECT 
        //             c.*, 
        //             e.empresa_id 
                
        //         FROM 
        //             tb_conteudo as c 
        //             JOIN tb_conteudo_empresas as e ON c.id = e.conteudo_id 

        //         WHERE 
        //             e.empresa_id = {$empresa_id} 
        //             AND c.publicar = 1 

        //         ORDER BY 
        //             c.id DESC";
        
        //print_r($sql);
        //die();

        $all = $this->$model->query($sql);

        $json_rdy["conteudos"] = array();

        foreach($all as $content){
            $created = CakeTime::format('l d F',$content['c']['modified']);
            $created = explode(' ', $created);
            $created = "{$dia_semana[$created[0]]} | {$created[1]} de {$meses[$created[2]]}";

            //$texto = htmlentities($content['c']['texto']);
            //$texto = json_encode($content['c']['texto']);
            $texto = $content['c']['texto'];

            $conteudo = array(
                    "id" => $content['c']['id'],
                    "categoria_id" => $content['c']['categoria_id'],
                    "titulo" => $content['c']['titulo'],
                    "texto" => $texto,
                    "created" => $created
            );

            array_push($json_rdy["conteudos"], $conteudo);
        }

        // echo "<pre>";
        // print_r($json_rdy);

        //echo json_encode($json_rdy);
        $json = json_encode($json_rdy);
        $this->response->body($json);

    }

    function admin_contatos(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');
        
        $model = 'Telefone';
        
        $keypass = $this->params->query['k'];
        $usuario_id = substr($keypass,2, -2);
        $usuario_id = $usuario_id / 2313231323132313;

        $sql = "SELECT 
                        c.id,
                        c.telefones
                FROM 
                    tb_telefones as c 
                    INNER JOIN tb_telefones_setores as e ON c.id = e.telefone_id 
                    INNER JOIN usuarios_setores as us on e.setor_id = us.setor_id
                WHERE 
                    us.user_id = {$usuario_id}  
                    AND c.ativo = 1 
                ORDER BY 
                    c.id DESC 
                LIMIT 1";

        // $sql = "SELECT 
        //                 c.*, 
        //                 e.empresa_id 
        //         FROM 
        //             tb_telefones as c 
        //             JOIN tb_telefones_empresas as e ON c.id = e.telefone_id 
        //         WHERE 
        //             e.empresa_id = {$empresa_id} 
        //             AND c.ativo = 1 
        //         ORDER BY 
        //             c.id DESC 
        //         LIMIT 1";
        
        //print_r($sql);
        //die();

        $all = $this->$model->query($sql);

        $json_rdy["contatos"] = array();

        foreach($all as $content){
           
            $conteudo = array(
                    "id" => $content['c']['id'],
                    "telefones" => $content['c']['telefones']
            );

            array_push($json_rdy["contatos"], $conteudo);
        }

        // echo "<pre>";
        // print_r($json_rdy);

        //echo json_encode($json_rdy);
        $json = json_encode($json_rdy);
        $this->response->body($json);

    }

    function admin_galerias(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $model = 'Galeria';

        $keypass = $this->params->query['k'];
        $usuario_id = substr($keypass,2, -2);
        $usuario_id = $usuario_id / 2313231323132313;

        $json_rdy['galerias'] = array();

        //$all = $this->$model->find('all', array('order' => 'Galeria.id DESC'));
        $sql = "SELECT DISTINCT
                    Galeria.conteudo_id,
                    Galeria.img_file,
                    Galeria.legenda
                FROM
                    tb_galeria as Galeria
                    INNER JOIN tb_conteudo as Conteudo on (Galeria.conteudo_id = Conteudo.id)
                    INNER JOIN tb_conteudo_setores as ConteudoSetor on (Conteudo.id = ConteudoSetor.conteudo_id)
                    INNER JOIN usuarios_setores as UsuarioSetor on (ConteudoSetor.setor_id = UsuarioSetor.setor_id)
                WHERE
                    UsuarioSetor.user_id = {$usuario_id} 
                ORDER BY
                    Galeria.id DESC";
        $all = $this->$model->query($sql);
        
        $this_url = Router::url( '/', true );
        
        if ($this_url == 'http://server.local/santosbrasil-admin/www/') {
	        $this_url = 'http://10.0.1.7/santosbrasil-admin/www/';
        }
        
        
        

        foreach($all as $galeria){
            $gal = $galeria["Galeria"];

            $conteudo = array(
                "conteudo_id" => $gal["conteudo_id"],
                //"imagem" => $this_url."uploads/img/galerias/".$gal['img_file'],
                "imagem" => $this_url.$gal['img_file'],
                "legenda" => (empty($gal['legenda'])) ? '' : $gal['legenda']
            );

            array_push($json_rdy["galerias"], $conteudo);
        }

        //echo json_encode($json_rdy);
        $json = json_encode($json_rdy);
        $this->response->body($json);
    }

    function admin_atualizacao(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $model = 'Log';
        $this->set('model', $model);

        
        $keypass = $this->params->query['k'];
        $user_id = substr($keypass,2, -2);
        $user_id = $user_id / 2313231323132313;
        

        $sql_usuario_setor = "SELECT 
                                us.setor_id
                            FROM
                                usuarios_setores as us
                            WHERE
                                us.user_id = {$user_id}";
        $all_usuario_setor= $this->$model->query($sql_usuario_setor);
        $setores_id = '';
        foreach ($all_usuario_setor as $setor_id) {
            $setores_id .= $setor_id['us']['setor_id'] ."|";
        }
        $total_setores = rtrim($setores_id, "|");
        
        $lastCreated = $this->$model->find('first', array(
            'conditions' => array(
            	"setor_ids REGEXP '{$total_setores}'"
            ),
            'order' => array($model.'.id' => 'desc'),
        ));

        $json_rdy = array('data' => $lastCreated['Log']['data_alteracao'], 'setor_ids' => $lastCreated['Log']['setor_ids']);

        //echo json_encode($json_rdy);
        $json = json_encode($json_rdy);
        $this->response->body($json);
    }

    function admin_atualizacaoteste(){
        //ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        //$this->response->type('json');

        $model = 'Log';
        $this->set('model', $model);

        
        $keypass = $this->params->query['k'];
        $user_id = substr($keypass,2, -2);
        $user_id = $user_id / 2313231323132313;
        
        
        $sql_usuario_setor = "SELECT 
                                us.setor_id
                            FROM
                                usuarios_setores as us
                            WHERE
                                us.user_id = {$user_id}";
        $all_usuario_setor= $this->$model->query($sql);
        $setores_id = '';
        foreach ($all_usuario_setor as $setor_id) {
            $setores_id .= $setor_id['us'][setor_id] ."|";
        }
        $total_setores = rtrim($setores_id, "|");
        
        $lastCreated = $this->$model->find('first', array(
            'conditions' => array(
                "setor_ids REGEXP '{$total_setores}'"
            ),
            'order' => array($model.'.id' => 'desc'),
        ));
        
        echo 'Usuário: '. $user_id .'<br>';
        print_r($lastCreated);
    }
    
    
    
    
    
    
    
    
    ///// ANDROID ====////
    function admin_loginandroid(){
        ini_set('display_errors', 'Off');
        $login = array();
        $this->autoRender = false;
        $this->response->type('json');
        
        //print_r($this->request);
        //die();
        
        if ($this->request->is('post'))	{
        
        	$usuario = $this->User->find('first', array(
        											'fields' => array(
        												'empresa_id',
        											),
        											'conditions' => array(
        												'username' => $this->request->data['username'],
        												'password' => AuthComponent::password($this->request->data['password']),
        											),
        											'recursive' => -1,
        										));
        
        	//print_r($usuario);
        	//die();
            //if( $this->Auth->login()) {
            if (!empty($usuario)) {
                 $keypass = $usuario['User']['empresa_id']*2313231323132313;
                 $login = array(
                     'acesso' => 1,
                     'empresa_id' => $usuario['User']['empresa_id'],
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
        //echo json_encode($login);

        $json = json_encode($login);
        $this->response->body($json);
    }

    function admin_genericosandroid(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false;
        $this->response->type('json');

        $meses = array(
            'January' => 'Janeiro',
            'February' => 'Fevereiro',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Setembro',
            'October' => 'Outubro',
            'November' => 'Novembro',
            'December' => 'Dezembro'
        );
        $dia_semana = array(
            'Monday' => 'Segunda-feira',
            'Tuesday' => 'Terça-feira',
            'Wednesday' => 'Quarta-feira',
            'Thursday' => 'Quinta-feira',
            'Friday' => 'Sexta-feira',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        );

        $model = 'Conteudo';



        $keypass = $this->params->query['k'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;

        $sql = "SELECT c.*, e.empresa_id FROM tb_conteudo as c JOIN tb_conteudo_empresas as e ON c.id = e.conteudo_id WHERE e.empresa_id = {$empresa_id} AND c.publicar = 1 ORDER BY c.id DESC";
        
        //print_r($sql);
        //die();

        $all = $this->$model->query($sql);

        $json_rdy["conteudos"] = array();

        foreach($all as $content){
            $created = CakeTime::format('l d F',$content['c']['created']);
            $created = explode(' ', $created);
            $created = "{$dia_semana[$created[0]]} | {$created[1]} de {$meses[$created[2]]}";

            //$texto = htmlentities($content['c']['texto']);
            //$texto = json_encode($content['c']['texto']);
            $texto = $content['c']['texto'];

            $conteudo = array(
                    "id" => $content['c']['id'],
                    "categoria_id" => $content['c']['categoria_id'],
                    "titulo" => $content['c']['titulo'],
                    "texto" => $texto,
                    "created" => $created
            );

            array_push($json_rdy["conteudos"], $conteudo);
        }

        // echo "<pre>";
        // print_r($json_rdy);

        //echo json_encode($json_rdy);

        $json = json_encode($json_rdy);
        $this->response->body($json);

    }

    function admin_contatosandroid(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false;
        $this->response->type('json');
        
        $model = 'Telefone';
        
        $keypass = $this->params->query['k'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;

        $sql = "SELECT c.*, e.empresa_id FROM tb_telefones as c JOIN tb_telefones_empresas as e ON c.id = e.telefone_id WHERE e.empresa_id = {$empresa_id} AND c.ativo = 1 ORDER BY c.id DESC LIMIT 1";
        
        //print_r($sql);
        //die();

        $all = $this->$model->query($sql);

        $json_rdy["contatos"] = array();

        foreach($all as $content){
           
            $conteudo = array(
                    "id" => $content['c']['id'],
                    "telefones" => $content['c']['telefones']
            );

            array_push($json_rdy["contatos"], $conteudo);
        }

        // echo "<pre>";
        // print_r($json_rdy);

        //echo json_encode($json_rdy);

        $json = json_encode($json_rdy);
        $this->response->body($json);

    }
    

    function admin_manifestacoesandroid(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $model = 'Mapa';
        
        $keypass = $this->params->query['k'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;

        $json_rdy['manifestacoes'] = array();

        $sql = "SELECT c.*, e.empresa_id, uf.uf, uf.nome, cidade.nome
                FROM tb_manifestacao as c
                JOIN tb_manifestacao_empresa as e ON c.id = e.manifestacao_id
                JOIN tb_estado as uf ON c.estado_id = uf.id
                JOIN tb_cidade as cidade ON c.cidade_id = cidade.id
                WHERE e.empresa_id = {$empresa_id} AND c.publicar = 1
                ORDER BY uf.uf ASC, cidade.nome ASC, c.id DESC";
        $all = $this->$model->query($sql);

        // echo "<pre>";
        // var_dump($all);
        // exit;

        $this_url = Router::url( '/', true );
        
        foreach($all as $content){
            $created = $content['c']['created'];

            //$texto = htmlentities($content['c']['txt_impacto']);
            //$texto = json_encode($content['c']['txt_impacto']);
            $texto = $content['c']['txt_impacto'];

            $conteudo = array(
                    "id" => $content['c']['id'],
                    "cidade" => (empty($content['cidade']['nome']))? '' : $content['cidade']['nome'],
                    "estado" => (empty($content['uf']['nome']))? '' : $content['uf']['nome'],
                    "local" => (empty($content['c']['local']))? '' : $content['c']['local'],
                    "ponto_partida" => (empty($content['c']['ponto_partida']))? '' : $content['c']['ponto_partida'],
                    "ponto_termino" => (empty($content['c']['ponto_termino']))? '' : $content['c']['ponto_termino'],
                    "horario" => (empty($content['c']['horario']))? '' : $content['c']['horario'],
                    "total_manifestantes" => (empty($content['c']['total_manifestantes']))? '' : $content['c']['total_manifestantes'],
                    "txt_impacto" => (empty($texto))? '' : $texto,
                    "img_mapa_file" => (empty($content['c']['img_mapa_file']))? '' : $this_url.$content['c']['img_mapa_file'],
                    "url_materia" => (empty($content['c']['url_materia']))? '' : $content['c']['url_materia'],
                    "created" => $content['c']['created']
            );

            array_push($json_rdy["manifestacoes"], $conteudo);
        }

        //echo json_encode($json_rdy);

        $json = json_encode($json_rdy);
        $this->response->body($json);

    }

    function admin_galeriasandroid(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $model = 'Galeria';

        $keypass = $this->params->query['k'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;

        $json_rdy['galerias'] = array();

        $all = $this->$model->find('all', array('order' => 'Galeria.id DESC'));
        
        $this_url = Router::url( '/', true );
        

        foreach($all as $galeria){
            $gal = $galeria["Galeria"];

            $conteudo = array(
                "conteudo_id" => $gal["conteudo_id"],
                //"imagem" => $this_url."uploads/img/galerias/".$gal['img_file'],
                "imagem" => $this_url.$gal['img_file'],
                "legenda" => (empty($gal['legenda'])) ? '' : $gal['legenda']
            );

            array_push($json_rdy["galerias"], $conteudo);
        }

        //echo json_encode($json_rdy);

        $json = json_encode($json_rdy);
        $this->response->body($json);
    }

    function admin_atualizacaoandroid(){
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
        $this->response->type('json');

        $model = 'Log';
        $this->set('model', $model);

        
        $keypass = $this->params->query['k'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;
        
        
        $lastCreated = $this->$model->find('first', array(
            'conditions' => array(
            	"empresa_ids like '%|{$empresa_id}|%'"
            ),
            'order' => array($model.'.id' => 'desc'),
        ));

        $json_rdy = array('data' => $lastCreated['Log']['data_alteracao'], 'empresa_ids' => $lastCreated['Log']['empresa_ids']);

        //echo json_encode($json_rdy);

        $json = json_encode($json_rdy);
        $this->response->body($json);
    }
    
    
    
    
    
    
    
    
    
    
    
    /*
    function admin_contatosandroid(){
        ini_set('display_errors', 'Off');
        
        $this->autoRender = false ;
        $this->response->type('json');
        
        $model = 'Telefone';
        
        $keypass = $this->params->query['k'];
        $empresa_id = substr($keypass,2, -2);
        $empresa_id = $empresa_id / 2313231323132313;

        $sql = "SELECT c.*, e.empresa_id FROM tb_telefones as c JOIN tb_telefones_empresas as e ON c.id = e.telefone_id WHERE e.empresa_id = {$empresa_id} AND c.ativo = 1 ORDER BY c.id DESC LIMIT 1";
        
        //print_r($sql);
        //die();

        $all = $this->$model->query($sql);

        $json_rdy["contatos"] = array();

        foreach($all as $content){
           
            $conteudo = array(
                    "id" => $content['c']['id'],
                    "telefones" => $content['c']['telefones']
            );

            array_push($json_rdy["contatos"], $conteudo);
        }

        // echo "<pre>";
        // print_r($json_rdy);

        $json = json_encode($json_rdy);
        $this->response->body($json);
        

        //header('Content-Type: application/json');
	    //$this->admin_contatos();
    }
    */
}
