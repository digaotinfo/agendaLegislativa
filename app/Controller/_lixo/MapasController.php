<?
class MapasController extends AppController{
	var $name = "Mapas";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $uses = array('Mapa', 'Empresa', 'ManifestacaoEmpresa', 'Cidade', 'Estado', 'Mapa', 'GaleriaManifestacao', 'Mapa');
	//var $scaffold = 'admin';
	//var $transformUrl = array('url_amigavel' => 'titulo_ptbr');
	var $paginate = array( 	
						'limit'  => 30,
						'order'  => array(
							'id' => 'DESC'
						),
						'contain' => array(
							'Empresa'
						),
		);
                              
	function beforeFilter() {
		parent::beforeFilter();
		
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
                                    'id'	 => 'ID',
                                    'cidade_id' => 'Cidade',
                                    'local'	 => 'Local',
                                    'total_manifestates' => 'Total de Manifestantes'
                                    	);
			$showImage	=	array(
								''
							);
			
			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);
			
			
			$this->set('schemaTable', $this->Mapa->schema());
			
			
		}
	}
	
	function admin_index(){
		$model = 'Mapa';
		$this->set('model', $model);
		$empresas = $this->Empresa->find('list', array(
														'fields' => array(
																		'id',
																		'empresa'
																			),
														'conditions' => array(
																		'ativo' => 1
																				)
																		));
		$this->set('empresas', $empresas);
		
		$estado = $this->Estado->find('list', array('fields' => array('uf')));
		$cidade = $this->Cidade->find('list', array('fields' => array('nome')));
		$this->set(array('cidades' => $cidade, 'estados' => $estado));

		
		///++++=====>>>> AREA DE BUSCA
		///====================================================================
		///====================================================================
		/// Variáveis alocadas:
		$array_conditions = array();
		
		///====================================================================
		/// ==> Find dos registros da categoria selecionada
		if (!empty($this->request->data['filtro']['Empresas'])) {
			$ids_empresas = '';
			foreach($this->request->data['filtro']['Empresas'] as $r){
				$ids_empresas = $ids_empresas.$r. ',';					
			}
			
			$sql_manifestacao_id = "SELECT DISTINCT Mapa.id
								FROM tb_manifestacao as Mapa
								INNER JOIN
								tb_manifestacao_empresa as ME ON (ME.manifestacao_id=Mapa.id)
								INNER JOIN
								tb_empresas as Empresa ON (ME.empresa_id=Empresa.id) WHERE Empresa.id IN (" .substr_replace($ids_empresas, '', -1, 1). ")";
					
			$mapas = $this->$model->query($sql_manifestacao_id);

			//////============>>>
			//Desmontar Array
			$manifestacoes_ids = Set::classicExtract($mapas, '{n}.Mapa.id');
			/////////////////
			
			array_push($array_conditions, array('Mapa.id' => $manifestacoes_ids));

		}
		
		/// ==> Find dos campo de busca
		if (!empty($this->request->data['filtro']['busca'])) {
			array_push($array_conditions, array(
											'OR' => array(
												'Mapa.local like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Mapa.ponto_partida like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Mapa.ponto_termino like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Mapa.horario like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Mapa.total_manifestantes like "%'. $this->request->data['filtro']['busca'] .'%" ',
												'Mapa.txt_impacto like "%'. $this->request->data['filtro']['busca'] .'%" ',
											),
										));
		}
		
		/// ==> Find dos campo de busca
		if (!empty($this->request->data['filtro']['estado_id'])) {
			array_push($array_conditions, array(
											'Mapa.estado_id' => $this->request->data['filtro']['estado_id'],
											'Mapa.cidade_id' => $this->request->data['filtro']['cidade_id'],
										));
		
		}
		
		
		/// Verifica se existe algo na busca
		if (!empty($array_conditions)) {
			//echo 'aqui'; 
			//print_r($array_conditions);
			$this->paginate['conditions'] = $array_conditions;
		}
		
		///====================================================================
		///====================================================================
		
		
		
        $this->set('manifestacoes', $this->paginate($model));
	}
	
	//ADD
	function admin_add(){
		$model = 'Mapa';

		$this->set('model', $model);
		
		$this->set('empresas', $this->Empresa->find('list', array(
														'fields' => array(
																		'id', 
																		'empresa'
																	), 
														'conditions' => array(
																		'ativo' => 1
																	)
													)
											));
											
		
		$estado = $this->Estado->find('list', array('fields' => array('uf')));
		$cidade = $this->Cidade->find('list', array('fields' => array('nome')));
		$this->set(array('cidades' => $cidade, 'estados' => $estado));
		
		if ($this->request->is('post')) {
			$this->$model->set($this->request->data);
			
			if ($this->$model->validates()) {

				//if(!empty($this->request->data[$model]['img_mapa_file']['name'])){
						///////////////////////////
						// realiza o upload
						$a_files = array('img_mapa_file');
						foreach ($a_files as $inputFile):
							if ($this->request->data[$model][$inputFile]['name'] != '') {
								$this->request->data[$model][$inputFile] = $this->subirImagem($model, $inputFile, $inputFile, 'add', '');
								$this->request->data[$model][str_replace('_file','', $inputFile).'_th_hidden'] = $this->thumbPath($this->request->data[$model][$inputFile]);					
							} else {
								$this->request->data[$model][$inputFile] = '';
							}
						endforeach;
						///////////////////////////
						//////////////////////////
			
					if ($this->$model->saveAll($this->request->data)){
						$this->redirect(array('controller' => 'mapas', 'action' => 'index', 'admin' => true));
					}
		        //}else{
			    //            
		        //}	
            }
        }
	}
	//END ADD	
	
	//EDIT
	function admin_edit($id=null){
	$model = 'Mapa';
		$this->set('model', $model);
		     
		
		////
		//Apoio Model
		//-------------------------->
		$this->set('empresas', $this->$model->Empresa->find('list', array(
																'fields' => array(
																				'id', 
																				'empresa'
																			), 
																'conditions' => array(
																				'ativo' => 1
																			)
															)
													));
	    $selecteds = $this->ManifestacaoEmpresa->find('list', array('fields' => array('empresa_id'), 
																	'conditions' => array('ManifestacaoEmpresa.manifestacao_id' => $id),
																		));																								
		$manifestacoes = $this->$model->find('first', array(
														'fields' => array(	'id',
																			'cidade_id',
																			'estado_id',
																			'local',
																			'ponto_partida',
																			'ponto_termino',
																			'horario',
																			'total_manifestantes',
																			'txt_impacto',
																			'url_materia',
																			'publicar',
																			'img_mapa_file',
																			'img_mapa_th_hidden'
																			),
														'conditions' => array($model.'.id' =>$id)
																	));
		
		$cidades = $this->Cidade->find('all', array(
													'fields' => array(
														'id',
														'estado_id',
														'nome',
													),
													'conditions' => array(
														'id' => $manifestacoes[$model]['cidade_id'],
														'estado_id' => $manifestacoes[$model]['estado_id'],

													),
													'recursive' => -1,
												)
										);
		$cidade_all = $this->Cidade->find('list', array(
														'fields' => array('nome'),
														'conditions' => array(
																				'estado_id' => $manifestacoes[$model]['estado_id'],
																					)
															));
		//print_r($cidade_all);
		$estados = $this->Estado->find('all', array(
													'fields' => array(
														'id',
														'uf',
													),
													'conditions' => array(
														'id' => $manifestacoes[$model]['estado_id'],
													),
													'recursive' => -1,
												)
										); 	
		$estado_all = $this->Estado->find('list', array('fields' => array('uf')));
	


		$this->set(array(	'selecteds' => $selecteds, 
							'manifestacoes' => $manifestacoes,
							'cidades' => $cidades,
							'cidade_all' => $cidade_all,
							'estados' => $estados,
							'estados_all' => $estado_all
							));
		
		//Apoio Model
		//<--------------------------------
		
        $this->$model->id = $id;

        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Registro inexistente'));
        }else{
	        if ($this->request->is('post') || $this->request->is('put')) {
				$this->$model->set($this->request->data);
					
				if ($this->$model->validates()) {
					///////////////////////////
					// realiza o upload
					$a_files = array('img_mapa_file');
					foreach ($a_files as $inputFile):
						if ($this->request->data[$model][$inputFile]['name'] != '') {
							$this->request->data[$model][$inputFile] = $this->subirImagem($model, $inputFile, $inputFile, 'edit', '');
							$this->request->data[$model][str_replace('_file','', $inputFile).'_th_hidden'] = $this->thumbPath($this->request->data[$model][$inputFile]);
						} else {
							$this->request->data[$model][$inputFile] = '';
						}
						
						/*
						// realiza o upload
						if ($this->request->data[$model][$inputFile.'_nova']['name'] != '') {
							$this->request->data[$model][$inputFile] = $this->subirImagem($model, $inputFile.'_nova', $inputFile, 'edit', $id);
						}
						// apaga imagem antiga, se houver
						if ($this->request->data[$model][$inputFile] == '' || $this->request->data[$model][$inputFile.'_nova']['name'] != '') {				
							$this->apagarArquivo($this->request->data[$model][$inputFile.'_apagar']);
							$this->apagarArquivo($this->thumbPath($this->request->data[$model][$inputFile.'_apagar']));
						}
						*/

					endforeach;
					///////////////////////////
					//////////////////////////

		            if ($this->$model->saveAll($this->request->data)){
		                $this->redirect(array('action' => 'index', 'admin' => true));
	                }

		        }
	        }
		}

}

	//END EDIT	
	
	//DELETE    
    function admin_delete($id){
    	$model = 'Mapa';
     
        if ($this->$model->delete($id)) {
        $this->redirect(array('action' => 'index'));
        }
     }
    //END DELETE
    
    //visualizar
    function admin_visualizar($id=null){
	    $model = 'Mapa';
	    
	    $this->set('model', $model);
	    
	    $manifestacao = $this->$model->find('first', array(
	    													'conditions' => array($model.'.id' => $id
	    																			)
	    													));
	    													
		$galerias = $this->GaleriaManifestacao->find('all', array(
														'conditions' => array(
																				'id' => $id
																				)
														));	    													
	    $this->set(array(
	    				'manifestacoes' => $manifestacao,
	    				'galeria' => $galerias
	    					));
	    
    	}
    //end admin_visualizar
    
    
    //CIDADES
    function admin_cidades($estado_id=null){
    	$this->autoRender = false;
    
    	$model = 'Cidade';
    	$this->set('model', $model);
    	
    	if($estado_id != ''){
	    	$cidades = $this->$model->find('all', array(
														'fields' => array(
															'id',
															'nome',
														),
														'conditions' => array(
															'estado_id' => $estado_id
														),
														'recursive' => -1,
													)
											);
			
			foreach($cidades as $cidade) {
				echo '<option value="'. $cidade[$model]['id'] .'"">'. $cidade[$model]['nome'] .'</option>';
			}
		}			
	}
    //END CIDADES
    
    //GALERIA
	function admin_galeria($id){
		$model = 'GaleriaManifestacao';
		$this->set('model', $model);
		$this->set('medidas_imagens', $this->$model->info_files);

		$manifestacao = $this->Mapa->find('first', array(
															'fields' => array(
																			'id'
																				),
															'conditions' => array(
																			'id' => $id
																					)
															));															

		$galeriaManifestacao = $this->$model->find('all', array(
													'fields' => array(
																'id',
																'manifestacao_id',
																'img_file',
																'legenda',
																		),
													'conditions' => array(
																			'manifestacao_id' => $id
																			),
														));
		$this->set(array('manifestacao' => $manifestacao, 'galeriaManifestacao' => $galeriaManifestacao));


		if($this->request->is('post')){

			/////////////
			$this->$model->set($this->request->data);
			/////////////
			if($this->$model->validates()){
				if(!empty($this->request->data[$model]['img_file']['name'])){
					///////////////////////////
					// realiza o upload
					$a_files = array('img_file');
					foreach ($a_files as $inputFile):
						if ($this->request->data[$model][$inputFile]['name'] != '') {
							$this->request->data[$model][$inputFile] = $this->subirImagem($model, $inputFile, $inputFile, 'add', '');
						} else {
							$this->request->data[$model][$inputFile] = '';
						}
					endforeach;
					///////////////////////////
					//////////////////////////


					if($this->$model->saveAll($this->request->data)){
						$this->redirect(array('controller' => 'mapas', 'action' => 'galeria', 'admin' => true, $id));
					}
				}else{
					echo "<script>alert('Selecione uma Imagem.')</script>";
				}
			}
		}


	}
	//END GALERIA
    
     //EDIT LEGENDA
    function admin_edit_legenda($id){
    	$model = 'GaleriaManifestacao';
    	$this->set('model', $model);

		$imagem = $this->$model->find('first', array(
													'fields' => array(
																'id',
																'img_file',
																'legenda',
																'manifestacao_id'
																	),
													'conditions' => array(
																		'id' => $id
																			)
														));
														
		$this->set(array(
							'imagem' => $imagem
							));

        $this->$model->id = $id;

	    if ($this->request->is($id)) {
        	$this->request->data = $this->$model->read();
        }else{
	        if($this->request->is('post')) {
				$this->$model->set($this->request->data);

				if ($this->$model->validates()) {
		            if ($this->$model->save($this->request->data[$model])){
		                $this->redirect(array('action' => 'galeria', 'admin' => true, $imagem[$model]['manifestacao_id']));
	                }
		        }
	        }
	    }
    }//END EDIT LEGENDA
    
    //GALERIA DELETE    
    function admin_galeriaDelete($id){
    	$model = 'GaleriaManifestacao';

        if ($this->$model->delete($id)) {   
        	 
        	$this->redirect(array('action' => 'visualizar'));
        }
    }
    /* END GALERIA DELETE */

}
	
