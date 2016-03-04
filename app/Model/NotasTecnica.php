<?
App::import('Plugin', 'MeioUpload');
class NotasTecnica extends AppModel{
	var $useTable = 'tb_notas_tecnicas';


    //>>> MEIO UPLOAD
	var $actsAs = array(
	   'MeioUpload.MeioUpload' => array(
		   'arquivo' => array(
			   'allowedMime' => array(
				   'application/pdf',
				   'application/msword',
				   'application/vnd.ms-powerpoint',
				   'application/vnd.ms-excel',
				   'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				   'application/rtf',
				   'application/zip',
                   'image/png'
			    ),
			    'allowedExt' => array(
				   	'.pdf',
				    '.doc',
				    '.docx',
					'.ppt',
					'.xls',
					'.xlsx',
					'.rtf',
					'.zip',
                    '.png'
				),
                'dir' => 'uploads/notas_tecnicas',
                'create_directory' => true,
            )
	   )
	);

    function invalidate($field, $value = true){
        print_r($value);
        parent::invalidate($field, __d('meio_upload', $value, true));
    }
	//<<< MEIO UPLOAD


    public $belongsTo = array(
        'Pl' => array(
            'className' => 'Pl',
            'foreignKey'=> 'pl_id',
            'dependent' => true,
			'fields'	=> array('id', 'numero_da_pl', 'ano', 'tipo_id'),
        ),
    );

}
