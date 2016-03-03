<?php

$imagem	= str_replace('uploads/', '', $_REQUEST['imagem']);

$a_file_path = explode('/', $imagem);
$nome_imagem = end($a_file_path);

$th		= str_replace($nome_imagem, '/thumbs/th_'.$nome_imagem, $imagem);

// print_r($a_file_path);
//echo " [". $imagem ."]";
// echo " [". $th ."]";

//$imagem = 'img/topicos/img_4760.jpg';

if (file_exists($imagem)) {
	unlink($imagem);
}
if (file_exists($th)) {
	unlink($th);
}

echo 'true';

?>