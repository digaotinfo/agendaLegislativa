<?php
$this->start('script');
	echo $this->Html->script('jquery.autocomplete.min.js');
	echo $this->Html->script('currency-autocomplete.js');
	?>
	<script charset="utf-8">
		$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15, // Creates a dropdown of 15 years to control year
			monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
			monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
			weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
			weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
			showMonthsShort: undefined,
			showWeekdaysFull: undefined
		});




		//+++++++ JUSTIFICATIVA ++++++++++++++++++++++++++++++++++++++//
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

		// >>> VERIFICAR EXIGENCIA DE JUSTIFICATIVA
		// $(document).ready(function(){
		// 	$('#status_type_id').change(function(){
		// 		var valor = $('#status_type_id').val();
		// 		if (valor == 3) {
		// 			$('#modaljustificativa').openModal({dismissible: false});
		// 			$('#justificativa_txt').focus();
		// 		}else{
		// 			$('#justificativa').val('');
		// 			$('#justificativa_txt').val('');
		//
		// 		}
		// 		$('.cancelar-justificativa').click(function(){
		// 			$('#justificativa').val('');
		// 			$('#justificativa_txt').val('');
		// 			retornaStatusOriginal();
		// 		});
		// 	});
		//
		// 	$('.form.save-justifica').click(function() {
		// 		var txtJustificativa = $('#justificativa_txt').val();
		// 		if( txtJustificativa != '' ){
		// 			$('#justificativa').val(txtJustificativa);
		// 			$('#modaljustificativa').closeModal();
		// 		}else{
		// 			alert('Adicione uma justificativa.');
		// 		}
		// 	});
		// });

		function retornaStatusOriginal() {
			$('#status_type_id').val(0);

			//===> Recriando o Material Select
			$('#status_type_id').material_select();

			//===> Eliminando sujeira do Materi
			$('.select-status > span.caret').remove();
		}
// <<< VERIFICAR EXIGENCIA DE JUSTIFICATIVA





		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//



    </script>
	<?php
$this->end();
?>

<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
    <div class="col s12">
        <h3 class="titulo-pagina">
            Gerando Relatório
            <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
        </h3>
    </div>
</div>
 <!-- / HEADER DA PÁGINA -->


