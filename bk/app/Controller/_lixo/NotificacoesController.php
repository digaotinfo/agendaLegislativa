<?
App::import('Core', 'l10n');

class NotificacoesController extends AppController{
	var $name = "Notificacoes";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $components = array('Push');
	public $uses = array('Token', 'Pushfrase', 'Setor', 'Tokenandroid');
	//var $scaffold = 'admin';

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('admin_addtoken', 'addtoken', 'admin_addtoken_android');
	}

	function admin_index() {
		$this->redirect(array('action' => 'criarpush'));
	}

	function admin_addtoken(){
		$this->autoRender = false;
		$model = 'Token';

		//print_r($this->request->data);
		//die();

		if ($this->request->is('post')) {

			$this->$model->set($this->request->data);

			/// CRIANDO
			$existe = $this->$model->findByToken($this->request->data['token']);
			if (empty($existe)) {
				if ($this->$model->validates()) {
					if ($this->$model->saveAll($this->request->data)){
						//$this->redirect(array('action' => 'index', 'admin' => true));
						echo "Salvo com sucesso!";
					}
				}


			/// ATUALIZANDO
			} else {
				//$this->$model->id = $existe[$model]['id'];

				$this->$model->read(null, $existe[$model]['id']);
				$this->$model->set('setor_id', $this->request->data['setor_id']);
				$this->$model->set('usuario_id', $this->request->data['usuario_id']);
				$this->$model->save();

				echo "Salvo com sucesso!";
			}

		}


	}

	function admin_addtoken_android(){
        ini_set('display_errors', 'Off');
		$this->autoRender = false;
		$model = 'Tokenandroid';
		
        $this->response->type('json');

		//print_r($this->request->data);
		//die();
		
		$retorno = 0;
		if ($this->request->is('post')) {

			$this->$model->set($this->request->data);

			/// CRIANDO
			$existe = $this->$model->findByToken($this->request->data['token']);
			if (empty($existe)) {
				if ($this->$model->validates()) {
					if ($this->$model->saveAll($this->request->data)){
						//$this->redirect(array('action' => 'index', 'admin' => true));
						//echo "Salvo com sucesso!";
						$retorno = 1;
					}
				}


			/// ATUALIZANDO
			} else {
				//$this->$model->id = $existe[$model]['id'];
				if (!empty($this->request->data['usuario_id'])) {
					$usuario_id = ($this->request->data['usuario_id'])? $this->request->data['usuario_id'] : 0;
				}

				$this->$model->read(null, $existe[$model]['id']);
				$this->$model->set('setor_id', $this->request->data['setor_id']);
				if (!empty($this->request->data['usuario_id'])) {
					$this->$model->set('usuario_id', $usuario_id);
				}
				$this->$model->save();

				//echo "Salvo com sucesso!";
				$retorno = 1;
			}

		}

        //echo json_encode($login);
        $json = json_encode(array('success' => $retorno));
        $this->response->body($json);

	}

	function admin_criarpush() {
		$model = 'Pushfrase';
		$this->set('model', $model);

		$frase = $this->$model->find('first', array(
												'fields' => array(
													'frase',
												),
												'order' => 'id DESC',
											));
		$this->set('frase', $frase);



		$setores = $this->Setor->find('list', array(
														'fields' => array(
																		'id',
																		'setor'
																	),
														'conditions' => array(
																		'ativo' => 1
																				)
																		));
		$this->set('setores', $setores);
	}




	function admin_criarpushprod() {
		$model = 'Pushfrase';
		$this->set('model', $model);

		$frase = $this->$model->find('first', array(
												'fields' => array(
													'frase',
												),
												'order' => 'id DESC',
											));
		$this->set('frase', $frase);



		$setores = $this->Setor->find('list', array(
														'fields' => array(
																		'id',
																		'setor'
																	),
														'conditions' => array(
																		'ativo' => 1
																				)
																		));
		$this->set('setores', $setores);
	}


	function admin_enviarpush($message = null) {
		$this->autoRender = false;
		$model = 'Token';

		//print_r($this->request->data);
		//die();

		////////////////////////////////////////////////////////////////////////////////
		// Put your alert message here:
		$message_backup = 'Existem novas atualizações!';

		$message 	= $this->request->data['Pushfrase']['frase'];
		$setores 	= $this->request->data['Pushfrase']['setores'];
		$todos 		= $this->request->data['Pushfrase']['todos'];

		if (empty($setores)) {
			$this->Session->setFlash('Favor informar o(s) setor(es).');
			$this->redirect(array('action' => 'criarpush'));
		}
		//print_r($todos);
		//die();

		if (empty($message)) {
			$message = $message_backup;
		}

		// Put your private key's passphrase here:
		$tipoProducao = true;
		$passphrase;
		$url_ssl;
		$pem;
		if ($tipoProducao) {
			$passphrase 	= 'zpass2010';
			$url_ssl 		= 'ssl://gateway.push.apple.com:2195';
			$pem 			= 'ck_prod.pem';
		} else {
			$passphrase 	= 'zoio2010';
			$url_ssl 		= 'ssl://gateway.sandbox.push.apple.com:2195';
			$pem 			= 'ck.pem';
		}
		////////////////////////////////////////////////////////////////////////////////


		//GRAVA A FRASE ESCRITA
		$this->Pushfrase->create();
		$this->Pushfrase->set('frase', $message);
		$this->Pushfrase->save();

		/*
		$db = $this->$model->getDataSource();
		$db->fullDebug = true;
		*/
		$registros = array();
		if ($todos == 1) {
			//die('aqui');
			$registros = $this->$model->find('all', array(
														'fields' => array(
															'token',
														)
													));
		} else {
			/*
			$registros = $this->$model->find('all', array(
														'fields' => array(
															'token',
														),
														'conditions' => array(
															'setor_id' => $setores
														)
													));
			*/
			$setores_str = '';
			foreach ($setores as $setor):
				$setores_str .= $setor .',';
			endforeach;
			$setores_final = rtrim($setores_str, ',');
			
			//echo $setores_final;
			//die();
			
			$registros = $this->$model->query('
											Select 
												Token.token
											From
												tb_tokens as Token
											
											where 
												Token.usuario_id in (
																SELECT
																	US.user_id
																FROM
																	usuarios_setores as US
																WHERE
																	setor_id in ('. $setores_final .')
															)
											');
		}
		
		
		
		
		/*
		$log = $db->getLog();
		$db->fullDebug = false;
		print_r($log);

		print_r($registros);
		die();
		*/


		foreach ($registros as $registro) {
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'pem/'.$pem);
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

			// Open a connection to the APNS server
			$fp = stream_socket_client(
				$url_ssl, $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

			if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);

			//echo 'Connected to APNS' . PHP_EOL;

			// Create the payload body
			$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default'
				);

			// Encode the payload as JSON
			$payload = json_encode($body);


			//foreach ($registros as $registro) {
				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $registro[$model]['token']) . pack('n', strlen($payload)) . $payload;

				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));

				if (!$result) {
					//echo '<br>'. $registro[$model]['token'] .': Message not delivered' . PHP_EOL;
					$this->Session->setFlash('Mensagens não enviadas...');
				} else {
					//echo '<br>'. $registro[$model]['token'] .': Message successfully delivered' . PHP_EOL;
					$this->Session->setFlash('Mensagens enviadas com sucesso!');
				}
			//}

			// Close the connection to the server
			fclose($fp);
		}

		
		
		/// NÃO TEM ENVIO PARA ANDROID
		//$this->admin_enviarpushandroid($message, $setores, $todos);


		$this->Session->setFlash('Mensagens enviadas com sucesso!');
		$this->redirect(array('action' => 'criarpush', 'admin' => true));


	}


	function admin_enviarpushautomatizado($message, $setores) {
		$this->autoRender = false;
		$model = 'Token';

		//print_r($this->request->data);
		//die();

		////////////////////////////////////////////////////////////////////////////////
		// Put your alert message here:
		$message_backup = 'Existem novas atualizações!';

		//$message = $this->request->data['Pushfrase']['frase'];
		//$setores = $this->request->data['Pushfrase']['setores'];

		if (empty($setores)) {
			$this->Session->setFlash('Favor informar o(s) setor(es).');
			$this->redirect(array('action' => 'criarpush'));
		}
		//print_r($message);
		//die();

		if (empty($message)) {
			$message = $message_backup;
		}

		// Put your private key's passphrase here:

		// Put your private key's passphrase here:
		$tipoProducao = true;
		$passphrase;
		$url_ssl;
		$pem;
		if ($tipoProducao) {
			$passphrase 	= 'zpass2010';
			$url_ssl 		= 'ssl://gateway.push.apple.com:2195';
			$pem 			= 'ck_prod.pem';
		} else {
			$passphrase 	= 'zoio2010';
			$url_ssl 		= 'ssl://gateway.sandbox.push.apple.com:2195';
			$pem 			= 'ck.pem';
		}
		////////////////////////////////////////////////////////////////////////////////


		//GRAVA A FRASE ESCRITA
		$this->Pushfrase->create();
		$this->Pushfrase->set('frase', $message);
		$this->Pushfrase->save();

		//print_r($setores['Setor']);
		//die();
		/*
		$registros = $this->$model->find('all', array(
													'fields' => array(
														'token',
													),
													'conditions' => array(
														'setor_id' => $setores['Setor']
													)
												));
		*/										
		
		$setores_str = '';
		foreach ($setores['Setor'] as $setor):
			$setores_str .= $setor .',';
		endforeach;
		$setores_final = rtrim($setores_str, ',');
		
		$registros = $this->$model->query('
										Select 
											Token.token
										From
											tb_tokens as Token
										
										where 
											Token.usuario_id in (
															SELECT
																US.user_id
															FROM
																usuarios_setores as US
															WHERE
																setor_id in ('. $setores_final .')
														)
										');

		//print_r($registros);
		//die();


		foreach ($registros as $registro) {
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'pem/'.$pem);
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

			// Open a connection to the APNS server
			$fp = stream_socket_client(
				$url_ssl, $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

			if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);

			//echo 'Connected to APNS' . PHP_EOL;

			// Create the payload body
			$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default'
				);

			// Encode the payload as JSON
			$payload = json_encode($body);


			//foreach ($registros as $registro) {
				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $registro[$model]['token']) . pack('n', strlen($payload)) . $payload;

				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));

				if (!$result) {
					echo '<br>'. $registro[$model]['token'] .': Message not delivered' . PHP_EOL;
				} else {
					echo '<br>'. $registro[$model]['token'] .': Message successfully delivered' . PHP_EOL;
				}
			//}

			// Close the connection to the server
			fclose($fp);
		}
		
		
		
		echo '<hr>';
		//$this->admin_enviarpushandroid($message, $setores['Setor']);
		//echo '<hr>';
		
		
		//$this->redirect(array('controller' => 'conteudos', 'action' => 'index', 'admin' => true));
	}


	function admin_enviarpushprod($message = null) {
		$this->autoRender = false;
		$model = 'Token';

		//print_r($this->request->data);
		//die();

		////////////////////////////////////////////////////////////////////////////////
		// Put your alert message here:
		$message_backup = 'Existem novas atualizações!';

		$message = $this->request->data['Pushfrase']['frase'];
		$setores = $this->request->data['Pushfrase']['setores'];

		if (empty($setores)) {
			$this->Session->setFlash('Favor informar o(s) setore(s).');
			$this->redirect(array('action' => 'criarpush'));
		}
		//print_r($message);
		//die();

		if (empty($message)) {
			$message = $message_backup;
		}

		// Put your private key's passphrase here:
		$tipoProducao = false;
		$passphrase;
		$url_ssl;
		$pem;
		if ($tipoProducao) {
			$passphrase 	= 'AppleFoda!!!';
			$url_ssl 		= 'ssl://gateway.push.apple.com:2195';
			$pem 			= 'ck_prod.pem';
		} else {
			$passphrase 	= 'zoio2010';
			$url_ssl 		= 'ssl://gateway.sandbox.push.apple.com:2195';
			$pem 			= 'ck.pem';
		}
		////////////////////////////////////////////////////////////////////////////////


		//GRAVA A FRASE ESCRITA
		$this->Pushfrase->create();
		$this->Pushfrase->set('frase', $message);
		$this->Pushfrase->save();

		/*
		$db = $this->$model->getDataSource();
		$db->fullDebug = true;
		*/

		$registros = $this->$model->find('all', array(
													'fields' => array(
														'token',
													),
													'conditions' => array(
														'setor_id' => $setores
													)
												));

		/*
		$log = $db->getLog();
		$db->fullDebug = false;
		print_r($log);

		print_r($registros);
		die();
		*/

		foreach ($registros as $registro) {
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'pem/'.$pem);
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

			// Open a connection to the APNS server
			$fp = stream_socket_client(
				$url_ssl, $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

			if (!$fp)
				exit("Failed to connect: $err $errstr" . PHP_EOL);

			echo 'Connected to APNS' . PHP_EOL;

			// Create the payload body
			$body['aps'] = array(
				'alert' => $message,
				'sound' => 'default'
				);

			// Encode the payload as JSON
			$payload = json_encode($body);


			//foreach ($registros as $registro) {
				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $registro[$model]['token']) . pack('n', strlen($payload)) . $payload;

				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));

				if (!$result)
					echo '<br>'. $registro[$model]['token'] .': Message not delivered' . PHP_EOL;
				else
					echo '<br>'. $registro[$model]['token'] .': Message successfully delivered' . PHP_EOL;

			//}

			// Close the connection to the server
			fclose($fp);
		}


		//$this->Session->setFlash('Mensagens enviadas com sucesso!');
		//$this->redirect(array('action' => 'criarpush'));


	}
	
	
	

	function admin_enviarpushandroid($message, $setores, $todos = 0) {
		$model = 'Tokenandroid';
		//echo 'Chegou aqui<br>';
		
        ini_set('display_errors', 'Off');
        $this->autoRender = false ;
		//echo 'Chegou aqui 2<br>';
        
        //$this->response->type('json');
		//echo 'Chegou aqui 3<br>';

		$APPLICATION_ID = "eZuMvbBnbTapKkxy9Bjdjjcn5XmZDs2flivCVcpc";
		$REST_API_KEY = "qHsc6mEVo3lntxyBFOZDaCOCpcRPB6tlrZLatINh";
		
		$url = 'https://api.parse.com/1/push';
		
		//$message = 'Teste.';
		
		echo "message: ". $message ."<br><br>";
		/*
		$registros = $this->$model->find('all', array(
													'fields' => array(
														'token',
													),
													'conditions' => array(
														//'setor_id' => $setores['Setor']
														'setor_id' => $setores
													)
												));
		*/
		$registros = array();
		if ($todos == 1) {
			//die('aqui');
			$registros = $this->$model->find('all', array(
														'fields' => array(
															'token',
														)
													));
		} else {
			$registros = $this->$model->find('all', array(
														'fields' => array(
															'token',
														),
														'conditions' => array(
															'setor_id' => $setores
														)
													));
		}
		
		print_r($setores);	
		//print_r($todos);										
		//print_r($registros);
		//die();
		foreach($registros as $token) {
			$data = array(
				//'channel' => '',
			    //'type' => 'android',
			    //'expiry' => 1451606400,
			    //'UniqueId' => $token[$model]['token'],
			    
			    'where' => array(
					//'objectId' => $token[$model]['token'],
					'UniqueId' => $token[$model]['token'],
				),
				
			    'data' => array(
			        'alert' => $message,
			        'sound' => 'push.caf',
			    ),
			);
			
			$_data = json_encode($data);
			$headers = array(
			    'X-Parse-Application-Id: ' . $APPLICATION_ID,
			    'X-Parse-REST-API-Key: ' . $REST_API_KEY,
			    'Content-Type: application/json',
			    'Content-Length: ' . strlen($_data),
			);
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_exec($curl);
		}

	}
	

}
