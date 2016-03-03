<?
class FluxogramasController extends AppController {
	public $name 	= 'Fluxogramas';
	public $helpers = array('Html', 'Session', 'Paginator', 'Time', 'Text');
	public $uses 	= array('Fluxograma', 'Pl', 'PlType');

	public $paginate = array(
		'limit' => 10,
	);


	function beforeFilter() {
		parent::beforeFilter();

	}

    public function admin_index($id=null){
        $model = 'Fluxograma';
        $this->set('model', $model);

        // die('pagina do fluxograma');
    }

    /*
    *
    * alimentar a tabela tb_fluxo_log_origem_pl com as proposições ja existentes.
    * o ponto de partida da proposição, é o momento em que a mesma foi criada e
    * como ja existem proposições criadas, precisamos coloca-las na tabela do Fluxograma.php
    */
    public function admin_cargaFluxograma(){
        // die('Este método deve ser usado apenas pegar o ponto de partida do fluxograma.');

        $this->autoRender = false;
        $model = 'Fluxograma';

        $plAll = $this->Pl->find('all', array(
            'fields' => array(
                'Pl.id',
                'Pl.tipo_id',
                'Pl.numero_da_pl',
                'Pl.ano',
                'Pl.created',
                'Pl.modified',
                'PlType.tipo'
            ),
            'order' => array('id' => 'DESC'),
            'recursive' => -2
        ));

        $plOrigem = '';
        foreach( $plAll as $pl ){
            if($pl['PlType']['tipo']){
                $plOrigem .= $pl['PlType']['tipo'].' ';
            }
            if($pl['Pl']['numero_da_pl']){
                $plOrigem .= $pl['Pl']['numero_da_pl'];
            }
            if($pl['Pl']['ano']){
                $plOrigem .= '/'.$pl['Pl']['ano'];
            }

            $a_fluxograma['Fluxograma'] = array(
                'pl_id'         => $pl['Pl']['id'],
                'pl_origem'     => $plOrigem,
                'tipo_id'       => $pl['Pl']['tipo_id'],
                'numero_da_pl'  => $pl['Pl']['numero_da_pl'],
                'ano'           => $pl['Pl']['ano'],
                'created'       => $pl['Pl']['created'],
                'modified'      => $pl['Pl']['created'],
            );

            $this->$model->create();
            $this->$model->save($a_fluxograma);
            $plOrigem = '';
        }
        die('Ok!');
    }
}
?>