<div class="row padding-top-20">
	<input type="hidden" name="url_autocomplete" id="url_autocomplete" value="<?php echo $this->Html->url(array('controller' => 'Relatorios', 'action' => 'autocomplete', 'admin' => true))?>">

	<?php echo $this->Form->create($model, array('id' => 'gerarRelatorio'));?>
	<div class="row data">
		<div class="input-field col s12">
			<div class="col s12 descricaoPeriodo">
				<p>Selecione o período de atualização.</p>
			</div>
			<div class="input-field col s6">
				<?php
				   echo $this->Form->input('data_inicio' ,  array(
							   'label' => false,
							   'div' => false,
							   'type' => 'text',
							   'class' => 'validate datepicker',
						   ));
				?>
				<label for="nossaposicao_texto">Data de início</label>
			</div>



			<?php
				/////////////////////////////////////////////////////////////////////
				//>>> Conditions datas
			?>
			<div class="col s2 center conditions hide">
				<a href="javascript:void(0);" class='datas legend_OR hide'>
					e
				</a>
				<a href="javascript:void(0);" class='datas legend_AND'>
					ou
				</a>
				<?php
					echo $this->Form->input('datas_e_ou' ,  array(
							   'type' => 'hidden',
							   'value' => 'OR',
							   'id' => 'type_option_datas'
					));
				?>
			</div>
			<?php
				//<<< Conditions datas
				/////////////////////////////////////////////////////////////////////
			?>

			<div class="input-field col s6">
				<?php
				   echo $this->Form->input('data_final' ,  array(
							   'label' => false,
							   'div' => false,
							   'type' => 'text',
							   'class' => 'validate datepicker',
						   ));
				?>
				<label for="nossaposicao_texto">Data final</label>
			</div>
		</div>
	</div>


	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions datas_tipo
	?>
	<div class="col s12 center-on-small-only conditions meio">
		<a href="javascript:void(0);" class='tooltipped datas_tipo legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped datas_tipo legend_AND'  data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('datas_tipo_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_datas_tipo'
			));
		?>
	</div>
	<?php
		//<<< Conditions datas_tipo
		/////////////////////////////////////////////////////////////////////
	?>
	<div class="input-field col s12 m7">
		<?php
		   echo $this->Form->input('tipo_id',  array(
					   'label' => false,
					   'div' => false,
					   'class' => 'validate',
					   'options' => $tipos,
					   'empty' => '',
				   ));
		?>
		<label for="nossaposicao_texto">Tipo</label>
	</div>
	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions tipo_ano
	?>
	<div class="col s12 m1 center conditions">
		<a href="javascript:void(0);" class='tooltipped tipo_ano legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped tipo_ano legend_AND'  data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('tipo_ano_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_tipo_ano'
			));
		?>
	</div>
	<?php
		//<<< Conditions tipo_ano
		/////////////////////////////////////////////////////////////////////
	?>
	<div class="input-field col s12 m4">
		<?php
		   echo $this->Form->input('ano' ,  array(
					   'label' => false,
					   'div' => false,
					   'type' => 'text',
					   'class' => 'validate ano',
				   ));
		?>
		<label for="nossaposicao_texto">Ano</label>
	</div>
	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions ano_tema
	?>
	<div class="col s12 center-on-small-only conditions meio">
		<a href="javascript:void(0);" class='tooltipped ano_tema legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped ano_tema legend_AND' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('ano_tema_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_ano_tema'
			));
		?>
	</div>
	<?php
		//<<< Conditions ano_tema
		/////////////////////////////////////////////////////////////////////
	?>
	<div class="input-field col s12">
		<?php
		   echo $this->Form->input('tema_id' ,  array(
					   'label' => false,
					   'div' => false,
					   'type' => 'select',
					   'class' => 'validate',
					   'id' => 'selectTema',
					   'options' => $temas,
					   'empty' => ' -- Selecione o tema -- ',
				   ));
		?>
		<label for="nossaposicao_texto">Tema:</label>
	</div>

	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions tema_autor
	?>
	<div class="col s12 center-on-small-only conditions meio">
		<a href="javascript:void(0);" class='tooltipped tema_autor legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped tema_autor legend_AND' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('tema_autor_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_tema_autor'
			));
		?>
	</div>
	<?php
		//<<< Conditions tema_autor
		/////////////////////////////////////////////////////////////////////
	?>

	<div class="input-field col s12 m12 l5">
		<?php
		   echo $this->Form->input('autor' ,  array(
					   'label' => false,
					   'div' => false,
					   'type' => 'text',
					   'class' => 'validate autocomplete',
				   ));
		?>
		<label for="nossaposicao_texto">Autor</label>
	</div>

	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions autor_relator
	?>
	<div class="col s12 m12 l2 center conditions">
		<a href="javascript:void(0);" class='tooltipped autor_relator legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped autor_relator legend_AND' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('autor_relator_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_autor_relator'
			));
		?>
	</div>
	<?php
		//<<< Conditions autor_relator
		/////////////////////////////////////////////////////////////////////
	?>
	<div class="input-field col s12 m12 l5 center-on-small-only">
		<?php
		   echo $this->Form->input('relator' ,  array(
					   'label' => false,
					   'div' => false,
					   'type' => 'text',
					   'class' => 'validate autocomplete',
				   ));
		?>
		<label for="nossaposicao_texto">Relator</label>
	</div>

	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions relator_status
	?>
	<div class="col s12  center-on-small-only conditions meio">
		<a href="javascript:void(0);" class='tooltipped relator_status legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped relator_status legend_AND' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('relator_status_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_relator_status'
			));
		?>
	</div>
	<?php
		//<<< Conditions relator_status
		/////////////////////////////////////////////////////////////////////
	?>
    <div class="input-field col s12 m5 l5 select-status">
        <?php
            echo $this->Form->input('status_type_id' ,  array(
                        'label' => false,
                        'div' => false,
                        'type' => 'select',
                        'class' => 'validate',
                        'options' => $status,
						'empty' => ' -- Selecione o Status -- ',
						'id' => 'status_type_id'
                    ));
        ?>
        <label for="nossaposicao_texto">Status:</label>
		<?php
			echo $this->Form->input('justificativa', array(
				'type'	=> 'hidden',
				'id' => 'justificativa',
				'class' => 'input-padrao',
				'label' => false
			));
		?>
    </div>
	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions status_notasTecnicas
	?>
	<div class="col s12 m2 center conditions">
		<a href="javascript:void(0);" class='tooltipped status_notasTecnicas legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped status_notasTecnicas legend_AND' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('status_notasTecnicas_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_status_notasTecnicas'
			));
		?>
	</div>
	<?php
		//<<< Conditions status_notasTecnicas
		/////////////////////////////////////////////////////////////////////
	?>
	<div class="input-field col s12 m5 l5">
		<?php
			$options = array(
				'todas' => 'Mostrar Ambos',
				'sim' => 'Com Notas Técnicas',
				'nao' => 'Sem Notas Técnicas',
			);
			echo $this->Form->input('arquivo' ,  array(
						'label' => false,
						'div' => false,
						'type' => 'select',
						'class' => 'validate',
						'options' => $options,
					));
		?>
		<label for="nossaposicao_texto">Notas Tecnicas:</label>
	</div>

	<?php
		/////////////////////////////////////////////////////////////////////
		//>>> Conditions notasTecnicas_prioridade
	?>
	<div class="col s12  center-on-small-only conditions meio">
		<a href="javascript:void(0);" class='tooltipped notasTecnicas_prioridade legend_OR hide' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			e
		</a>
		<a href="javascript:void(0);" class='tooltipped notasTecnicas_prioridade legend_AND' data-position="bottom" data-delay="50" data-tooltip="Click aqui para trocar a condição do Filtro">
			ou
		</a>
		<?php
			echo $this->Form->input('notasTecnicas_prioridade_e_ou' ,  array(
					   'type' => 'hidden',
					   'value' => 'OR',
					   'id' => 'type_option_notasTecnicas_prioridade'
			));
		?>
	</div>
	<?php
		//<<< Conditions notasTecnicas_prioridade
		/////////////////////////////////////////////////////////////////////
	?>
	<div class="input-field col s12 m6 l6">
		<?php
			$options = array(
				'todas' => 'Mostrar Ambos',
				'sim' => 'Prioridade',
				'nao' => 'Sem Prioridade',
			);
			echo $this->Form->input('prioridade' ,  array(
						'label' => false,
						'div' => false,
						'type' => 'select',
						'class' => 'validate',
						'options' => $options,
					));
		?>
		<label for="nossaposicao_texto">Prioridade:</label>
	</div>

	<div class="input-field col s12 m6 l6">
		<?php
			$options = array(
				'completoPDF' => 'PDF Completo',
				'resumoPDF' => 'Resumo no PDF',
				'completoExcel' => 'Excel Completo',
				'resumoExcel' => 'Resumo no Excel',
				'agp' => 'Acompanhamento Geral de Projetos',
			);
			echo $this->Form->input('type' ,  array(
						'label' => false,
						'div' => false,
						'type' => 'select',
						'class' => 'validate',
						'options' => $options,
					));
		?>
		<label for="tipo_texto">Tipo de Relatório:</label>
	</div>


		<a  href="javascript: void(0);" class="btn waves-effect waves-light green darken-3 right margin-left-15 gerarPdf margTop40">
			<i class="material-icons left">done</i>Gerar Relatório
		</a>
		<input type="hidden" name="urlGerarRelatorio" id="urlGerarRelatorio" value="<?php echo $this->Html->url(array('controller' => 'Relatorios', 'action' => 'admin_gerarRelatorio'))?>">
		<?php echo $this->Form->end();?>

