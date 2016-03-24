<?php
		$requests = $_REQUEST;
		
		$model 		= $requests[0];
		$coluna		= $requests[1];
		$acao		= $requests[2];
		$campo 		= $_FILES[$coluna];;
		$dir		= str_replace('uploads/', '', $requests[3]);
		$filename 	= $dir . basename($campo['name']);
		$size		= explode('|', $requests[4]);
		$th			= explode('|', $requests[5]);
		$ext		= explode('|', $requests[6]);
		$id			= '';
		
		
		
		$nome_imagem = uploadFile(
							$dir, 
							$campo, 
							$ext, 
							$size, 
							$force=false, 
							$fileName="", 
							$createDir = true, 
							$action=array('action' => $acao, 'id' => $id), 
							$toLower=true, 
							$th
						);
		//print_r($nome_imagem);
		echo'uploads/' . $nome_imagem['1'];















////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function uploadFile($dir, $file, $ext="", $resize=false, $force=false, $fileName="", $createDir = true, $action='', $toLower=true, $createThumb=false) {
	   $extValid = true;
	   $error = false;
	   $errorLine = '';
	   $thumbName = '';
	   $thumbDir = '';

		//die('aaa'.$force);
		//die($file['name']);
		
		//if(!is_dir($dir) && !$force) {die('aaa');}
		
		//print_r($file);
		//die();
	         
		//echo '[dir: '. $dir .']';
		
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
	      if($toLower) {
			  	$file_explode = explode(".", $file['name']);
				$file_explode_end = end($file_explode);
				
			      /*
			      echo '<br><br>+++|';
			      print_r($file_explode);
			      echo '|+++';
			      
			      echo '<br><br>+++|';
			      print_r($file_explode_end);
			      echo '|+++';
			      */
			  	
	         	$fileExt = strtolower($file_explode_end);
	         	
	         		
			      // echo '<br><br>+++|';
			      // print_r($fileExt);
			      // echo '|+++';
			    
	      
		  }else{
	         $fileExt = end(explode(".", $file['name']));
		  }

	      if($ext) $extValid = in_array($fileExt, $ext);
	
	
	      /*
		  echo '<br><br>+++|';
	      print_r($ext);
	      echo '|+++';
	      die();
	      */
	
	      
	      if($file['name'] && $extValid) {
			
	         $fileTemp = $file['tmp_name'];
			//echo $fileTemp .'|||';

	         if($fileName) {
	            $filename = $fileName;
	         } else {
	            if($toLower) $filename = strtolower($file['name']);
	            else         $filename = $file['name'];
	         }
	         
	
	         if(file_exists($dir.$filename)) {
	         	//echo 'AQUIiiii';
	         	
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

			//echo $fileTemp;

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
							//print_r($createThumb);
							
							//resizeImage($thumbDir, $thumbName, $createThumb['width'], $createThumb['height'], true);
							resizeImage($thumbDir, $thumbName, $createThumb[0], $createThumb[1], true);
						}
					}
					
					
					
				}
	         }
	      } else if($force) {
	         $error = true;
	         $errorLine = "Arquivo para upload nao identificado.";
	      }
	   //} else {
	   //   $error = false;
	   //   $errorLine = "Arquivo excede o tamanho máximo de 10MB";
	   //}
		
		
		if($ext && !$extValid && $file['name']!='') {
			$errorLine = 'Extensao de arquivo nao permitida.';
		}
		
		if($errorLine) {
			$return = array(false, $errorLine);
		} else {
			$return = array(true, $dir.$filename, $thumbDir.$thumbName);
		}

		//print_r($filename);
		//echo '____]';
		
		//echo 'error: '. $error;
		//echo '<br>resize: '. $resize;
		
		if(!$error && isSet($resize)) {
			//echo '<br>VEIO AQUI';
			//print_r($resize);
			
			//$resizeImage = resizeImage($dir, $filename, $resize['w'], $resize['h'], $resize['force']);
			$resizeImage = resizeImage($dir, $filename, $resize[0], $resize[1], false);
			
			if($resizeImage!=1) echo $resizeImage;
		}

	   return $return;
	}
	
	function resizeImage($dir, $toResize, $maxW=750, $maxH=540, $force=false) {
		$imagemToResize = $dir.$toResize;
		$ext_explode = explode(".", $toResize);
		$ext_explode_end = end($ext_explode);
		$ext = ".". $ext_explode_end;
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
		
		
		//echo 'PIPO: '. $fileType;
		
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
?>