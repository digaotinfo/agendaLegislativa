<?
App::import('Plugin', 'MeioUpload');
class Arquivo extends AppModel{
	var $useTable = 'tb_arquivos';


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



            )
	   )
	);


    // public $defaultValidations = array(
    //     'arquivo' => array(
    //         'FieldName' => array(
    //             'rule' => array('teste')
    //         )
    // ));
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