</div>



 <!-- Modal Structure -->
<div id="modalRelatorioGerado" class="modal">
    <div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
    <div class="modal-content">
		<h4>Relatório gerado com sucesso.</h4>
		<br>
		<br>
		<a href="#" class="waves-effect waves-light btn green darken-3 baixarArquivo"  target="_blank">
			<i class="material-icons left">file_download</i>Baixar Arquivo
		</a>
		<a href="#" class="waves-effect waves-light btn green darken-3 right enviarEmail" data-position='bottom' data-delay='50' data-tooltip="O e-mail será enviado a todos os usuários.">
			<i class="material-icons left">send</i>Enviar por E-mail
		</a>
		<?php echo $this->Form->create('enviarEmail', array('id' => 'enviarRelatorioEmail'));?>
			<?php
				echo $this->Form->input('enviarRelatorioEmail', array(
						'type' => 'hidden',
						'id'	=> 'enviarRelatorioEmail',
						'value'	=> $this->Html->url(array('controller' => 'Relatorios', 'action' => 'admin_enviarRelatorioEmail'))
					));
				echo $this->Form->input('enviarLinkPdf', array(
						'type' => 'hidden',
						'id'	=> 'enviarLinkPdf',
					));
			?>
		<?php echo $this->Form->end();?>
    </div>
