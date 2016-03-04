<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller', 'CakeEmail', 'Network/Email');
App::uses('CakeEmail', 'Network/Email');
// App::import('Vendor', 'receiveMail/receiveMail');
// App::uses('CakeEmail', 'Network/Email');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $uses = array('Configuracao', 'Aplicativo', 'Loguser', 'AtualizacaoExternaPl', 'Pl', 'PlType', 'User');

	public $components = array(
        'Session',
		'AjaxMultiUpload.Upload',
		'ImageUploader',
		'RequestHandler',
        'Cookie',
        'P28n',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'index', 'action' => 'index', 'admin' => true),
            'logoutRedirect' => array('controller' => 'index', 'action' => 'index', 'admin' => true),


            //,'logoutRedirect' => array('controller' => 'index', 'action' => 'xml')
        )
    );

	function beforeFilter(){

		$this->Auth->authError = " ";
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
		$this->set('meses', $meses);
		$this->set('dia_semana', $dia_semana);

		///===> ADMIN
        if(!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$this->Auth->deny('*');


			//echo '['. $this->action .']';

			if ($this->name == 'User') {
				if ($this->action == 'admin_login') {
					$this->layout = 'login';
				} else {
					$this->layout = 'admin';
				}

			} else {
				$this->layout = 'admin';
			}


			if ($this->Session->read('Auth.User')):
				$usuario = $this->Session->read('Auth.User');

				$this->set('userAdmin', $this->Auth->user('role_id'));
				$this->set('current_user', $usuario);


				$this->salvarLogUsuarioLogado($usuario["id"]);

			endif;





		///===> FRONT-END
        } else {
			// $this->Auth->deny('*');
			$this->Auth->allow('*');


			///==> Liberar em caso de múltiplos idiomas
			/*
			$lang = $this->Cookie->read('lang');
			$this->set('lang', $lang);
			*/


        }

		// die($this->action);

		// if ($this->action != "admin_offline") {
		// 	$this->redirect(array(
		// 		"controller" => "user",
		// 		"action" => "offline",
		// 		"admin" => true,
		// 	));
		// }



	}


	public function salvarLogUsuarioLogado($usuario_id) {

		// $teste = $this->Loguser->find('all');
		// print_r($teste);
		// die();


		// $this->Loguser->set(array(
		// 		"usuario_id" => $usuario_id,
		// 		"url" => Router::url( $this->here, true ),
		// ));
		$this->Loguser->create();
		$this->Loguser->save(array(
				"usuario_id" => $usuario_id,
				"url" => $this->here,
				// "url" => Router::url( $this->here, true ),
		));

	}

	public function configuracoesGerais($fields = null) {
		$parametros = array();
		if ($fields != null):
			$parametros = array(
				'fields' => $fields,
			);
		endif;
		$registro = $this->set('configuracoes', $this->Configuracao->find('first', $parametros));

		return $registro;
	}


	public function sendMail($assunto, $mensagem, $email_para = null) {

		$dados_envio = $this->configuracoesGerais(array(
													'email_destinatario',
													'email_remetente_host',
													'email_remetente',
													'email_remetente_senha',
												));

		//DADOS SMTP
		if (!empty($dados_envio)):
			$smtp 		= $dados_envio['Configuracao']['email_remetente_host'];
			$usuario 	= $dados_envio['Configuracao']['email_remetente'];
			$senha 		= $dados_envio['Configuracao']['email_remetente_senha'];
			if ($email_para == null):
				$email_para = $dados_envio['Configuracao']['email_destinatario'];
			endif;

		else:
			$smtp 		= "smtp.zoio.net.br";
			$usuario 	= "tester@zoio.net.br";
			$senha 		= "zoio2010";
			if ($email_para == null):
				$email_para = 'zoiodev@zoio.net.br';
			endif;
		endif;

		$email_de = $usuario;




		require_once './smtp/smtp.php';

		$mail = new SMTP;
		$mail->Delivery('relay');
		$mail->Relay($smtp, $usuario, $senha, 587, 'login', false);
		//$mail->addheader('content-type', 'text/html; charset=utf-8');
		//$mail->addheader('content-type', 'text/html; charset=iso-8859-1');
		$mail->TimeOut(10);
		$mail->Priority('normal');
		$mail->From($email_de);
		$mail->AddTo($email_para);
		//$mail->AddBcc('zoiodev@zoio.net.br');
		$mail->Html($mensagem);

		if($mail->Send($assunto)){
			//echo '_SMTP+_Enviou para g......@zoio.net.br';
			return true;

		} else {
			//echo '_SMTP+_Não enviou e-mail';
			return false;

		}
	}



	public function resizeImage($dir, $toResize, $maxW=750, $maxH=540, $force=false) {
		$imagemToResize = $dir.$toResize;
		$ext = ".".end(explode(".", $toResize));
		$error = '';

		if(!$maxH && !$maxW) {
			return true;
		}

		$largura_alvo = $maxW;
		$altura_alvo  = $maxH;

		if($maxW <= $largura_alvo && $maxH <= $altura_alvo && $force=false) {
			return true;
		}

		$file_dimensions = getimagesize($dir.$toResize);
		$fileType = strtolower($file_dimensions['mime']);

		if($fileType=='image/jpeg' || $fileType=='image/jpg' || $fileType=='image/pjpeg') {
			$img = imagecreatefromjpeg($imagemToResize);
		} else if($fileType=='image/png') {
			$img = imagecreatefrompng($imagemToResize);
		} else if($fileType=='image/gif') {
			$img = imagecreatefromgif($imagemToResize);
		}

	   $largura_original = imagesX($img);
	   $altura_original = imagesY($img);

	   $altura_nova = ($altura_original * $largura_alvo)/$largura_original;

	   if($altura_nova>$altura_alvo)
	   {
	      $altura_nova = $altura_alvo;
	      $largura_nova = round(($largura_original * $altura_alvo)/$altura_original);
	      $nova = ImageCreateTrueColor($largura_nova,$altura_alvo);

		  if($fileType=='image/png' || $fileType=='image/gif') {
			  imagealphablending($nova, false);
			  imagesavealpha($nova,true);
			  $transparent = imagecolorallocatealpha($nova, 255, 255, 255, 127);
			  imagefilledrectangle($nova, 0, 0, $largura_nova, $altura_nova, $transparent);
		  }

	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura_nova, $altura_nova, $largura_original,  $altura_original);
	   }
	   else
	   {
	      $largura_nova = $largura_alvo;
	      $nova = ImageCreateTrueColor($largura_alvo,$altura_nova);

		  if($fileType=='image/png' || $fileType=='image/gif') {
			  imagealphablending($nova, false);
			  imagesavealpha($nova,true);
			  $transparent = imagecolorallocatealpha($nova, 255, 255, 255, 127);
			  imagefilledrectangle($nova, 0, 0, $largura_alvo, $altura_nova, $transparent);
		  }

	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura_alvo, $altura_nova, $largura_original,  $altura_original);
	   }

	   if($force) {
	      $nova = ImageCreateTrueColor($maxW,$maxH);
	      imagecopyresampled($nova, $img, 0, 0, 0, 0, $maxW, $maxH, $largura_original,  $altura_original);
	   }

		if($fileType=='image/jpeg' || $fileType=='image/jpg' || $fileType=='image/pjpeg') {
			if(!imagejpeg($nova, $imagemToResize,100)) $error = true;
		} else if($fileType=='image/png') {
			if(!imagepng($nova, $imagemToResize,0)) $error = true;
		} else if($fileType=='image/gif') {
			if(!imagegif($nova, $imagemToResize)) $error = true;
		}

		if($error) {
			return 'Erro ao redimencionar '.$toResize;
		} else {
			return true;
		}

	}

	public function subirImagem($model = '', $campo = '', $coluna = '', $acao = '', $id = '') {
		$nome_imagem = $this->uploadFile(
										$this->$model->info_files[$coluna]['dir'],
										$this->request->data[$model][$campo],
										$this->$model->info_files[$coluna]['ext'],
										$this->$model->info_files[$coluna]['size'],
										false,
										"",
										false,
										array('action' => $acao, 'id' => $id),
										true,
										$this->$model->info_files[$coluna]['th']
									);

		return $nome_imagem['1'];
	}



	/**
	*
	*       uploadFile()
	*       Alexandre MBroetto - 03-10-2011
	*
	*       $dir   -> Diretório de Destino do arquivo
	*       $file  -> Arquivo
	*       $ext   -> Extensões permitidas para esse arquivo. (Array)
	*       $force -> Se TRUE, força a existência de um arquivo.
	*       $resize-> Chama a funcao resizeImage() se passado como array
	*       $fileName -> Se TRUE, impõe um novo nome ao arquivo.
	*       $toLower -> Se TRUE, força o nome do arquivo a ser minusculo.
	*
	*/
	public function uploadFile($dir, $file, $ext="", $resize=false, $force=false, $fileName="", $createDir = false, $action='', $toLower=true, $createThumb=false) {
	   $extValid = true;
	   $error = false;
	   $errorLine = '';
	   $thumbName = '';
	   $thumbDir = '';

		// die('aaa'.$force);
		//die($file['name']);

		if(!is_dir($dir)) {
			if($createDir) {
				mkdir($dir);
			} else {
				$error = true;
				$errorLine = 'Diretorio nao encontrado!';
			}
		} else {
			if($file['name']=='' && !$force) {
				return array(true, '');
			}
		}
		if(!is_dir($dir) && !$force) {die('Diretório não encontrado');}

		/*if(!is_dir($dir) && $createDir) {
			mkdir($dir);
		} else if(!is_dir($dir) && !$createDir){
			$error = true;
			$errorLine = 'Diretorio nao encontrado!';
		}*/

		/*print_r($file);
		$is_uploaded = is_uploaded_file($file['tmp_name']);
		$success = move_uploaded_file($file['tmp_name'], $dir);

		echo $is_uploaded;

		if($success) {
			return 'upload';
		} else {
			return 'bosta';
		}*/

	   //if($file['size'] <= 5000000) {
	      if($toLower)
	         $fileExt = strToLower(end(explode(".", $file['name'])));
	      else
	         $fileExt = end(explode(".", $file['name']));

	      if($ext) $extValid = in_array($fileExt, $ext);

			if($file['name'] && $extValid) {

	         $fileTemp = $file['tmp_name'];

	         if($fileName) {
	            $filename = $fileName;
	         } else {
	            if($toLower) $filename = strToLower($file['name']);
	            else         $filename = $file['name'];
	         }

			 if(file_exists($dir.$filename)) {
				$fileNameExt = explode('.', $filename);
				$fileExtension = end(explode('.', $filename));
				$newFileName = '';

				for($x=0; $x<count($fileNameExt)-1; $x++) {
					$newFileName .= $fileNameExt[$x].'.';
				}

				$newFileName = subStr($newFileName, 0, -1);

				$filename = $newFileName.'_'.date('dmyHis').'.'.$fileExtension;
			}

			$filename = str_Replace(' ','_',$filename);

			if(!is_uploaded_file($fileTemp)) {
	            $error = true;
	            $errorLine .= "001 Erro ao efetuar upload do arquivo: ".$file["name"]."\n";
	         } else {
	            if(!move_uploaded_file($fileTemp, $dir.$filename)) {
					$error=false;
					$errorLine .= "002 Erro ao efetuar upload do arquivo: {$file[name]}";
				} else {

					if($createThumb) {

						$thumbDir = $dir.'thumbs/';
						$thumbName = 'th_'.$filename;

						if(!is_dir($thumbDir)) {
							mkdir($thumbDir);
						}


						if(!copy($dir.$filename, $thumbDir.$thumbName)) {
							$error = false;
							$errorLine .= "003 Erro ao criar Thumb: {$filename}";
						} else {
							if($resize['w']!=0 && $resize['h']!=0) {
								$this->resizeImage($thumbDir, $thumbName, $createThumb['width'], $createThumb['height'], true);
							}
						}
					}



				}
	         }
	      } else if($force) {
	         $error = true;
	         $errorLine = "Arquivo para upload nao identificado.";
	      }

	 	if($ext && !$extValid && $file['name']!='') {
			$errorLine = 'Extensao de arquivo nao permitida.';
		}

		if($errorLine) {
			$return = array(false, $errorLine);
		} else {
			$return = array(true, $dir.$filename, $thumbDir.$thumbName);
		}

		if(!$error && isSet($resize)) {

			if($resize['w']!=0 && $resize['h']!=0) {
				$resizeImage = $this->resizeImage($dir, $filename, $resize['w'], $resize['h'], $resize['force']);
			}

			if (!empty($resizeImage)) {
				if($resizeImage!=1) echo $resizeImage;
			}
		}

	   return $return;
	}

	public function getZoioConfig() {
		$zoioConfig = file_get_contents('config/config.zoio');

		return $zoioConfig;
	}


	public function subirImagemComMedidas($model = '', $campo = '', $coluna = '', $acao = '', $id = '', $w = '', $h = '') {
		$this->$model->info_files[$coluna]['size']['w'] = $w;
		$this->$model->info_files[$coluna]['size']['h'] = $h;

		$nome_imagem = $this->uploadFile(
										$this->$model->info_files[$coluna]['dir'],
										$this->request->data[$model][$campo],
										$this->$model->info_files[$coluna]['ext'],
										$this->$model->info_files[$coluna]['size'],
										false,
										"",
										false,
										array('action' => $acao, 'id' => $id),
										true,
										$this->$model->info_files[$coluna]['th']
									);

		//return $this->$model->info_files[$coluna]['dir'].$this->request->data[$model][$campo]['name'];
		return $nome_imagem['1'];
	}

	function limpaTags($limpar) {

        if(is_array($limpar)) {
        	$str = '';

        	for($x=0; $x<count($limpar); $x++) {
        		$str .= ($limpar[$x]!='') ? $limpar[$x].' ' : '';
        	}

        	$str = strip_Tags(str_Replace(" ", ", ", subStr($str, 0, -1)));
        }

        return $str;

    }


    function stringToSlug($str) {

		$array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
				 , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );

		$array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
				 , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );

		$str = str_replace( $array1, $array2, $str );


		/*
		/// ERRO DE CARACTERES NESTA FUNÇÃO //////////////
		//////////////////////////////////////////////////
			$as = array("Ã¡", "Ã£", "Ã ", "Ã¢", "Ã¤","Ã", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($as, "a", $str);

			$es = array("Ã©", "Ãª", "Ã¨", "Ã«","Ã", "Ã", "Ã", "Ã");
			$str = str_replace($es, "e", $str);

			$is = array("Ã­", "Ã®", "Ã¬", "Ã¯", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($is, "i", $str);

			$os = array("Ã³", "Ã²", "Ã´", "Ã¶", "Ãµ", "Ã", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($os,"o", $str);

			$us = array("Ãº", "Ã»", "Ã¹", "Ã¼", "Ã", "Ã", "Ã", "Ã");
			$str = str_replace($us,"u", $str);

			$ns = array("Ã±", "Ã");
			$str = str_replace($ns, "n", $str);

			$cs = array("Ã§", "Ã");
			$str = str_replace($cs, "c", $str);
		*/

		$str = strtolower(trim($str));
		//$str = strtr($str, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_");
		$str = ereg_replace("[^a-zA-Z0-9_]", "-", $str);
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
    }



	function paginacao($curPage, $numeroDePaginas, $controller, $action = 'index', $addClass = 'paginacaoMargin') {
		$paginacao = "";

		$curPageStyle = 'color:#9ACA3C;border:0px solid #004b7f;';

		$paginacao = ($curPage==1) ? '' : '<a href="'.$this->webroot.$controller.'/'.$action.'" class="'.$addClass.'" rel="1" style="border:0;">Primeira</a>';

		if($numeroDePaginas>5) {
        	$pageMin = ($curPage<=2) ? 1 : ($curPage-2);
        	$pageMax = ($curPage+2);

        	if(($curPage+1) == $numeroDePaginas || $curPage == $numeroDePaginas) {
        		$pageMax = $numeroDePaginas;
        	}

        	for($x=$pageMin; $x<=$pageMax; $x++) {
				$style = '';

				if($x==$curPage) $style=$curPageStyle;

					$y = ($x==1) ? '' : $x;
					$paginacao .= '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$y.'" style="'.$style.'" class="'.$addClass.'" rel="'.$y.'">'.$x.'</a>';
        	}
		} else {
			for($x=1; $x<=$numeroDePaginas; $x++) {
				$style = '';

				if($x==$curPage) $style=$curPageStyle;

				$y = ($x==1) ? '' : $x;
				$paginacao .= '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$y.'" class="'.$addClass.'" style="'.$style.'" rel="'.$y.'">'.$x.'</a>';
			}
		}

		//$paginacao .= ($curPage!=$numeroDePaginas) ? '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$numeroDePaginas.'" class="'.$addClass.'" rel="'.$numeroDePaginas.'">Última</a>' : '';
		$paginacao .= ($curPage!=$numeroDePaginas) ? '<a href="'.$this->webroot.$controller.'/'.$action.'/'.$numeroDePaginas.'" class="'.$addClass.'" rel="'.$numeroDePaginas.'" style="border:0;">Última</a>' : '';

		if($numeroDePaginas==0) $paginacao = "";

		return $paginacao;
    }



	public function validaEmail($email) {
		$conta = "^[a-zA-Z0-9\._-]+@";
		$domino = "[a-zA-Z0-9\._-]+.";
		$extensao = "([a-zA-Z]{2,4})$";

		$pattern = $conta.$domino.$extensao;

		if (ereg($pattern, $email)):
			return true;
		else:
			return false;
		endif;
	}

	function nameImageWithPath($img_path = '') {
		$a_file = explode('/', $img_path);

		return end($a_file);
	}

	function thumbPath($img_path = '') {
		return str_replace($this->nameImageWithPath($img_path), '/thumbs/th_'. $this->nameImageWithPath($img_path), $img_path);

	}

	function apagarArquivo($file) {
		if (file_exists($file)) {
			unlink($file);
		}
	}




	public function transferFilesWithFTP($file, $dir) {
		//inicio conect ftp
		$ftp_server = "200.150.207.78";
		$ftp_user = "jelastic-ftp";
		$ftp_pass = "Jr2tOYdVAG";
		//
		// set up a connection or die
		$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");

		// try to login
		if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
			echo "Conectado a $ftp_user@$ftp_server\n <br />";
		} else {
			echo "Couldn't connect as $ftp_user\n";
		}
		//fim conect ftp

		// Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = 'app/webroot/uploads/img/teste/';
		$_UP['caminho_abstoluto'] = 'webroot/ROOT/app/webroot/'. $dir;
		$caminho_abstoluto = '/webroot/ROOT/app/webroot/'. $dir;

		// Tamanho máximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 10; // 10Mb

		// Array com as extensões permitidas
		$_UP['extensoes'] = array('jpg', 'png', 'gif', 'jpeg');

		// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
		$_UP['renomeia'] = false;

		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($file['error'] != 0) {
			die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$file['error']]);
			exit; // Para a execução do script
		}

		// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

		// Faz a verificação da extensão do arquivo
		$extensao = strtolower(end(explode('.', $file['name'])));
		if (array_search($extensao, $_UP['extensoes']) === false) {
			echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";

		// Faz a verificação do tamanho do arquivo
		} else if ($_UP['tamanho'] < $file['size']) {
			echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";

		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		} else {
			// Primeiro verifica se deve trocar o nome do arquivo
			if ($_UP['renomeia'] == true) {
				// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
				$nome_final = time().'.jpg';

			} else {
				// Mantém o nome original do arquivo
				$nome_final = $file['name'];
			}

			// Depois verifica se é possível mover o arquivo para a pasta escolhida

			/*
			if (move_uploaded_file($file['tmp_name'], $_UP['pasta'] . $nome_final)) {
				// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
				echo "Upload efetuado com sucesso!";
				echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar ou baixar o arquivo</a>';
				echo '<br />"Descrição do arquivo"';
				echo '<br />"Data de envio '. $data .'"';
				echo '<br />"Hora de envio '. $hora .'"';
				echo '<br />"Nome '. $nome_final .'"' ;
				echo '<br />"Tamanho '. $tamanho .'"';
				echo '<br />"Tipo '. $tipo .'"';


			} else {
				// Não foi possível fazer o upload, provavelmente a pasta está incorreta
				echo "Não foi possível enviar o arquivo ". $file['tmp_name'] ." [". $file['name'] ."], tente novamente.";

			}
			*/


		}

		ftp_pasv($conn_id, true);

		echo $caminho_abstoluto.$file['name'] .'<br><br>';

		//ftp_put( $conn_id, $caminho_abstoluto.$file['name'], $file['tmp_name'], FTP_ASCII );



		ftp_put( $conn_id, 'webroot/ROOT/app/webroot/uploads/img/teste/'.$file['name'], $file['tmp_name'], FTP_ASCII );
		//echo '<br><br><br>[<br>';


		echo '<br><br><br>[<br>';


		/// Listando as pastas do FTP
		//$buff = ftp_rawlist($conn_id, 'webroot/ROOT/app/webroot/uploads/img/galerias/', false);
		//var_dump($buff);

		echo '<br>]<br><br><br>';


		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$mensagem = $_POST['mensagem'];
		$local = $_UP['pasta'] . $nome_final;
		$tamanho = $_FILES['arquivo']['size'];
		$tipo = $_FILES['arquivo']['type'];
		$ip = $_SERVER['REMOTE_ADDR']. "\n";
		$data = date("d/m/y");
		$hora = date("H:i:s");
		$log = "Log de envio: $data | Horario: $hora | IP: $ip | Imagen: $nome_final | Tamanho: $tamanho Kbts | Tipo: $tipo | Local: $local | Descrição: $mensagem | Nome: $nome | Email: $email ";
		$fp = fopen("log.txt", "a");
		fputs ($fp, "$log");
		fclose($fp);


		// close the connection
		ftp_close($conn_id);

	}


	public function permissao($id=null){
		$meuId = $this->Session->read('Auth.User.id');
		if( ($this->Session->read('Auth.User.role_id') != 1) && ($this->Session->read('Auth.User.id') != $id) ){
			$this->Session->setFlash('Sem permissão.');
			$this->redirect(array('action' => 'edit', 'admin' => true, $meuId));
		}
	}


	/*
	*
	* Salvar log >>>
	*/
	public function admin_fluxoLog($a_dados=null){
		$model = 'LogAtualizacaoPl';
		$pl_id = 0;
		$tipo = 0;
		$etapa_id = 0;
		$etapa = "";
		$etapa_descricao = "";
		$etapa_ordem = 0;
		$etapa_delete = 0;
		$etapa_vinculada_pl = 0;
		$subetapa_id = "";
		$subetapa = "";
		$subetapa_descricao = "";
		$subetapa_ordem = 0;
		$subetapa_delete = 0;
		$subetapa_vinculada_pl = 0;
		$fluxogramaEtapaAdd = 0;
		$fluxogramaEtapaEdit = 0;
		$fluxogramaEtapaDelete = 0;
		$fluxogramaSubEtapaAdd = 0;
		$fluxogramaSubEtapaEdit = 0;
		$fluxogramaSubEtapaDelete = 0;
		$modelNome = "";
		$modelID = 0;
		$name_block = "";
		$txt = "";
		$arquivo = "";
		$enviado_por_email = 0;
		$autor = '';
		$relator = '';
		$status_name = '';
		$link_da_pl = '';
		$apensados_da_pl = '';
		$prioridade = 0;
		$tema_name = '';
		$status_type_id = '';

		// if( !empty($a_dados['status_type_id']) ){
		// 	$status_type_id = $a_dados['status_type_id'];
		// }
		//
		// if( !empty($a_dados['tema_name']) ){
		// 	$tema_name = $a_dados['tema_name'];
		// }
		//
		// if( !empty($a_dados['prioridade']) ){
		// 	$prioridade = $a_dados['prioridade'];
		// }
		//
		// if( !empty($a_dados['apensados_da_pl']) ){
		// 	$apensados_da_pl = $a_dados['apensados_da_pl'];
		// }
		//
		// if( !empty($a_dados['relator']) ){
		// 	$relator = $a_dados['relator'];
		// }
		//
		// if( !empty($a_dados['link_da_pl']) ){
		// 	$link_da_pl = $a_dados['link_da_pl'];
		// }
		//
		// if( !empty($a_dados['autor']) ){
		// 	$autor = $a_dados['autor'];
		// }
		if( !empty($a_dados['pl_id']) ){
			$pl_id = $a_dados['pl_id'];
		}

		if( !empty($a_dados['pl_type_id']) ){
			$tipo = $a_dados['pl_type_id'];
		}
		if( !empty($a_dados['pl_type_id']) ){
			$tipo = $a_dados['pl_type_id'];
		}

		if( !empty($a_dados['etapa_id']) ){
			$etapa_id = $a_dados['etapa_id'];
		}

		if( !empty($a_dados['nome_da_model']) ){
			$modelNome = $a_dados['nome_da_model'];
		}

		if( !empty($a_dados['model_id']) ){
			$modelID = $a_dados['model_id'];
		}

		if( !empty($a_dados['name_block']) ){
			$name_block = $a_dados['name_block'];
		}

		if( !empty($a_dados['txt']) ){
			$txt = $a_dados['txt'];
		}

		if( !empty($a_dados['arquivo']) ){
			$arquivo = $a_dados['arquivo'];
		}

		if( !empty($a_dados['etapa']) ){
			$etapa = $a_dados['etapa'];
		}

		if( !empty($a_dados['etapa_descricao']) ){
			$etapa_descricao = $a_dados['etapa_descricao'];
		}

		if( !empty($a_dados['etapa_ordem']) ){
			$etapa_ordem = $a_dados['etapa_ordem'];
		}

		if( !empty($a_dados['etapa_delete']) ){
			$etapa_delete = $a_dados['etapa_delete'];
		}

		if( !empty($a_dados['etapa_vinculada_pl']) ){
			$etapa_vinculada_pl = $a_dados['etapa_vinculada_pl'];
		}

		if( !empty($a_dados['subetapa_id']) ){
			$subetapa_id = $a_dados['subetapa_id'];
		}

		if( !empty($a_dados['subetapa']) ){
			$subetapa = $a_dados['subetapa'];
		}

		if( !empty($a_dados['subetapa_descricao']) ){
			$subetapa_descricao = $a_dados['subetapa_descricao'];
		}

		if( !empty($a_dados['subetapa_ordem']) ){
			$subetapa_ordem = $a_dados['subetapa_ordem'];
		}
		if( !empty($a_dados['subetapa_vinculada_pl']) ){
			$subetapa_vinculada_pl = $a_dados['subetapa_vinculada_pl'];
		}

		if( !empty($a_dados['subetapa_delete']) ){
			$subetapa_delete = $a_dados['subetapa_delete'];
		}

		if( !empty($a_dados['fluxo_etapa_add']) ){
			$fluxogramaEtapaAdd = $a_dados['fluxo_etapa_add'];
		}

		if( !empty($a_dados['fluxo_etapa_edit']) ){
			$fluxogramaEtapaEdit = $a_dados['fluxo_etapa_edit'];
		}

		if( !empty($a_dados['fluxo_etapa_delete']) ){
			$fluxogramaEtapaDelete = $a_dados['fluxo_etapa_delete'];
		}
		if( !empty($a_dados['fluxo_subetapa_add']) ){
			$fluxogramaSubEtapaAdd = $a_dados['fluxo_subetapa_add'];
		}

		if( !empty($a_dados['fluxo_subetapa_edit']) ){
			$fluxogramaSubEtapaEdit = $a_dados['fluxo_subetapa_edit'];
		}

		if( !empty($a_dados['fluxo_subetapa_delete']) ){
			$fluxogramaSubEtapaDelete = $a_dados['fluxo_subetapa_delete'];
		}

		// echo "<pre>";
		// print_r($a_dados);
		// echo "</pre>";
		// die();
		$this->request->data[$model]['usuario_id'] = $this->Session->read('Auth.User.id');
		$this->request->data[$model]['usuario_nome'] = $this->Session->read('Auth.User.name');
		$this->request->data[$model]['usuario_username'] = $this->Session->read('Auth.User.username');
		$this->request->data[$model]['pl_id'] = $pl_id;
		$this->request->data[$model]['model_id'] = 0;
		$this->request->data[$model]['tipo_id'] = $tipo;
		$this->request->data[$model]['nome_da_model'] = $modelNome;
		$this->request->data[$model]['model_id'] = $modelID;
		$this->request->data[$model]['fluxograma'] = 1;
		$this->request->data[$model]['etapa_id'] = $etapa_id;
		$this->request->data[$model]['etapa'] = $etapa;
		$this->request->data[$model]['etapa_descricao'] = $etapa_descricao;
		$this->request->data[$model]['etapa_ordem'] = $etapa_ordem;
		$this->request->data[$model]['etapa_delete'] = $etapa_delete;
		$this->request->data[$model]['etapa_vinculada_pl'] = $etapa_vinculada_pl;
		$this->request->data[$model]['subetapa_id'] = $subetapa_id;
		$this->request->data[$model]['subetapa'] = $subetapa;
		$this->request->data[$model]['subetapa_descricao'] = $subetapa_descricao;
		$this->request->data[$model]['subetapa_ordem'] = $subetapa_ordem;
		$this->request->data[$model]['subetapa_delete'] = $subetapa_delete;
		$this->request->data[$model]['subetapa_vinculada_pl'] = $subetapa_vinculada_pl;
		$this->request->data[$model]['fluxo_etapa_add'] = $fluxogramaEtapaAdd;
		$this->request->data[$model]['fluxo_etapa_edit'] = $fluxogramaEtapaEdit;
		$this->request->data[$model]['fluxo_etapa_delete'] = $fluxogramaEtapaDelete;
		$this->request->data[$model]['fluxo_subetapa_add'] = $fluxogramaSubEtapaAdd;
		$this->request->data[$model]['fluxo_subetapa_edit'] = $fluxogramaSubEtapaEdit;
		$this->request->data[$model]['fluxo_subetapa_delete'] = $fluxogramaSubEtapaDelete;
		$this->request->data[$model]['name_block'] = $name_block;
		$this->request->data[$model]['txt'] = $txt;
		// $this->request->data[$model]['autor'] = $autor;
		// $this->request->data[$model]['relator'] = $relator;
		// $this->request->data[$model]['link_da_pl'] = $link_da_pl;
		// $this->request->data[$model]['apensados_da_pl'] = $apensados_da_pl;
		// $this->request->data[$model]['prioridade'] = $prioridade;
		// $this->request->data[$model]['tema_name'] = $tema_name;
		// $this->request->data[$model]['status_type_id'] = $status_type_id;
		// echo "<pre>";
		// print_r($this->request->data['LogAtualizacaoPl']);
		// echo '###############';
		// echo "</pre>";
		// die();
		// $this->$model->save($this->request->data);

		$this->$model->create();
		$this->$model->save($this->request->data);
	}

	public function admin_fluxogramaHistorico($request=null, $registro=null, $a=null){
		// echo "<pre>";
		// print_r($registro);
		// echo "</pre>";
		// die();
		$autor = '';
		$relator = '';
		$status_name = '';
		$link_da_pl = '';
		$apensados_da_pl = '';
		$prioridade = 0;
		$tema_name = '';
		$status_type_id = '';
		$pl_id = '';
		$pl_origem = '';
		$tipo_id = '';
		$numero_da_pl = '';
		$ano = '';
		$etapa_id = '';
		$subetapa_id = '';
		$autor = '';
		$relator = '';
		$status_name = '';
		$foco = '';
		$oQueE = '';
		$nossaPosicao = '';
		$justificativa = '';
		$situacao = "";
		$tarefa = "";
		$notasTecnicas = "";
		$etapa = '';
		$subetapa = '';
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/// PREPARAR PRA SALVAR O HISTÓRICO DO FLUXOGRAMA
		$pl_id          = $registro['Pl']['id'];
		$pl_origem      = $registro['PlType']['tipo']. ' ' .$registro['Pl']['numero_da_pl']. '/' .$registro['Pl']['ano'];
		$tipo_id        = $request['Pl']['tipo_id'];
		$numero_da_pl   = $request['Pl']['numero_da_pl'];
		$ano            = $request['Pl']['ano'];
		$etapa_id       = $request['Pl']['etapa_id'];
		$subetapa_id    = $request['Pl']['subetapa_id'];
		$autor          = $request['Autor']['nome'];
		$relator        = $request['Relator']['nome'];
		$link_da_pl     = $request['Pl']['link_da_pl'];
		$apensados_da_pl= $request['Pl']['apensados_da_pl'];
		$prioridade     = $request['Pl']['prioridade'];
		$tema_name      = $request[0]['temaName'];
		$status_name    = $request[0]['status_type'];
		$etapa    		= $request[0]['etapa'];
		$subetapa    	= $request[0]['subetapa'];





		if( !empty($registro['Foco']) ){
			$foco           =   '[ID]'.$registro['Foco'][0]['id'].'[/ID]
								[titulo]'.$registro['Foco'][0]['txt'].'[/titulo]
								[texto] [/texto]
								[modified]' .$registro['Foco'][0]['modified'].'[/modified][arquivo] [/arquivo]
								[arquivo] [/arquivo]
								[entrega] [/entrega]
								[realizado] [/realizado]';

		}
		if( !empty($registro['OqueE']) ){
			$oQueE          =   '[ID]'.$registro['OqueE'][0]['id'].'[/ID]
								[titulo]'.$registro['OqueE'][0]['txt'].'[/titulo]
								[modified]' .$registro['OqueE'][0]['modified'].'[/modified]
								[arquivo] [/arquivo]
								[entrega] [/entrega]
								[realizado] [/realizado]';
		}
		if( !empty($registro['NossaPosicao']) ){
			$nossaPosicao   =   '[ID]'.$registro['NossaPosicao'][0]['id'].'[/ID]
								[titulo]'.$registro['NossaPosicao'][0]['txt'].'[/titulo]
								[modified]' .$registro['NossaPosicao'][0]['modified'].'[/modified]
								[arquivo] [/arquivo]
								[entrega] [/entrega]
								[realizado] [/realizado]';
		}

		if( !empty($registro['Justificativa']) ){
			$justificativa  = $registro['Justificativa'][0]['justificativa'];
		}



		///////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////
		/// LOOP
		foreach( $registro['Situacao'] as $elemento ){
			$situacao = $situacao.'[ID]'.$elemento['id'].'[/ID]
						[titulo][/titulo]
						[texto] '.$elemento['txt'].' [/texto]
						[arquivo]'.Router::url('/'.$elemento['dir'].'/'.$elemento['arquivo'], true).'[/arquivo]
						[entrega] [/entrega]
						[realizado] [/realizado]
						[modified]' .$elemento['modified'].'[/modified]';
		}
		foreach( $registro['Tarefa'] as $elemento ){
			$realizado = 'Não';
			if($elemento['realizado'] == 1){
				$realizado = 'SIM';
			}
			$tarefa =   $tarefa.'[ID]'.$elemento['id'].'[/ID]
						[titulo]'.$elemento['titulo'].'[/titulo]
						[texto]'.$elemento['descricao'].'[/texto]
						[arquivo] [/arquivo]
						[entrega]'.$elemento['entrega'].'[/entrega]
						[realizado]'.$realizado.'[/realizado]
						[modified] [/modified]';
		}
		foreach( $registro['NotasTecnica'] as $elemento ){
			$notasTecnicas = $notasTecnicas.'[ID]' .$elemento['id']. '[/ID]
							[titulo]'.$elemento['nome'].'[/titulo]
							[texto]'.Router::url('/'.$elemento['dir'].'/'.$elemento['arquivo'], true).'[/texto]
							[arquivo] [/arquivo]
							[entrega] [/entrega]
							[realizado] [/realizado]
							[modified] [/modified]';
		}
		/// LOOP
		///////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////


		// $this->Fluxograma->create();
		$a_save = array(
			'pl_id'         => $pl_id,
			'pl_origem'     => $pl_origem,
			'tipo_id'       => $tipo_id,
			'numero_da_pl'  => $numero_da_pl,
			'ano'           => $ano,
			'etapa_id'      => $etapa_id,
			'subetapa_id'   => $subetapa_id,
			'autor'         => $subetapa_id,
			'relator'       => $subetapa_id,
			'status_name'   => $subetapa_id,
			'foco'          => $foco,
			'oque_e'        => $oQueE,
			'nossa_posicao' => $nossaPosicao,
			'justificativa' => $justificativa,
			'situacao'      => $situacao,
			'tarefa'        => $tarefa,
			'nostas_tecnicas'=> $notasTecnicas,
			'autor' 		=> $autor,
			'relator' 		=> $relator,
			'link_da_pl' 	=> $link_da_pl,
			'apensados_da_pl' => $apensados_da_pl,
			'prioridade' 	=> $prioridade,
			'tema_name' 	=> $tema_name,
			'status_type' => $status_name,
			'etapa' 		=> $etapa,
			'subetapa' 		=> $subetapa,
		);

		// echo "<pre>";
		// print_r($request);
		// echo "</pre>";
		// die();
		$this->Fluxograma->create();
		$this->Fluxograma->save($a_save);
		/// PREPARAR PRA SALVAR O HISTÓRICO DO FLUXOGRAMA
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	}

	public function trataRegsitroLogTexto($dado){
		/*
		*
		* receber dados neste formato
		* $dado = "[titulo]Titulo da Situação[/titulo] [texto]texto fora[/texto] [titulo]Titulo da Situação2[/titulo] [texto]texto fora2[/texto]";
		*/
		$string 	= $dado;
		$id			= '';
		$tituloInicio = '';
		$restante   = '';
		$titulo 	= '';
		$texto 		= '';
		$arquivo 	= '';
		$entrega 	= '';
		$realizado 	= '';
		$modified 	= '';
        $IDInicio 	= explode('[ID]', $string);
		$a_registros = array();

		foreach($IDInicio as $key => $tratando){
			if( !empty($IDInicio[$key]) ){
				$registroID	= explode('[/ID]', $IDInicio[$key]);
				$id = $registroID[0];
				if( !empty($registroID[1]) ){
					$restante = $registroID[1];
				}
				$tituloInicio = explode('[titulo]', $restante);
				if( !empty($tituloInicio[1]) ){
					$tituloFim = explode( '[/titulo]', $tituloInicio[1] );
					$titulo = $tituloFim[0];
				}

				$textoInicio = explode( '[texto]', $restante );
				if( !empty($textoInicio[1]) ){
					$textoFim = explode( '[/texto]', $textoInicio[1] );
					$texto = $textoFim[0];
				}
				// echo "<pre>";
				// print_r( $id	 );
				// echo "</pre>";

				$arquivoInicio 	= explode( '[arquivo]', $restante );
				if( !empty($arquivoInicio[1]) ){
					$arquivoFim = explode( '[/arquivo]', $arquivoInicio[1] );
					$arquivo = $arquivoFim[0];
				}

				$entregaInicio 	= explode( '[entrega]', $restante );
				if( !empty($entregaInicio[1]) ){
					$entregaFim = explode( '[/entrega]', $entregaInicio[1] );
					$entrega = $entregaFim[0];
				}

				$realizadoInicio 	= explode( '[realizado]', $restante );
				if( !empty($entregaInicio[1]) ){
					$realizadoFim = explode( '[/realizado]', $realizadoInicio[1] );
					$realizado = $realizadoFim[0];
				}


				$modifiedInicio 	= explode( '[modified]', $restante );
				if( !empty($modifiedInicio[1]) ){
					$modifiedFim = explode( '[/modified]', $modifiedInicio[1] );
					$modified = $modifiedFim[0];
				}

				array_push($a_registros, array(
						'id' 		=> $id,
						'titulo' 	=> $titulo,
						'texto' 	=> $texto,
						'arquivo' 	=> $arquivo,
						'entrega' 	=> $entrega,
						'realizado'	=> $realizado,
						'modified'	=> $modified,
				));
			}
		}

		// die();
		return $a_registros;
	}

	public function formatDateToSQL($date=null){
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
		$formatDateFinal = $date[2].'-'.$_texto_para_mes[$texto].'-'.$date[0]. ' ' .date('H:i:s');

		return $formatDateFinal;
	}

	public function formatSQLtoDate( $date=null ){
		$dateExplodeSeparaDataHora = explode(' ', $date);
		$dia = '';
		$mes = '';
		$dateExplodeData = '';
		if( !empty($dateExplodeSeparaDataHora[0]) ){
			$dateExplodeData = explode('-', $dateExplodeSeparaDataHora[0]);
			$dia = $dateExplodeData[2].'/'.$dateExplodeData[1].'/'.$dateExplodeData[0];
		}
		$dateExplodeHour = '';
		if( !empty($dateExplodeSeparaDataHora[1]) ){
			$dateExplodeHour = explode(':', $dateExplodeSeparaDataHora[1]);
			$mes = ' às '.$dateExplodeHour[0]. ':'. $dateExplodeHour[1];
		}
        $dateNew = $dia.$mes;

        return $dateNew;
	}

	public function receiveMail( $date=null ){
		$this->autoRender = false;

		$obj = new receiveMail("sistema@agendalegislativa.abear.com.br", "sistema@123", "sistema@agendalegislativa.abear.com.br", "email-ssl.com.br", "imap", "143",false);

        //Connect to the Mail Box
        $obj->connect();         //If connection fails give error message and exit

        // Get Total Number of Unread Email in mail box
        $tot = $obj->getTotalMails(); //Total Mails in Inbox Return integer value
        print_r($tot);
        echo " Total de e-mails:: {$tot} <br>";
        echo "<hr>";

        for($i = $tot; $i > 0; $i--) {
            $head = $obj->getHeaders($i);  // Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)

            	echo "Assunto: ".		$head['subject']	."<br>";
            	echo "Para: ".			$head['to']			."<br>";
            	echo "To Other: ".		$head['toOth']		."<br>";
            	echo "ToName Other: ".	$head['toNameOth']	."<br>";
            	echo "Remetente: ".		$head['from']		."<br>";
            	echo "FromName: ".		$head['fromName']	."<br>";
            	echo "<br><br>";
            	echo "<br>*******************************************************************************************<BR>";
            echo $obj->getBody($i);  // Get Body Of Mail number Return String Get Mail id in interger

            $str = $obj->GetAttach($i, "./"); // Get attached File from Mail Return name of file in comma separated string  args. (mailid, Path to store file)
            $ar = explode(",", $str);
            foreach($ar as $key => $value) {
            	echo ($value == "")?"":"Arquivo anexo :: ". $value ."<br>";
            }

            echo "<br>------------------------------------------------------------------------------------------<BR>";

            /*
            *
            * salvar email de atualização da pl >>>
            */

            $remetente 			= $head['from'];
            $assunto 			= $head['subject'];
            $corpo 				= $obj->getBody($i);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /*
            *
            * listar tipos e fazer o if para saber qual o tipo foi recebido por email
            */

			if( ($remetente == 'push.materias@senado.gov.br') || ($remetente == 'tramitacao@camara.gov.br') || ($remetente == 'digaot.info@gmail.com') || ($remetente == 'gabriel.rodrigues@zoio.net.br') ):
	            $a_save = array(
	                'remetente' 					=> $remetente,
	                'assunto'	 					=> $assunto,
	                'corpo' 						=> $corpo
	            );
	            $this->AtualizacaoExternaPl->create();
	            $this->AtualizacaoExternaPl->save( $a_save );



	            /*
	            *
	            * enviar email para os administradores sobre a atualizacao >>>
	            */
	            $lastAtualizacaoExternaPl = $this->AtualizacaoExternaPl->getLastInsertID();
	            $de = '';
	            if( $remetente == 'push.materias@senado.gov.br' ){
	                $de = 'Senado';
	            }else{
	                $de = 'Camara';
	            }
	            $tituloDoEmail = 'Atualização '.$de;
	            $aHref = Router::url('/admin/mostrar-atualizacao/'.$lastAtualizacaoExternaPl, true);

	            $users = $this->User->find('all', array(
	                'conditions' => array(
	                    'role_id' => 1
	                )
	            ));

	            $enviarEmail = array(
	                'id' 			=> $lastAtualizacaoExternaPl,
	                'de'			=> $remetente,
	                'titulo'		=> $tituloDoEmail,
	                'aHref'			=> $aHref,
	                'UsuariosEmail' => $users
	            );
	            $this->trataDadosEmail( $enviarEmail );

            /*
            *
            * <<< salvar email de atualização da pl
            */



            //$obj->deleteMails($i); // Delete Mail from Mail box
		endif;

        }
		for($i = $tot; $i > 0; $i--) {
			$movendo = $obj->moveToProcessedBox($i);
			echo "Processado? :". $movendo ."<br>";

			echo "<hr>";
		}
        $obj->close_mailbox();   //Close Mail Box

	}

	public function trataDadosEmail($a_dados=null){
		// $this->autoRender = false;

		$logoTop = 'http://abear.com.br/uploads/img/logo/header_logo-abear.png';
		$aHref = $a_dados['aHref'];
		$titulo = $a_dados['titulo'];
		$de = $a_dados['de'];
		$id = $a_dados['id'];

		foreach( $a_dados['UsuariosEmail'] as $dado ){
			$email = $dado['User']['email'];
			$nome  = $dado['User']['name'];

			if($this->validaEmail($email)){
				$nome = $dado['User']['name'];
				$msg = '
					<table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
						<tbody>
							<tr>
								<td align="left" width="130">
									<img src="'.$logoTop.'">
								</td>
								<td colspan="2">
									<table style="background-color: #ffd600 !important;" height="115" width="570">
										<tbody>
											<tr>
												<td align="center" style="font-size: 24px;text-transform: uppercase;font-weight: 500;color: #000;">
													<strong>agenda legislativa</strong>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>



					<table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
						<tbody>
							<tr>
								<td>
									<br>
									<br>
									<br>
									<br>
									<br>
									<table cellpadding="0" cellspacing="0" width="600" align="center">
										<tbody>
											<tr>
												<td height="100">
													<p style="font-size: 18px;color: #000;">
														Olá <strong>'.$nome.'.</strong>
													</p>
													<hr>
												</td>
											</tr>

											<tr>
												<td>
													<p>
														Houve uma atualização nas Proposições.
													</p>
												</td>
											</tr>
											<tr>
												<td align="center">
													<br>
													<p>
														<a href="'.$aHref.'" style="border-style: solid;border-width: 0px;cursor: pointer;font-weight: normal;line-height: normal;margin: 0 0 1.25rem;position: relative;text-decoration: none;text-align: center;display: inline-block;padding-top: 1rem;padding-right: 2rem;padding-bottom: 1.0625rem;padding-left: 2rem;font-size: 1.2rem;background-color: #2E7D32;border-color: #097b61;color: white;-moz-transition: background-color 300ms ease-out;transition: background-color 300ms ease-out;padding-top: 1.0625rem;padding-bottom: 1rem;-webkit-appearance: none;font-weight: normal !important;-moz-border-radius: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
															Acesse
														</a>
													</p>
												</td>
											</tr>
										</tbody>
									</table>

								</td>
							</tr>
						</tbody>
					</table>
				';



				$this->admin_sendEmail($email, $titulo, $msg);

			}


		}
	}

	public function send_email($email_to=null, $title=null, $msg=null) {
    	$this->autoRender = false;

        $Email = new CakeEmail();
		$Email->emailFormat('html');
		$Email->from(array('nao-responda@zoio.net.br' => 'Agenda Legislativa ABEAR'));
		$Email->to($email_to);
		$Email->subject($title);
		$Email->send($msg);
    }

	public function admin_sendEmail($email_to=null, $title=null, $msg=null) {
        $this->autoRender = false;
		//
        // $email_to = 'digaot.info@gmail.com';
        // $title = 'titulo';
        // $msg = 'mensagem';

        $Email = new CakeEmail();
            $Email->emailFormat('html');
            $Email->from(array('nao-responda@zoio.net.br' => 'Agenda Legislativa ABEAR'));
            $Email->to($email_to);
            $Email->subject($title);
            $Email->send($msg);
    }
}
