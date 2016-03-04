<?
App::uses('CakeEmail', 'Network/Email');
class RelatoriosController extends AppController {
    var $name = "Relatorios";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $uses = array('Relatorio', 'PlType', 'PlSituacao', 'Pl', 'LogAtualizacaoPl', 'Foco', 'OqueE', 'Situacao', 'NossaPosicao', 'User', 'Tema', 'StatusType');
	var $scaffold = 'admin';
	// var $transformUrl = array('url_amigavel' => 'numero_da_pl');

	var $paginate = array(
	                        'limit'  => 10,
                            'order' => array(
                                'id' => 'DESC'
                            )
                        );

    //// Nescessário ter o beforeFilter
	function beforeFilter() {
		parent::beforeFilter();


		/// Descomentar verificação abaixo apenas quando utilizar Scaffold
		/*
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			$showThisFields	=	array(
                                    'campo'	  	=> 'Nome do Campo',
                                    ...
                                 );
			$showImage	=	array(
								''
							);

			$this->set('showFields', $showThisFields);
			$this->set('fieldToImg', $showImage);


			$this->set('schemaTable', $this->NomeDaModel->schema());
		}
		*/
	}



	/* LIST */
	public function admin_index(){
		$model = 'Relatorio';
        $this->set('model', $model);

        $tipos = $this->PlType->find('list', array(
            'fields' => array(
                'id',
                'tipo'
            ),
            'order' => array(
                'id' => 'DESC'
            )
        ));
        $this->set('tipos', $tipos);

        $temas = $this->Tema->find('list', array(
            'fields' => array(
                'id',
                'tema_name'
            ),
            'order' => array(
                'id' => 'DESC'
            )
        ));
        $this->set('temas', $temas);

        $status = $this->StatusType->find('list', array(
            'fields' => array(
                'id',
                'status_name'
            )
        ));
        $this->set('status', $status);


	}
	/* END LIST */

    /* DELETE     */
    public function admin_delete($id){
      $model = 'Relatorio';

      /// Segurança:
      ///=================================================
      /// - Verifica se a requisição a este método está sendo feito por um post.
      if (!$this->request->is('post')) {
          throw new MethodNotAllowedException();
      }

      /// - Verifica se o registro realmente existe.
      $this->$model->id = $id;
      if (!$this->$model->exists()) {
          throw new NotFoundException(__('Registro inexistente'));
      }
      ///=================================================



      /// Apaga os registros da base de dados
      if ($this->$model->delete($id)) {

          // Inserindo um alerta de sucesso na sessão ativa para ser mostrado ao usuário
          $this->Session->setFlash('Relatorio excluído com sucesso!');

          // Redirecionando o usuário para a listagem dos registros
          $this->redirect(array('action' => 'historicoRelatorio', 'admin' => true));
      }


    }
    /* END DELETE */

