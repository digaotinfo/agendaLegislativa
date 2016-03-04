<?


App::import('Vendor', 'excel/PHPExcel');
App::import('Vendor', 'excel/PHPExcel/Writer/Excel2007');
App::import('Vendor', 'excel/PHPExcel/Reader/Excel2007');

App::uses('CakeEmail', 'Network/Email');
class RelatoriosController extends AppController{
 	var $name = "Relatorios";
	public $helpers = array('Html', 'Session', 'Form', 'Time');
	public $uses = array('Relatorio', 'PlType', 'PlSituacao', 'Pl', 'LogAtualizacaoPl', 'Foco', 'OqueE', 'Situacao', 'NossaPosicao', 'User', 'Tema', 'StatusType', 'AutorRelator', 'PlAutorRelator', 'Tarefa');
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

        $usuariosLista = $this->User->find('list', array(
            'fields' => array(
                'id',
                'username'
            ),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => ''
            ),
            'order' => array(
                'User.username' => 'ASC'
            )
        ));
        $this->set('usuariosLista', $usuariosLista);

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

    public function admin_gerarRelatorio(){
        $this->autoRender = false;
		App::import('Vendor', 'fpdf/PDF');
        $this->layout = 'pdf'; //this will use the pdf.ctp layout

        $model = 'Relatorio';

        $conditions['filtro'] = array(0 => 'Pl.delete = 0');
        $conditions['filtroAutor'] = array();
        $conditions['filtroRelator'] = array();
        $conditions['date'] = array();
        $conditionsNewDate = array();
        $conditionsNew = array();


        if( $this->request->is('post') || $this->request->is('put') ){
        	$registros = $this->request->data;

            // >>> TRATAR MES
            if(!empty($registros[$model]['data_inicio'])){
                $requestDateStartFiter  = $this->format_date($registros[$model]['data_inicio']);
            }
            if(!empty($registros[$model]['data_final'])){
                $requestDateEndFiter  = $this->format_date($registros[$model]['data_final']);
            }


            if( !empty($requestDateStartFiter) ){
				$conditionsNewDate = array(
					'LogAtualizacaoPl.modified >= ' => $requestDateStartFiter
				);
                array_push($conditions['date'], $conditionsNewDate);
                $this->request->data[$model]['data_inicio'] = $requestDateStartFiter;
            }
            if(  !empty($requestDateEndFiter) ){
                $conditionsNewDate = array(
                    'LogAtualizacaoPl.modified <= ' => $requestDateEndFiter
                );
                array_push($conditions['date'], $conditionsNewDate);
                $this->request->data[$model]['data_final'] = $requestDateEndFiter;
            }
            // /// FAZER FIND DO LOG E PEGAR APENAS OS IDs.
            // ///==============================================
            if(!empty($conditions['date'])){
                $pls_ids = $this->LogAtualizacaoPl->find('all', array(
                    'fields' => array('LogAtualizacaoPl.pl_id'),
                    'conditions' => array(
                        $conditions['date']
                    ),
                    'group' => array('LogAtualizacaoPl.pl_id')
                ));
                $pls_ids_string = '';
                foreach($pls_ids as $id){
                    $pls_ids_string = $pls_ids_string.$id['LogAtualizacaoPl']['pl_id'].",";
                }
                $pls_ids_string = substr($pls_ids_string, 0, -1);

                if (!empty($pls_ids_string)) {
                    $conditionsNew = ' AND Pl.id in ('. $pls_ids_string .')';
                    array_push($conditions['filtro'], $conditionsNew);
                }else{
                    // array_push($conditions['filtro'], array('Pl.delete => 0'));
                }

            }
            // ///==============================================


            if( !empty($registros[$model]['tipo_id']) ){
                $conditionsNew = " ".$registros['Relatorio']['datas_tipo_e_ou']." Pl.tipo_id = ".$registros[$model]['tipo_id'];
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['tipo_id'] = $registros[$model]['tipo_id'];
            }
            if( !empty($registros[$model]['ano']) ){
                $conditionsNew = " ".$registros['Relatorio']['tipo_ano_e_ou']." Pl.ano = ".$registros[$model]['ano'];
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['ano'] = $registros[$model]['ano'];
            }
            if( !empty($registros[$model]['tema_id']) ){
                $conditionsNew = " ".$registros['Relatorio']['ano_tema_e_ou']." Pl.tema_id = ".$registros[$model]['tema_id'];
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['tema_id'] = $registros[$model]['tema_id'];
            }





            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if( !empty($registros[$model]['autor']) ){
                $autorRelatorID = $this->AutorRelator->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'AutorRelator.nome' => $registros[$model]['autor']
                    )
                ));
                if(!empty($autorRelatorID)):
                    $conditionsNew = " ".$registros['Relatorio']['tema_autor_e_ou']." Pl.autor_id = ".$autorRelatorID['AutorRelator']['id'];
                    array_push($conditions['filtro'], $conditionsNew);
                    $this->request->data[$model]['autor'] = $autorRelatorID['AutorRelator']['id'];
                endif;
            }
            if( !empty($registros[$model]['relator']) ){
                $autorRelatorID = $this->AutorRelator->find('first', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'AutorRelator.nome' => $registros[$model]['relator']
                    )
                ));
                if(!empty($autorRelatorID)):
                    $conditionsNew = " ".$registros['Relatorio']['autor_relator_e_ou']." Pl.relator_id = ".$autorRelatorID['AutorRelator']['id'];
                    array_push($conditions['filtro'], $conditionsNew);
                    $this->request->data[$model]['relator'] = $autorRelatorID['AutorRelator']['id'];
                endif;
            }

            if( !empty($registros[$model]['status_type_id']) ){
                $conditionsNew = " ".$registros['Relatorio']['relator_status_e_ou']." Pl.status_type_id = ".$registros[$model]['status_type_id'];
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['status_type_id'] = $registros[$model]['status_type_id'];
            }

            if( $registros[$model]['arquivo'] != 'todas' ){
                if( $registros[$model]['arquivo'] == 'sim' ){
                    $conditionsNew = " ".$registros['Relatorio']['status_notasTecnicas_e_ou']." Pl.arquivo != '' ";
                }

                if( $registros[$model]['arquivo'] == 'nao' ){
                    $conditionsNew = " ".$registros['Relatorio']['status_notasTecnicas_e_ou']." Pl.arquivo = '' ";
                }
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['arquivo'] = $registros[$model]['arquivo'];
            }

            if( $registros[$model]['prioridade'] != 'todas' ){
                if($registros[$model]['prioridade'] == 'sim'){
                    $conditionsNew = " ".$registros['Relatorio']['notasTecnicas_prioridade_e_ou']." Pl.prioridade = 1";
                }
                if($registros[$model]['prioridade'] == 'nao'){
                    $conditionsNew = " ".$registros['Relatorio']['notasTecnicas_prioridade_e_ou']." Pl.prioridade = 0";
                }
                array_push($conditions['filtro'], $conditionsNew);
                $this->request->data[$model]['prioridade'] = $registros[$model]['prioridade'];
            }

            $sqlWhereCond = "";
            foreach($conditions['filtro'] as $cond){
                $sqlWhereCond = $sqlWhereCond.$cond;
            }

            $autorSelect = '';
            $relatorSelect = '';
            if( !empty($conditions['filtroAutor'][0]) ){
                $autorSelect = $conditions['filtroAutor'][0];
            }
            if( !empty($conditions['filtroRelator'][0]) ){
                $relatorSelect = $conditions['filtroRelator'][0];
            }
            // print_r($conditions);
            // die();
            if( $this->request->data['Relatorio']['type'] == 'agp' ){
                $resultQuery = $this->$model->query("
                                                SELECT
                                                    Tema.tema_name as classificacao,
                                                    COUNT(*) as geral,
                                                    (
                                                        SELECT
                                                            COUNT(*)
                                                        FROM
                                                            tb_pls as Pl
                                                        WHERE
                                                            Pl.prioridade=1
                                                            AND Pl.tema_id=Tema.id
                                                    ) as pauta_minima

                                                FROM
                                                    arearestrita_dev.tb_pls as Pl
                                                    left join tb_tema as Tema on (Tema.id = Pl.tema_id )

                                                WHERE

                                                    Pl.ativo=1
                                                    AND Pl.delete=0
                                                    AND Pl.status_type_id=1

                                                    group by Tema.tema_name
                                                ");
            }else{
                $resultQuery = $this->$model->query("
                                            SELECT
                                                    ".$autorSelect."
                                                    ".$relatorSelect."
                                                    Pl.id,
                                                    PlType.tipo,
                                                    Pl.tipo_id,
                                                    Pl.numero_da_pl,
                                                    Pl.ano,
                                                    Pl.autor_id,
                                                    Pl.relator_id,
                                                    Pl.prioridade,
                                                    Pl.arquivo,
                                                    Pl.etapa_id,
                                                    Pl.subetapa_id,
                                                    StatusType.status_name,
                                                    StatusType.id,
                                                    Tema.tema_name,
                                                    Foco.txt,
                                                    Foco.modified,
                                                    OqueE.txt,
                                                    OqueE.modified,
                                                    Situacao.txt,
                                                    Situacao.modified,
                                                    NossaPosicao.txt,
                                                    NossaPosicao.modified,
                                                    Autor.nome as autor,
                                                    Relator.nome as relator,
                                                    Justificativa.justificativa,
                                                    Justificativa.modified,
                                                    Etapa.etapa,
                                                    Etapa.descricao as etapa_descricao,
                                                    SubEtapa.subetapa,
                                                    SubEtapa.descricao as subetapa_descricao

                                                FROM

                                                    tb_pls as Pl
                                                    left join tb_tema as Tema on (Tema.id = Pl.tema_id )
                                                    left join tb_pl_types as PlType on (PlType.id = Pl.tipo_id )
                                                    left join tb_status_types as StatusType on (StatusType.id = Pl.status_type_id )
                                                    left join tb_foco as Foco on (Foco.pl_id = Pl.id )
                                                    left join tb_o_que_e as OqueE on (OqueE.pl_id = Pl.id )
                                                    left join tb_situacao as Situacao on (Situacao.pl_id = Pl.id )
                                                    left join tb_nossa_posicao as NossaPosicao on (NossaPosicao.pl_id = Pl.id )
                                                    left join tb_autor_relator as Autor on (Autor.id = Pl.autor_id )
                                                    left join tb_autor_relator as Relator on (Relator.id = Pl.relator_id )
                                                    left join tb_justificativas as Justificativa on (Justificativa.pl_id = Pl.id )
                                                    left join tb_fluxo_etapa as Etapa on (Etapa.id = Pl.etapa_id AND Etapa.pl_type_id = Pl.tipo_id )
                                                    left join tb_fluxo_subetapa as SubEtapa on (SubEtapa.id = Pl.subetapa_id AND SubEtapa.etapa_id = Etapa.id )

                                                WHERE
                                                    ".$sqlWhereCond."

                                                GROUP BY Pl.id
                                                ORDER BY Pl.id DESC
                                                ");
            }
            // print_r($this->request->data);
            // die();

            /*
            *
            * prepara array e inserir ação abear >>>
            */
            $result = array();
            $resultAcaoAbear['Tarefa'] = array();
            foreach( $resultQuery as $row ){
                $resultAcaoAbear = $this->Tarefa->find('all', array(
                    'fields' => array(
                        'Tarefa.id',
                        'Tarefa.titulo',
                        'Tarefa.descricao',
                        'Tarefa.entrega',
                        'Tarefa.realizado',
                        'Tarefa.enviado_por_email',
                        'Tarefa.modified'
                    ),
                    'conditions' => array(
                        'Tarefa.pl_id' => $row['Pl']['id']
                    ),
                    'recursive' => -2
                ));

                array_push( $row, $resultAcaoAbear );
                array_push( $result, $row );

            }

            /*
            *
            * <<< prepara array e inserir ação abear
            */
            // echo "<pre>";
            // print_r( $result );
            // echo "</pre>";
            // die();
            if( !empty($result) ):
                $this->request->data['Relatorio']['tipo_relatorio'] = $this->request->data['Relatorio']['type'];

                if( ($this->request->data[$model]['type'] == 'completoPDF') || ($this->request->data[$model]['type'] == 'resumoPDF') ){
                    $nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'.pdf';
                    $this->request->data[$model]['nome_relatorio'] = $nameFile;
                    $this->request->data[$model]['url'] = 'uploads/relatorios/'.$nameFile;
                    $this->request->data[$model]['usuario_que_gerou'] = $this->Session->read('Auth.User.id');
                    $this->request->data[$model]['usuario_name'] = $this->Session->read('Auth.User.name');
                    $this->request->data[$model]['usuario_username'] = $this->Session->read('Auth.User.username');
                    $this->admin_gerarPdf($result);
                }
                if( ($this->request->data[$model]['type'] == 'completoExcel') || ($this->request->data[$model]['type'] == 'resumoExcel') || ($this->request->data['Relatorio']['type'] == 'agp')){
                    if($this->request->data['Relatorio']['type'] == 'agp'){
                        $nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'___agp.xls';
                    }else{
                        $nameFile = date('Ymd_his').'__'.$this->Session->read('Auth.User.id').'.xls';
                    }
                    $this->request->data[$model]['nome_relatorio'] = $nameFile;
                    $this->request->data[$model]['url'] = 'uploads/relatorios/excel/'.$nameFile;
                    $this->request->data[$model]['usuario_que_gerou'] = $this->Session->read('Auth.User.id');
                    $this->request->data[$model]['usuario_name'] = $this->Session->read('Auth.User.name');
                    $this->request->data[$model]['usuario_username'] = $this->Session->read('Auth.User.username');
                    $this->admin_gerarExcel($result);
                }

            endif;
        }
    }

	public function admin_gerarPdf($result){
        $model = 'Relatorio';
        $registros = $this->request->data;

        if(!empty($result)):
            $pdf = new PDF('P','mm','A4');
            $this->set('pdf', $pdf);
            if(!empty($result)){
                // >>> SALVAR EM RELATORIOS
                // $this->$model->save($this->request->data);
            }
            $this->set('result', $result);


            ///////////////////////////////////////////////////////////////////////////////////////////////////////
            // >>> Layout do PDF
            //>>> PDF
            if($registros[$model]['type'] == 'completoPDF'):
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
                    if(!empty($registro['StatusType']['status_name'])){
                        $status = $registro['StatusType']['status_name'];
                    }
                    if(!empty($registro['Tema']['tema_name'])){
                        $tema = $registro['Tema']['tema_name'];
                    }
                    if(!empty($registro['Pl']['arquivo'])){
                        $notasTecnicas = 'Sim';
                    }

                    $acoesAbear = $registro[0];
                    // echo "<pre>";
                    // print_r($registro);
                    // echo "</pre>";
                    // die();

	                $pl = $registro['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl']. '/' .$registro['Pl']['ano'];
	                $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->SetFillColor(235,235,235);
                    // $pdf->SetFillColor(225,225,225);
	                $pdf->Cell( 0, 7, $pl, 1, 1, 'C', true);
	                $pdf->SetFillColor(255,255,255);
	                $pdf->Cell(15, 10, 'Autor:', 0, 0);
                    $pdf->SetFont('Arial','',$formatTexto);
	                $pdf->Cell(80, 10, utf8_decode($registro['Autor']['autor']), 0, 0);
	                $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(15, 10, 'Relator:', 0, 0);
                    $pdf->SetFont('Arial','',$formatTexto);
	                $pdf->Cell(80, 10, utf8_decode($registro['Relator']['relator']), 0, 1);

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

	                $timeFoco = $this->formatSQLtoDate($registro['Foco']['modified']);
	                $timeOqueE = $this->formatSQLtoDate($registro['OqueE']['modified']);
	                $timeSituacao = $this->formatSQLtoDate($registro['Situacao']['modified']);
	                $timeNossaPosicao = $this->formatSQLtoDate($registro['NossaPosicao']['modified']);

                    if( !empty($registro['Justificativa']['justificativa']) && ($registro['StatusType']['id'] == 3)):
    	                $timeJustificativa = $this->formatSQLtoDate($registro['Justificativa']['modified']);

    	                $pdf->SetFont('Arial','B',$formatTitle);
                        $pdf->Cell(60, 5, utf8_decode('Justificativa'), 'T',0,'L',true);
                        $pdf->SetFont('Arial','',$formatTexto);
    	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Justificativa']['justificativa']) ).strip_tags( nl2br("\n") ).'adicionada em '.utf8_decode( $timeJustificativa ) , 'T', 1,'L',true);
                    endif;

	                $pdf->SetFont('Arial','B',$formatTitle);
                    $pdf->Cell(60, 5, utf8_decode('Foco'), 'T',0,'L',true);
                    $pdf->SetFont('Arial','',$formatTexto);
	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Foco']['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeFoco ) , 'T', 1,'L',true);

	                $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(60, 10, utf8_decode('O que é'), 'T', 0,'L',false);
                    $pdf->SetFont('Arial','',$formatTexto);
	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['OqueE']['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeOqueE ), 'T', 1);

	                $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(60, 10, utf8_decode('Ação ABEAR'), 'T', 0,'L',false);
                    $pdf->SetFont('Arial','',$formatTexto);
                    $textoCompletoAcaoAbear = '';
                    foreach( $acoesAbear as $acaoAbear ):
                        $titulo = $acaoAbear['Tarefa']['titulo'];
                        $descricao = $acaoAbear['Tarefa']['descricao'];
    	                $entrega = $this->formatSQLtoDate($acaoAbear['Tarefa']['entrega']);
                        $tratarDataEntrega = explode(' às ', $entrega);
                        $entrega = $tratarDataEntrega[0];
    	                $timeAcaoAbear = $this->formatSQLtoDate($acaoAbear['Tarefa']['modified']);
                        $realizado = 'Não';
                        if( $acaoAbear['Tarefa']['realizado'] == 1 ){ $realizado = 'Sim'; }

                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.'*'.$titulo.strip_tags( nl2br("\n") );
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.'    '.$descricao.strip_tags( nl2br("\n") );
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.'    '.$entrega.' - ';
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.$realizado.' realizado'.strip_tags( nl2br("\n") ).strip_tags( nl2br("\n") );
                    endforeach;
                    if( empty($textoCompletoAcaoAbear) ){
                        $textoCompletoAcaoAbear = utf8_decode(strip_tags("<br><br><br>")).strip_tags( nl2br("\n") ).strip_tags( nl2br("\n") );
                    }
                    $pdf->MultiCell(130, 5, utf8_decode( strip_tags( $textoCompletoAcaoAbear )), 'T', 1);


                    $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(60, 10, utf8_decode('Etapa'), 'T', 0,'L',false);
                    $pdf->SetFont('Arial','',$formatTexto);
                    if( !empty($registro['Etapa']['etapa']) ){
                        $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Etapa']['etapa']) ).strip_tags( nl2br("\n") ).utf8_decode( $registro['Etapa']['etapa_descricao'] ), 'T', 1);
                    }else{
                        $pdf->MultiCell(130, 5, utf8_decode(strip_tags("<br><br><br>")).strip_tags( nl2br("\n") ).strip_tags( nl2br("\n") ), 'T', 1);
                    }

                    $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(60, 10, utf8_decode('Sub-etapa'), 'T', 0,'L',false);
                    $pdf->SetFont('Arial','',$formatTexto);
                    if( !empty($registro['SubEtapa']['subetapa']) ){
                        $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['SubEtapa']['subetapa']) ).strip_tags( nl2br("\n") ).utf8_decode( $registro['SubEtapa']['subetapa_descricao'] ), 'T', 1);
                    }else{
                        $pdf->MultiCell(130, 5, utf8_decode(strip_tags("<br><br><br>")).strip_tags( nl2br("\n") ).strip_tags( nl2br("\n") ), 'T', 1);
                    }

	                $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(60, 10, utf8_decode('Situação'), 'T', 0,'L',true);
                    $pdf->SetFont('Arial','',$formatTexto);
	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['Situacao']['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeSituacao ), 'T', 1,'L',true);

	                $pdf->SetFont('Arial','B',$formatTitle);
	                $pdf->Cell(60, 10, utf8_decode('Nossa Posição'), 'T', 0,'L',false);

                    $pdf->SetFont('Arial','',$formatTexto);
	                $pdf->MultiCell(130, 5, utf8_decode( strip_tags($registro['NossaPosicao']['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeNossaPosicao ), 'T', 1);
                    $pdf->Cell(190, 5, '', 'T',0,'L',true);
	                $pdf->Ln(15);
                    $contador++;
                    if($contador < $count){
                        // if($contador%2 == 0){
	                    //        $pdf->AddPage();
                        // }
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
                    // print_r($result);
                    // die();
                foreach($result as $registro){
                    // print_r($registro);
                    // die();
                    $contador++;
                    $prioridade = 'Não';
                    $status = '';
                    $tema = '';
                    if($registro['Pl']['prioridade'] == 1){
                        $prioridade = 'Sim';
                    }
                    if(!empty($registro['StatusType']['status_name'])){
                        $status = $registro['StatusType']['status_name'];
                    }
                    if(!empty($registro['Tema']['tema_name'])){
                        $tema = $registro['Tema']['tema_name'];
                    }

                    $pl = $registro['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl']. '/' .$registro['Pl']['ano'];
                    $pdf->SetFont('Arial','B',$formatTitle);
                    $pdf->SetFillColor(235,235,235);
                    // $pdf->SetFillColor(225,225,225);
                    $pdf->Cell( 0, 7, $contador.') '.$pl, 1, 1, 'L', true);
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Cell(15, 10, 'Autor:', 0, 0);
                    $pdf->SetFont('Arial','',$formatTexto);
                    $pdf->Cell(80, 10, utf8_decode( $registro['Autor']['autor'] ), 0, 0);
                    $pdf->SetFont('Arial','B',$formatTitle);
                    $pdf->Cell(15, 10, 'Relator:', 0, 0);
                    $pdf->SetFont('Arial','',$formatTexto);
                    $pdf->Cell(80, 10, utf8_decode( $registro['Relator']['relator'] ), 0, 1);

                    $timeFoco = $this->formatSQLtoDate($registro['Foco']['modified']);

                    $pdf->SetFont('Arial','B',$formatTitle);
                    $pdf->Cell(15, 5, utf8_decode('Foco: '), 0,0,'L',true);
                    $pdf->SetFont('Arial','',$formatTexto);
                    $pdf->MultiCell(175, 5, utf8_decode( strip_tags($registro['Foco']['txt']) ).strip_tags( nl2br("\n") ).'modificado em '.utf8_decode( $timeFoco ), 0, 1,'L',true);
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

            $pdf->Output($this->request->data[$model]['url'], 'F');
            //<<< PDF

			$a_url = array('url' => $this->request->data[$model]['url']);
            $this->$model->save( $this->request->data );// <<< salvar log do relatorio
	        echo json_encode($a_url);
            die();
        else:

	    	$url = false;
			$a_url = array('url' => $url);
	    	echo json_encode($a_url);
            die();

        endif;
	}

    public function admin_gerarExcel($result=null){
        $model = 'Relatorio';
        $root = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/";

        $mesesShort = array(
					'Jan' => 'Jan',
					'Feb' => 'Fev',
					'Mar' => 'Mar',
					'Apr' => 'Abr',
					'May' => 'Mai',
					'Jun' => 'Jun',
					'Jul' => 'Jul',
					'Aug' => 'Ago',
					'Sep' => 'Set',
					'Oct' => 'Out',
					'Nov' => 'Nov',
					'Dec' => 'Dez'
					);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        							 ->setLastModifiedBy("Maarten Balliauw")
        							 ->setTitle("Office 2007 XLSX Test Document")
        							 ->setSubject("Office 2007 XLSX Test Document")
        							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        							 ->setKeywords("office 2007 openxml php")
        							 ->setCategory("Test result file");


        if(!empty($result)):
            if($this->request->data[$model]['type'] == 'completoExcel'){
                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Proposição')
                    ->setCellValue('B1', 'Autor')
                    ->setCellValue('C1', 'Relator')
                    ->setCellValue('D1', 'Status')
                    ->setCellValue('E1', 'Tema')
                    ->setCellValue('F1', 'Prioridade')
                    ->setCellValue('G1', 'Notas Técnicas')
                    ->setCellValue('H1', 'Foco')
                    ->setCellValue('I1', 'O que é?')
                    ->setCellValue('J1', 'Situação')
                    ->setCellValue('K1', 'Nossa Posição')
                    ->setCellValue('L1', 'Justificativa')
                    ->setCellValue('M1', 'Ação ABEAR')
                    ->setCellValue('N1', 'Etapa')
                    ->setCellValue('O1', 'Sub-Etapa');



        	    $i = 2;
        		foreach ($result as $registro){
                    $proposicao = $registro['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl'].'/'.$registro['Pl']['ano'];
                    $prioridade = 'Sim';
                    if( $registro['Tema']['tema_name'] == 0 ){
                        $prioridade = 'Não';
                    }


                    $timeFoco   = $this->formatSQLtoDate($registro['Foco']['modified']);
                    $timeOqueE = $this->formatSQLtoDate($registro['OqueE']['modified']);
	                $timeSituacao = $this->formatSQLtoDate($registro['Situacao']['modified']);
	                $timeNossaPosicao = $this->formatSQLtoDate($registro['NossaPosicao']['modified']);
	                // $timeJustificativa = ( !empty($registro['Justificativa']['justificativa']) ? $this->formatDate($registro['Justificativa']['modified'] : '');
                    ////////////////////////////////////
                    ////////////////////////////////////
                    //>>> txts
                    $autor      = ( !empty($registro['Autor']['autor']) ? $registro['Autor']['autor'] : "" );
                    $relator    = ( !empty($registro['Relator']['relator']) ? $registro['Relator']['relator'] : "" );
                    $status     = ( !empty($registro['StatusType']['status_name']) ? $registro['StatusType']['status_name'] : "" );
                    $tema       = ( !empty($registro['Tema']['tema_name']) ? $registro['Tema']['tema_name'] : "" );
                    $arquivo    = ( !empty($registro['Pl']['arquivo']) ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] .$this->webroot.$registro['Pl']['arquivo'] : "" );
                    $foco       = ( !empty($registro['Foco']['txt']) ? $registro['Foco']['txt'].' - modificado em '.$timeFoco : "" );
                    $oQueE      = ( !empty($registro['OqueE']['txt']) ? $registro['OqueE']['txt'].' - modificado em '.$timeOqueE : "" );
                    $acoesAbear = $registro[0];
                    $textoCompletoAcaoAbear = '';
                    foreach( $acoesAbear as $acaoAbear ):
                        $titulo = $acaoAbear['Tarefa']['titulo'];
                        $descricao = $acaoAbear['Tarefa']['descricao'];
    	                $entrega = $this->formatSQLtoDate($acaoAbear['Tarefa']['entrega']);
                        $tratarDataEntrega = explode(' às ', $entrega);
                        $entrega = $tratarDataEntrega[0];
    	                $timeAcaoAbear = $this->formatSQLtoDate($acaoAbear['Tarefa']['modified']);
                        $realizado = 'Não';
                        if( $acaoAbear['Tarefa']['realizado'] == 1 ){ $realizado = 'Sim'; }

                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.' Titulo: '.$titulo;
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.' Descrição: '.$descricao;
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.' entrega em: '.$entrega.' - ';
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.$realizado.' realizado ';
                        $textoCompletoAcaoAbear = $textoCompletoAcaoAbear.'modificado em '.$timeAcaoAbear;
                    endforeach;
                    $acaoAbear      = ( !empty($textoCompletoAcaoAbear) ? $textoCompletoAcaoAbear : "" );
                    $etapa = ( !empty($registro['Etapa']['etapa']) ? $registro['Etapa']['etapa'].' - '.$registro['Etapa']['etapa_descricao'] : "" );
                    $subetapa = ( !empty($registro['SubEtapa']['subetapa']) ? $registro['SubEtapa']['subetapa'].' - '.$registro['SubEtapa']['subetapa_descricao'] : "" );
                    // echo "<pre>";
                    // print_r($acaoAbear);
                    // echo "</pre>";
                    // die();




                    $situacao   = ( !empty($registro['Situacao']['txt']) ? $registro['Situacao']['txt'].' - modificado em '.$timeSituacao : "" );
                    $nPosicao   = ( !empty($registro['NossaPosicao']['txt']) ? $registro['NossaPosicao']['txt'].' - modificado em '.$timeNossaPosicao : "" );
                    $justificativa = ( !empty($registro['Justificativa']['justificativa'] ) && ($registro['StatusType']['id'] == 3) ? $registro['Justificativa']['justificativa'] : "" );

                    //<<< txts
                    ////////////////////////////////////
                    ////////////////////////////////////

        		// >>> content
        		$objPHPExcel->setActiveSheetIndex(0)
        		        ->setCellValue('A'.$i, $proposicao)
        		        ->setCellValue('B'.$i, $autor)
        		        ->setCellValue('C'.$i, $relator)
        		        ->setCellValue('D'.$i, $status)
        		        ->setCellValue('E'.$i, $tema)
        		        ->setCellValue('F'.$i, $prioridade)
        		        ->setCellValue('G'.$i, $arquivo)
        		        ->setCellValue('H'.$i, $foco)
        		        ->setCellValue('I'.$i, $oQueE)
        		        ->setCellValue('J'.$i, $situacao)
        		        ->setCellValue('K'.$i, $nPosicao)
        		        ->setCellValue('L'.$i, $justificativa)
        		        ->setCellValue('M'.$i, $acaoAbear )
        		        ->setCellValue('N'.$i, $etapa )
        		        ->setCellValue('O'.$i, $subetapa );
        		// <<< content

        		  $i++;
        		}

            }else{
                if($this->request->data[$model]['type'] == 'resumoExcel'):
                    // Add some data
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Proposição')
                        ->setCellValue('B1', 'Autor')
                        ->setCellValue('C1', 'Relator')
                        ->setCellValue('D1', 'Foco');

            	    $i = 2;
            		foreach ($result as $registro){
                        $proposicao = $registro['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl'].'/'.$registro['Pl']['ano'];
                        $prioridade = 'Sim';
                        if( $registro['Tema']['tema_name'] == 0 ){
                            $prioridade = 'Não';
                        }

                        $timeFoco   = $this->formatDate($registro['Foco']['modified']);
                        ////////////////////////////////////
                        ////////////////////////////////////
                        //>>> txts
                        $autor      = ( !empty($registro['Autor']['autor']) ? $registro['Autor']['autor'] : "" );
                        $relator    = ( !empty($registro['Relator']['relator']) ? $registro['Relator']['relator'] : "" );
                        $foco       = ( !empty($registro['Foco']['txt']) ? $registro['Foco']['txt'].' - modificado em '.$timeFoco : "" );

                        //<<< txts
                        ////////////////////////////////////
                        ////////////////////////////////////

                		// >>> content
                		$objPHPExcel->setActiveSheetIndex(0)
                		        ->setCellValue('A'.$i, $proposicao)
                		        ->setCellValue('B'.$i, $autor)
                		        ->setCellValue('C'.$i, $relator)
                		        ->setCellValue('D'.$i, $foco);
                		// <<< content

            		  $i++;
            		}
                endif;

                if( $this->request->data[$model]['type'] == 'agp' ):
                    $mes = date('M');

                    // Add some data
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Classificação - '.date('d/').strtolower($mesesShort[$mes]) )
                        ->setCellValue('B1', 'Geral')
                        ->setCellValue('C1', 'Paulta Mínima');

                    $i = 2;
                    $j = 3;
                    $countGeral = 0;
                    $countPautaMinima = 0;
                    $last_key = end(array_keys($result));

                    foreach( $result as $key => $registro ){
                        $countGeral = $countGeral+$registro['0']['geral'];
                        $countPautaMinima = $countPautaMinima+$registro['0']['pauta_minima'];
                        if( $last_key == $key ){
                            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$i, $registro['Tema']['classificacao'])
                            ->setCellValue('B'.$i, $registro['0']['geral'])
                            ->setCellValue('C'.$i, $registro['0']['pauta_minima']);
                            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$j, 'Total')
                            ->setCellValue('B'.$j, $countGeral )
                            ->setCellValue('C'.$j, $countPautaMinima);
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$i, $registro['Tema']['classificacao'])
                            ->setCellValue('B'.$i, $registro['0']['geral'])
                            ->setCellValue('C'.$i, $registro['0']['pauta_minima']);
                        }
                        $i++;
                        $j++;
                    }



                endif;
            }


            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('Simple');


            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="01simple.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save($root.$this->request->data[$model]['url']);
			$a_url = array('url' => $this->request->data[$model]['url']);


            $this->$model->save( $this->request->data );
	        echo json_encode($a_url);

            exit;
        endif;
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
        // echo '<pre>';
        // print_r($this->paginate($model));
        // echo '</pre>';
        // die();
        $this->set('registros', $this->paginate($model));
    }

    public function admin_autocomplete(){
        $this->autoRender = false;
        $model = 'AutorRelator';

        $result = $this->$model->find('all', array(
            'fields' => array(
                $model.'.nome'
            )
        ));

        $nomes = array();
        for($i=0; $i<count($result); $i++){
            array_push($nomes, $result[$i][$model]['nome']);
        }

        $uniqueRegistro = $nomes;
        echo json_encode($uniqueRegistro);
    }

    public function formatDate($date=null){
        $dateExplodeSeparaDataHora = explode(' ', $date);
        $dateExplodeData = explode('-', $dateExplodeSeparaDataHora[0]);
        $dateExplodeHour = explode(':', $dateExplodeSeparaDataHora[1]);

        // echo "<pre>";
        // print_r( $date );
        // echo "</pre>";
        // die();

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

    public function admin_enviarRelatorioEmail(){
    	$this->autoRender = false;

        $serialize = $this->request->data;

        $arquivo = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] .$this->webroot.$serialize['urlArquivo'];
        $a_idUsuarios = $serialize['idUsuarios'];
    	$logoTop = 'http://abear.com.br/uploads/img/logo/header_logo-abear.png';
        $tituloDoEmail = 'Relatório';
     //   	$linkPdf = Router::url('/'.$this->request->data['enviarEmail']['enviarLinkPdf'], true);

        //>>> PEGANDO OS IDS DE USUARIOS
        $a_ids = '';
        $last_key = end(array_keys($a_idUsuarios));

        // $countArray = count($this->request->data['idUsuarios']);
        foreach($a_idUsuarios as $key => $idUsuarios){
            if ($key != $last_key) {
                $a_ids = $a_ids.$a_idUsuarios[$key].',';
            }else{
                $a_ids = $a_ids.$a_idUsuarios[$key];
            }
        }
        //<<< PEGANDO OS IDS DE USUARIOS

        $allUsers = $this->User->find('all', array(
            'fields' => array('id', 'email', 'name'),
            'conditions' => array(
                'User.ativo' => 1,
                'User.email <>' => '',
                "User.id in ({$a_ids})",
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
														<a href="'.$arquivo.'" style="border-style: solid;border-width: 0px;cursor: pointer;font-weight: normal;line-height: normal;margin: 0 0 1.25rem;position: relative;text-decoration: none;text-align: center;display: inline-block;padding-top: 1rem;padding-right: 2rem;padding-bottom: 1.0625rem;padding-left: 2rem;font-size: 1.2rem;background-color: #2E7D32;border-color: #097b61;color: white;-moz-transition: background-color 300ms ease-out;transition: background-color 300ms ease-out;padding-top: 1.0625rem;padding-bottom: 1rem;-webkit-appearance: none;font-weight: normal !important;-moz-border-radius: 10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
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
		$Email->emailFormat('html');
		$Email->from(array('nao-responda@zoio.net.br' => 'Agenda Legislativa ABEAR'));
		$Email->to($email_to);
		$Email->subject($title);
		$Email->send($msg);
    }

    public function validaEmail($email){
        $conta = "^[a-zA-Z0-9\._-]+@";
        $domino = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$";
        $pattern = $conta.$domino.$extensao;
        if (ereg($pattern, $email)){
            return true;
        }else{
            return false;
        }
    }

    
}
