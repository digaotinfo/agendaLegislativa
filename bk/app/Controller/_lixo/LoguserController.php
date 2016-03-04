<?php
class LoguserController extends AppController {
	public $name = 'Loguser';
	public $helpers = array('Html', 'Session', 'Form', 'Tinymce', 'Time');
	public $uses = array('User', 'Role', 'Setor', 'Loguser');

	var $paginate = array(
	                        'limit'  => 50,
	                        'order'  => array(
	                                        'Loguser.id' => 'DESC'
	                        ),

                        );
    //public function beforeFilter() {
    //    parent::beforeFilter();
    //    $this->Auth->allow('admin_add', 'admin_logout');
    //}

   

    public function admin_index() {
		$model = 'Loguser';
		
		//===-----> Apoio View 
		$this->set('model', $model);
		//==----------------------------------------
		$current_user = $this->Session->read('Auth.User');
		
		
		$conditions = array();
		if ($current_user['role_id'] != 1):
			$this->redirect(array('controller' => 'index', 'action' => 'index'));
		endif;
		
		$this->set(array('users' => $this->paginate($model)));

    }

}
