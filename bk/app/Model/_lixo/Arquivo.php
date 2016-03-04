<?php
class Arquivo extends AppModel {
	var $useTable = 'tb_galerias';

	// Informa��es que ser�o recuperadas no momento do upload do(s) arquivo(s)
	public $info_files = array(
								'arquivo' => array(
									'ext' 	=> array('gif', 'jpeg', 'png', 'jpg', 'pdf', 'docx', 'xlsx', 'pptx'),
									'dir' 	=> 'uploads/arquivos/'
								),
							);
	
	
	
	var $order = array("Arquivo.id" => "DESC");
        
        		public $type_files = array(
                                            'arquivo' => array(
                                                                'ext' 	=> array('pdf','gif','jpeg','jpg','png','doc','docx','xls', 'xlsx', 'zip', 'ppt'),
                                                                'dir' 	=> 'uploads/arquivos/',
                                                                'size'	=> array('w'=> 0, 'h' => 0, 'force' => false),
                                                                'th' 	=> array('width' => 0, 'height' => 0)
                                                                )
                                            );
	
                public $validate = array(
                                            'arquivom' => array(
                                            'required' => array(
                                            'rule' => array('notEmpty'),
                                            'message' => 'Favor colocar um arquivo'
                                                                )
                                                            )
                                                );
}