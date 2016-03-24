<?
class NossaPosicao extends AppModel{
	var $useTable = 'tb_nossa_posicao';

    public $belongsTo = array(
		'Pl' => array(
			'className' => 'Pl',
			'foreignKey'=> 'pl_id',
			'dependent' => true,
			'fields'    => array('id', 'numero_da_pl', 'ano'),
		)
	);
	public $hasMany = array(
		'LogAtualizacaoPl' => array(
			'className'	=> 'LogAtualizacaoPl',
			'foreignKey'=> 'model_id',
			'dependent' => true,
			'fields'    => array('id'),
		),
	);

	//>>> UpLoad via Ajax
	// Informações que serão recuperadas no momento do upload do(s) arquivo(s)
	public $type_files = array(
                            'arquivo' => array(
                                                'ext' 	=> array(
                                                                'gif',
                                                                'jpeg',
                                                                'png',
                                                                'jpg',
																'xlsx',
																'zip',
                                                            ),
                                                'dir' 	=> 'uploads/nossa_posicao/',
                                                'size'	=> array('w'=> 0, 'h' => 0, 'force' => false),
                                                'th' 	=> array('width' => 0, 'height' => 0)
                                                )
                        );
	//<<< UpLoad via Ajax

	// //>>> MEIO UPLOAD
	// var $actsAs = array(
	//    'MeioUpload.MeioUpload' => array(
	// 	   'arquivo' => array(
	// 		   'allowedMime' => array(
	// 			   'application/pdf',
	// 			   'application/msword',
	// 			   'application/vnd.ms-powerpoint',
	// 			   'application/vnd.ms-excel',
	// 			   'application/rtf',
	// 			   'application/zip'
	// 		   ),
	// 		   'allowedExt' => array(
	// 			   	'.pdf',
	// 			    '.doc',
	// 				'.ppt',
	// 				'.xls',
	// 				'.xlsx',
	// 				'.rtf',
	// 				'.zip'
	// 			),
	// 		   'default' => false,
	// 	   )
	//    )
 //   	);
	// //<<< MEIO UPLOAD
}
