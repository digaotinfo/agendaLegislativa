<?
class Situacao extends AppModel{
	var $useTable = 'tb_situacao';

    public $belongsTo = array(
		'Pl' => array(
			'className'             => 'Pl',
			'foreignKey'            => 'pl_id',
			'dependent' => true,
		)
	);
	public $hasMany = array(
		'LogAtualizacaoPl' => array(
			'className'				=> 'LogAtualizacaoPl',
			'foreignKey'            => 'model_id',
			'dependent' => true,
			'limit'			=> 5,
			'order'			=> array('id' => 'DESC')
		),
	);

	//>>> UpLoad via Ajax
	// Informações que serão recuperadas no momento do upload do(s) arquivo(s)
	// public $type_files = array(
 //                            'arquivo' => array(
 //                                                'ext' 	=> array(
 //                                                                'gif',
 //                                                                'jpeg',
 //                                                                'png',
 //                                                                'jpg',
	// 															'xlsx',
	// 															'zip',
 //                                                            ),
 //                                                'dir' 	=> 'uploads/situacao/',
 //                                                'size'	=> array('w'=> 0, 'h' => 0, 'force' => false),
 //                                                'th' 	=> array('width' => 0, 'height' => 0)
 //                                                )
 //                        );
	//<<< UpLoad via Ajax

}
