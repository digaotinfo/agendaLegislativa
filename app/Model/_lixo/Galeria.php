<?
class Galeria extends AppModel{
	var $useTable = 'tb_galeria';
	
	// Informações que serão recuperadas no momento do upload do(s) arquivo(s)
	public $info_files = array(
								'img_file' => array(
									'ext' 	=> array('gif', 'jpeg', 'png', 'jpg'),
									'dir' 	=> 'uploads/img/galerias/',
									'size'	=> array('w'=> 768, 'h' => 1024, 'force' => false),
									'th' 	=> array('width' => 100, 'height' => 100)
								),
							);

}