</div>

<div id="modalEmailEnviado" class="modal">
    <div class="modal-footer">
    	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
	<div class="modal-content">
		<h4>E-mail enviado com sucesso!</h4>
		<p>Seu E-mail foi enviado para todos os usuários cadastrados.</p>
	</div>
</div>

<div id="modalGerandoRelatorio" class="modal">
    <div class="modal-footer">
    	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
	<div class="modal-content content-gerando">
		<h4>Gerando Relatório

		<div class="preloader-wrapper big active col m12 right valign">
		    <div class="spinner-layer spinner-green-only">
				<div class="circle-clipper right">
					<div class="circle"></div>
				</div>
		    </div>
		</div>
		</h4>
	</div>
</div>

<div id="modalRelatorioVazio" class="modal">
    <div class="modal-footer">
    	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
	<div class="modal-content">
		<h4>Relatório vazio.</h4>
		<p>Nenhuma Proposição encontrada. Verifique os dados do filtro.</p>
	</div>
</div>


<?php
	////////////////////////////////////////////////////////////////////////////////////////
	// >>> Listando usuario que receberão o email de atualização
?>
	<div id="modalEnviarAtualizacaoEmail" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4>Enviar Atualização por E-mail</h4>
			<p class="padding-top-20">Selecione os usuários que serão notifícados por e-mail sobre esta atualização.</p>
				<?php echo $this->Form->create('UsuariosEmail', array('id' => 'atualizacaoPorEmail')); ?>
					<div class="col m12 padding-top-20">
						<?php
							echo $this->Form->input('usuarios', array(
									'label'		=> false,
									'type' 		=> 'select',
									'multiple' 	=> 'checkbox',
									'options' 	=> $usuariosLista,
									'name'		=> 'enviarParaUsuarios'
								))
						?>
					</div>
				<?php echo $this->Form->end(); ?>
		</div>
		<div class="modal-footer">
			<a class="modal-action modal-close waves-effect waves-light red darken-3 btn left hide-on-small-only" href="javascript:void(0)">
				<i class="mdi-navigation-close left"></i>
				Cancelar
			</a>
			<a class="modal-action modal-close waves-effect waves-light red darken-3 btn hide-on-med-and-up" href="javascript:void(0)">
				<i class="mdi-navigation-close left"></i>
				Cancelar
			</a>

			<a href="#" class="waves-effect waves-light btn green darken-3 enviarRelatorioEmail" data-position='bottom' data-delay='50' data-tooltip="O e-mail será enviado a todos os usuários.">
				<i class="material-icons left">send</i>Enviar por E-mail
			</a>
		</div>
	</div>
<?php
	// <<< Listando usuario que receberão o email de atualização
	////////////////////////////////////////////////////////////////////////////////////////
?>

<?php
	////////////////////////////////////////////////////////////////////////////////////////
	// >>> JUSTIFICATIVA
?>
	<div id="modaljustificativa" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h4>Informe a justificativa</h4>
			<?=$this->Form->create('Relatorio', array('id' => 'justificativaForm', 'class' => 'formBlock'));?>

				<?php
					echo $this->Form->input('justificativaEncerado', array(
						'type'	=> 'textarea',
						'id' => 'justificativa_txt',
						'class' => 'input-padrao sem-editor',
						'placeholder' => 'Digite aqui a justificativa',
						'label' => false
					));
				?>
			<?php echo $this->Form->end();?>
		</div>
		<div class="modal-footer">
			<div class="preloader-wrapper small right active hide">
				<div class="spinner-layer spinner-blue-only">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
			<a href="#!" class="modal-action waves-effect waves-light btn right green darken-3 form save-justifica"><i class="material-icons left">autorenew</i>Atualizar</a>
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat cancelar-justificativa">Cancelar</a>
		</div>
	</div>
<?php
	// <<< JUSTIFICATIVA
	////////////////////////////////////////////////////////////////////////////////////////
?>
