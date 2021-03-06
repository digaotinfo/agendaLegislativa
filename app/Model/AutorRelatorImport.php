<?
App::import('Plugin', 'MeioUpload');
class AutorRelatorImport extends AppModel{
	var $useTable = 'tb_autor_relator_import';


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
					'.ppt',
					'.xls',
					'.xlsx',
					'.rtf',
					'.zip',
                    '.png'
				),
				'dir' => 'uploads/import_nomes_autor_relator',
                'create_directory' => true,
            )
	   )
	);

    function invalidate($field, $value = true){
        print_r($value);
        parent::invalidate($field, __d('meio_upload', $value, true));
    }
	//<<< MEIO UPLOAD



    //>>> Upload.Upload
    // public $actsAs = array(
    //     'Upload.Upload' => array(
    //         'arquivo'
    //     ));
	// public $validate = array(
	//     'arquivo' => array(
	// 		'rule' => array('isValidExtension', array('pdf', 'txt')),
    //     	'message' => 'File does not have a pdf, png, or txt extension'
	//     )
	// );
    //<<< Upload.Upload
}
