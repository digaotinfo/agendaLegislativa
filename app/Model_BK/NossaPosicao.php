<?
class NossaPosicao extends AppModel{
	var $useTable = 'tb_nossa_posicao';

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
			//tabela do relacionamento
			// 'joinTable'             => 'tb_pl_foco',
			'foreignKey'            => 'model_id',
			//chave de associação
			// 'associationForeignKey' => 'pl_id',
			'dependent' => true,
		),
	);

	//>>> UpLoad via Ajax
	// Informações que serão recuperadas no momento do upload do(s) arquivo(s)
	public $type_files = array(
                            'arquivoNossaPosicao' => array(
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
