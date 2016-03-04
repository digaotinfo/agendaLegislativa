<?php
class Loguser extends AppModel {
	public $useTable = 'tb_log_usuario';

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
		),
	);
	
	
	
	public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
	    $recursive = -1;
	    //$group = $fields = array('a_party');
	    //return $this->find('all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive', 'group'));
	    $sql = "SELECT 
					Loguser.id
					, Loguser.created
					, User.username
					, Setor.setor
					, Role.title
				
				FROM 
					tb_log_usuario as Loguser
					left join usuarios as User on (Loguser.user_id = User.id)
					left join tb_setores as Setor on (User.setor_id = Setor.id)
					left join roles as Role on (User.role_id = Role.id)
				LIMIT " . (($page - 1) * $limit) . ', ' . $limit;
	    $results = $this->query($sql);
	    return $results;
	}
	
	/**
	 * Overridden paginateCount method
	 */
	   public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
	    $sql = "SELECT 
					Loguser.id
					, Loguser.created
					, User.username
					, Setor.setor
					, Role.title
				
				FROM 
					tb_log_usuario as Loguser
					left join usuarios as User on (Loguser.user_id = User.id)
					left join tb_setores as Setor on (User.setor_id = Setor.id)
					left join roles as Role on (User.role_id = Role.id)
				";
	    /*
	    if ($conditions['Blacklist.b_party'] <> null) {
	        $sql = $sql . ' WHERE Blacklist.b_party = \'' . $conditions['Blacklist.b_party'] . '\'';
	    } else if ($conditions['Blacklist.a_party'] <> null) {
	        $sql = $sql . ' WHERE Blacklist.a_party = \'' . $conditions['Blacklist.a_party'] . '\'';
	    }
	    */
	    $this->recursive = $recursive;
	    $results = $this->query($sql);
	    return count($results);
	}
	
}