	public function admin_gerarPdf(){
		$this->autoRender = false;
		App::import('Vendor', 'fpdf/PDF');
        $this->layout = 'pdf'; //this will use the pdf.ctp layout


        $model = 'Relatorio';

        $conditions['filtro'] = array('Pl.delete' => 0);
        $conditionsNew = array();


        if( $this->request->is('post') || $this->request->is('put') ){
        	$registros = $this->request->data;
            $teste = $this->LogAtualizacaoPl->find('first');
            // print_r($teste);
            // die();

            // >>> TRATAR MES
            if(!empty($registros[$model]['data_inicio'])){
                $requestDateStartFiter  = $this->format_date($registros[$model]['data_inicio']);
            }
            if(!empty($registros[$model]['data_final'])){
                $requestDateEndFiter  = $this->format_date($registros[$model]['data_final']);
            }

            if( !empty($requestDateStartFiter) ){
				$conditionsNew = array(
					'LogAtualizacaoPl.modified >= ' => $requestDateStartFiter
				);
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['data_inicio'] = $requestDateStartFiter;
            }
            if(  !empty($requestDateEndFiter) ){
                $conditionsNew = array(
                    'LogAtualizacaoPl.modified <= ' => $requestDateEndFiter
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['data_final'] = $requestDateEndFiter;
            }
            /// FAZER FIND DO LOG E PEGAR APENAS OS IDs.
            ///==============================================
            //...
            // $pls_ids = $this->LogAtualizacaoPl->find('all', array(
            //     'conditions' => array(
            //         $conditions['filtro']
            //     )
            // ));
            // print_r($pls_ids);
            // die();
            // if (!empty($pls_ids)) {
            //     array_push($conditions['filtro'], array(
            //         'Pl.id' => $pls_ids,
            //     ));
            // }
            ///==============================================




            if( !empty($registros[$model]['tipo_id']) ){
                $conditionsNew = array(
                    'Pl.tipo_id' => $registros[$model]['tipo_id']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['tipo_id'] = $registros[$model]['tipo_id'];
            }
            if( !empty($registros[$model]['situacao_id']) ){
                $conditionsNew = array(
                    'Pl.situacao_id' => $registros[$model]['situacao_id']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['situacao_id'] = $registros[$model]['situacao_id'];
            }
            if( !empty($registros[$model]['ano']) ){
                $conditionsNew = array(
                    'Pl.ano' => $registros[$model]['ano']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['ano'] = $registros[$model]['ano'];
            }
            if( !empty($registros[$model]['tema_id']) ){
                $conditionsNew = array(
                    'Pl.tema_id' => $registros[$model]['tema_id']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['tema_id'] = $registros[$model]['tema_id'];
            }
            if( !empty($registros[$model]['autor']) ){
                $conditionsNew = array(
                    'Pl.autor' => $registros[$model]['autor']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['autor'] = $registros[$model]['autor'];
            }
            if( !empty($registros[$model]['relator']) ){
                $conditionsNew = array(
                    'Pl.relator' => $registros[$model]['relator']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['relator'] = $registros[$model]['relator'];
            }
            if( !empty($registros[$model]['status']) ){
                $conditionsNew = array(
                    'Pl.status' => $registros[$model]['status']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['status'] = $registros[$model]['status'];
            }


            if( !empty($registros[$model]['prioridade']) ){
                if($registros[$model]['prioridade'] == 'sim'){
                    $conditionsNew = array(
                        'Pl.prioridade' => 1
                    );
                }
                if($registros[$model]['prioridade'] == 'nao'){
                    $conditionsNew = array(
                        'Pl.prioridade' => 0
                    );
                }
                // if($registros[$model]['prioridade'] == 'todas'){
                //     $conditionsNew = array(
                //         'OR' => array(
                //             'Pl.prioridade' => 0,
                //             'Pl.prioridade' => 1,
                //         )
                //     );
                // }
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['prioridade'] = $registros[$model]['prioridade'];
            }


            if( !empty($registros[$model]['status_type_id']) ){
                $conditionsNew = array(
                    'Pl.status_type_id' => $registros[$model]['status_type_id']
                );
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['status_type_id'] = $registros[$model]['status_type_id'];
            }

            if( !empty($registros[$model]['arquivo']) ){
                if( $registros[$model]['arquivo'] == 'sim' ){
                    $conditionsNew = array(
                        'not' => array(
                            'Pl.arquivo' => null
                        )
                    );
                }
                if( $registros[$model]['arquivo'] == 'nao' ){
                        $conditionsNew = array(
                            'Pl.arquivo' => null
                        );
                }
                // if( $registros[$model]['arquivo'] == 'todas' ){
                //         $conditionsNew = array(
                //             'OR' => array(
                //                 'Pl.arquivo' => null,
                //                 'Pl.arquivo <>' => null,
                //             )
                //         );
                // }
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['arquivo'] = $registros[$model]['arquivo'];
            }




            /////====> FIND NA PL COM OS PARAMETROS ACIMA
            $result = $this->LogAtualizacaoPl->find('all', array(
            	'fields' => array(
            		// 'Pl.id',
            		// 'PlType.tipo',
            		// 'Pl.numero_da_pl',
            		// 'Pl.ano',
            		// 'Pl.autor',
            		// 'Pl.relator',
            		// 'Pl.prioridade',
            		// 'Pl.arquivo',
                    // 'StatusType.status_name',
                    // 'Tema.tema_name',
            		),
                'conditions' => $conditions['filtro'],
                'recursive' => 2,
                'order' => array(
                    'Pl.id' => 'DESC'
                ),
                'group' => array('LogAtualizacaoPl.pl_id')
            ));

            if(!empty($result)):
	            $pdf = new PDF('P','mm','A4');
	            $this->set('pdf', $pdf);
	            if(!empty($result)){
	                $nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'.pdf';
	                $this->request->data[$model]['nome_relatorio'] = $nameFile;
	                $this->request->data[$model]['url'] = 'uploads/relatorios/'.$nameFile;
	                $this->request->data[$model]['usuario_que_gerou'] = $this->Session->read('Auth.User.id');
	                $this->request->data[$model]['usuario_name'] = $this->Session->read('Auth.User.name');
	                $this->request->data[$model]['usuario_username'] = $this->Session->read('Auth.User.username');

	                // >>> SALVAR EM RELATORIOS
	                $this->$model->save($this->request->data);
	            }
	            $this->set('result', $result);


                ///////////////////////////////////////////////////////////////////////////////////////////////////////
                // >>> Layout do PDF
	            //>>> PDF
                if($registros[$model]['type'] == 'completo'):
                    ///////////////////////////////////////////////////////////////////////////////////////////////////////
                    // >>> Completo
                    $count = count($result);
                    $contador = 0;
                    $proposicaoPlural = "Proposição";
                    if($count > 1 ){
                        $proposicaoPlural = "Proposições";
                    }
    	            $pdf->AddPage();
    	            $pdf->SetFont('Arial','B',10);
    	            $pdf->Cell(120,4,utf8_decode('Relatório Completo '.date('d/m/Y \à\s H:i:s')),0,0,'L');
    	            $pdf->SetFont('Arial','',10);
    	            $pdf->Cell(60,4,utf8_decode('Total de ('.$count.') '.$proposicaoPlural.'.'),0,1,'R');
    	            $pdf->Ln(10);
                    $formatTitle = 10;
                    $formatTexto = 8;
    	            foreach($result as $registro){
                        $prioridade = 'Não';
                        $status = '';
                        $tema = '';
                        $notasTecnicas = 'Não';
                        if($registro['Pl']['prioridade'] == 1){
                            $prioridade = 'Sim';
                        }
                        if(!empty($registro['Pl']['StatusType']['status_name'])){
                            $status = $registro['Pl']['StatusType']['status_name'];
                        }
                        if(!empty($registro['Pl']['Tema']['tema_name'])){
                            $tema = $registro['Pl']['Tema']['tema_name'];
                        }
                        if(!empty($registro['Pl']['arquivo'])){
                            $notasTecnicas = 'Sim';
                        }

    	                $pl = $registro['Pl']['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl']. '/' .$registro['Pl']['ano'];
    	                $pdf->SetFont('Arial','B',$formatTitle);
    	                $pdf->SetFillColor(235,235,235);
                        // $pdf->SetFillColor(225,225,225);
    	                $pdf->Cell( 0, 7, $pl, 1, 1, 'C', true);
    	                $pdf->SetFillColor(255,255,255);
    	                $pdf->Cell(15, 10, 'Autor:', 0, 0);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->Cell(80, 10, utf8_decode($registro['Pl']['autor']), 0, 0);
    	                $pdf->SetFont('Arial','B',$formatTitle);
    	                $pdf->Cell(15, 10, 'Relator:', 0, 0);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->Cell(80, 10, utf8_decode($registro['Pl']['relator']), 0, 1);

    	                $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(15, 10, utf8_decode('Status:'), 0, 0);
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->Cell(40, 10, utf8_decode($status), 0, 0);
    	                $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(15, 10, utf8_decode('Tema:'), 0, 0);
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->Cell(40, 10, utf8_decode($tema), 0, 0);
    	                $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(20, 10, utf8_decode('Prioridade:'), 0, 0, 'R');
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->Cell(10, 10, utf8_decode($prioridade), 0, 0, 'R');
                        $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(40, 10, utf8_decode('Notas Técnicas:'), 0, 0, 'R');
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->Cell(10, 10, utf8_decode($notasTecnicas), 0, 1, 'R');

    	                $timeFoco = $this->formatDate($registro['Pl']['Foco'][0]['modified']);
    	                $timeOqueE = $this->formatDate($registro['Pl']['OqueE'][0]['modified']);
    	                $timeSituacao = $this->formatDate($registro['Pl']['Situacao'][0]['modified']);
    	                $timeNossaPosicao = $this->formatDate($registro['Pl']['NossaPosicao'][0]['modified']);

    	                $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(60, 5, utf8_decode('Foco'), 'T',0,'L',true);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Pl']['Foco'][0]['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeFoco ) , 'T', 1,'L',true);

    	                $pdf->SetFont('Arial','B',$formatTitle);
    	                $pdf->Cell(60, 10, utf8_decode('O que é'), 'T', 0,'L',false);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Pl']['OqueE'][0]['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeOqueE ), 'T', 1);


    	                $pdf->SetFont('Arial','B',$formatTitle);
    	                $pdf->Cell(60, 10, utf8_decode('Situação'), 'T', 0,'L',true);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Pl']['Situacao'][0]['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeSituacao ), 'T', 1,'L',true);

    	                $pdf->SetFont('Arial','B',$formatTitle);
    	                $pdf->Cell(60, 10, utf8_decode('Nossa Posição'), 'T', 0,'L',false);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Pl']['NossaPosicao'][0]['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeNossaPosicao ), 'T', 1);
                        $pdf->Cell(190, 5, '', 'T',0,'L',true);
    	                $pdf->Ln(15);
                        $contador++;
                        if($contador < $count){
                            if($contador%2 == 0){
    	                           $pdf->AddPage();
                            }
                        }
    	            }
                    // <<< Completo
                    ///////////////////////////////////////////////////////////////////////////////////////////////////////
                else:
                    $count = count($result);
                    $contador = 0;
                    $proposicaoPlural = "Proposição";
                    if($count > 1 ){
                        $proposicaoPlural = "Proposições";
                    }
                    $pdf->AddPage();
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(120,4,utf8_decode('Relatório Simples '.date('d/m/Y \à\s H:i:s')),0,0,'L');
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(60,4,utf8_decode('Total de ('.$count.') '.$proposicaoPlural.'.'),0,1,'R');
                    $pdf->Ln(10);
                    $formatTitle = 10;
                    $formatTexto = 8;
                    foreach($result as $registro){
                        $contador++;
                        $prioridade = 'Não';
                        $status = '';
                        $tema = '';
                        if($registro['Pl']['prioridade'] == 1){
                            $prioridade = 'Sim';
                        }
                        if(!empty($registro['Pl']['StatusType']['status_name'])){
                            $status = $registro['Pl']['StatusType']['status_name'];
                        }
                        if(!empty($registro['Pl']['Tema']['tema_name'])){
                            $tema = $registro['Pl']['Tema']['tema_name'];
                        }

                        $pl = $registro['Pl']['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl']. '/' .$registro['Pl']['ano'];
                        $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->SetFillColor(235,235,235);
                        // $pdf->SetFillColor(225,225,225);
                        $pdf->Cell( 0, 7, $contador.') '.$pl, 1, 1, 'L', true);
                        $pdf->SetFillColor(255,255,255);
                        $pdf->Cell(15, 10, 'Autor:', 0, 0);
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->Cell(80, 10, utf8_decode( $registro['Pl']['autor'] ), 0, 0);
                        $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(15, 10, 'Relator:', 0, 0);
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->Cell(80, 10, utf8_decode( $registro['Pl']['relator'] ), 0, 1);

                        $timeFoco = $this->formatDate($registro['Pl']['Foco'][0]['modified']);

                        $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(15, 5, utf8_decode('Foco: '), 0,0,'L',true);
                        $pdf->SetFont('Arial','',$formatTexto);
                        $pdf->MultiCell(175, 5, utf8_decode( strip_tags($registro['Pl']['Foco'][0]['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeFoco ), 0, 1,'L',true);
                        $pdf->Cell(190, 5, '', 'T',0,'L',true);

                        $pdf->Ln(15);
                        // if($contador < $count){
                        //     if($contador%5 == 0){
                        //            $pdf->AddPage();
                        //     }
                        // }
                    }

                endif;
                // <<< Layout do PDF
                ///////////////////////////////////////////////////////////////////////////////////////////////////////

	            // $pdf->Output('relatorio.pdf', 'D');
	            $nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'.pdf';
	            $pdf->Output('uploads/relatorios/'.$nameFile, 'F');

	            //<<< PDF
				$nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'.pdf';
				$url = 'uploads/relatorios/'.$nameFile;
				$a_url = array('url' => $url);
		        return json_encode($a_url);

		    else:
		    	$url = false;
				$a_url = array('url' => $url);
		    	return json_encode($a_url);

            endif;

        }
	}

	public function admin_historicoRelatorio(){
        $model = 'Relatorio';
        $this->set('model', $model);


        $this->paginate['fields'] = array(
                                        // 'id',
                                        // 'tipo',
                                        // 'ativo',
                                    );
        $this->paginate['recursive'] = -1;
        $this->paginate['order'] = array('id' => 'DESC');
        // >>> FILTRO
        $conditions = array();

        $this->paginate['conditions'] = array($conditions);
        $this->set('registros', $this->paginate($model));
    }

    public function admin_autocomplete(){
    	$this->autoRender = false;
        $model = 'Pl';
        $result = $this->$model->find('all', array(
            'fields' => array(
                $model.'.autor', $model.'.relator'
            )
        ));

        $a_registros['Pl'] = array();
        foreach($result as $registro){
            array_push($a_registros['Pl'], array($registro['Pl']['autor']));
            array_push($a_registros['Pl'], array($registro['Pl']['relator']));
        }

        $uniqueRegistro = array_unique($a_registros);
        echo json_encode($uniqueRegistro);
    }

    public function formatDate($date=null){
        $dateExplodeData = explode('-', $date);
        $dateExplodeHour = explode(':', $date);
        $dateNew = substr($dateExplodeData[2], 0, 2).'/'.$dateExplodeData[1].'/'.$dateExplodeData[0]. ' às '.substr($dateExplodeHour[0], -2). ':'. $dateExplodeHour[1] ;

        return $dateNew;
    }

   	public function format_date($date=null){
        $date = explode(" ",$date);
        $_texto_para_mes = array(
            'Janeiro' => '01',
            'Fevereiro' => '02',
            'Março' => '03',
            'Abril' => '04',
            'Maio' => '05',
            'Junho' => '06',
            'Julho' => '07',
            'Agosto' => '08',
            'Setembro' => '09',
            'Outubro' => '10',
            'Novembro' => '11' ,
            'Dezembro' => '12'
        );

        $texto = substr($date[1], 0, -1);
        if($date[0] < 10){
            $date[0] = '0'.$date[0];
        }
        $formatDateFinal = $date[2].'/'.$_texto_para_mes[$texto].'/'.$date[0];

        return $formatDateFinal;
    }

    public function admin_enviarRelatorioEmail($registros=null){
    	$this->autoRender = false;
    	$logoTop = 'http://abear.com.br/uploads/img/logo/header_logo-abear.png';
        $tituloDoEmail = 'Relatório';
       	$linkPdf = Router::url('/'.$this->request->data['enviarEmail']['enviarLinkPdf'], true);
       	$allUsers = $this->User->find('all', array(
            'fields' => array('id', 'email', 'name'),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => ''
            )
        ));
       	foreach ($allUsers as $user) {
       		$email = $user['User']['email'];
            if($this->validaEmail($email)){
		       	$nome = $user['User']['name'];
				$msg = '
		            <table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
		                <tbody>
		                    <tr>
		                        <td align="left" width="130">
		                            <img src="'.$logoTop.'">
		                        </td>
		                        <td colspan="2">
		                            <table style="background-color: #ffd600 !important;" height="115" width="570">
		                                <tbody>
		                                    <tr>
		                                        <td align="center" style="font-size: 24px;text-transform: uppercase;font-weight: 500;color: #000;">
		                                            <strong>agenda legislativa</strong>
		                                        </td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                        </td>
		                    </tr>
		                </tbody>
		            </table>



					<table cellpadding="0" cellspacing="0" width="700" align="center" style="color:#747474;font-size: 14px;font-family: Verdana;">
						<tbody>
							<tr>
								<td>
		                            <br>
		                    		<br>
		                    		<br>
		                    		<br>
		                    		<br>
									<table cellpadding="0" cellspacing="0" width="600" align="center">
										<tbody>
											<tr>
												<td height="100">
													<p style="font-size: 18px;color: #000;">
														Olá <strong>'.$nome.'.</strong>
													</p>
													<hr>
												</td>
											</tr>

											<tr>
												<td>
		                                            <p>
		                                            	'.$this->Session->read('Auth.User.username').' gerou um relatório.
													</p>
												</td>
											</tr>
											<tr>
												<td align="center">
													<br>
													<p>
														<a href="'.$linkPdf.'" style="border-style: solid;border-width: 0px;cursor: pointer;font-weight: normal;line-height: normal;margin: 0 0 1.25rem;position: relative;text-decoration: none;text-align: center;display: inline-block;padding-top: 1rem;padding-right: 2rem;padding-bottom: 1.0625rem;padding-left: 2rem;font-size: 1.2rem;background-color: #2E7D32;border-color: #097b61;color: white;-moz-transition: background-color 300ms ease-out;transition: background-color 300ms ease-out;padding-top: 1.0625rem;padding-bottom: 1rem;-webkit-appearance: none;font-weight: normal !important;-moz-border-radius: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
															Acesse
														</a>
													</p>
												</td>
											</tr>
										</tbody>
									</table>

								</td>
							</tr>
						</tbody>
					</table>
				';
		        $this->envio_email($email, $tituloDoEmail, $msg);
		    }
        }
        return true;
    }

    public function envio_email($email_to=null, $title=null, $msg=null) {
    	$this->autoRender = false;


        $Email = new CakeEmail();
		$Email->emailFormat('html')                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         