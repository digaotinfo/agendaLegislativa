<?php
$this->start('script');
	echo $this->Html->script(array(
		'../assets/uploadAjax/jquery.uploadfile.min.js',
	));
	echo $this->Html->script('jquery.autocomplete.min.js');
	echo $this->Html->script('currency-autocomplete.js');
	echo $this->Html->script('zoio.js');
	?>
	<script>
		$(document).ready(function(){
			$('.modal-trigger').leanModal();
			// // >>> UPLOAD NOTAS TECNICAS
			// var elementoNotasTecnicas = $(".mulitplefileuploader-notas-tecnicas");
			// var uploadObjNotasTecnicas = elementoNotasTecnicas.uploadFile({
			// 	url: webroot+"assets/uploadAjax/upload.php",
			// 	multiple:false,
			// 	dragDrop:false,
			// 	maxFileCount:1,
			// 	fileName: "myfile",
			// 	allowedTypes:"jpg,png,gif,doc,pdf,zip,xls,xlsx,doc,docx,ppt",
			// 	returnType:"json",
			// 	showFileCounter:false,
			// 	dragDropStr: "<span><b>Arraste e solte o arquivo aqui</b></span>",
			// 	abortStr:"abortar",
			// 	cancelStr:"cancelar",
			// 	doneStr:"feito",
			// 	multiDragErrorStr: "Não foi possível subir estes arquivos.",
			// 	extErrorStr:"Não autorizado. Veja as extensões possíveis: ",
			// 	sizeErrorStr:"Arquivo muito pesado. O máximo permitido é: ",
			// 	uploadErrorStr:"Erro ao efetuar o upload",
			// 	uploadStr:"Anexar arquivo",
			// 	onSuccess:function(files,data,xhr,pd){
			// 		$('.arquivo_notas_tecnicas').val(data[0]);
			// 		$('.arquivoatual').remove();// <<<	REMOVE DIV DO TITULO DO ARQUIVO
			//
			// 	},
			// 	showDelete:true,
			// 	deleteCallback: function(data,pd){
			// 		for(var i=0;i<data.length;i++){
			// 			$.post(webroot+"assets/uploadAjax/delete.php",{op:"delete",name:data[i]},
			// 			function(resp, textStatus, jqXHR){
			// 				//Show Message
			// 				$(".status").append("<div>Arquivo Deletado</div>");
			// 			});
			// 		}
			// 		pd.statusbar.hide(); //You choice to hide/not.
			// 		$('.arquivo_notas_tecnicas').val('');
			// 	}
			// });
			// // <<< UPLOAD NOTAS TECNICAS


			// >>> UPLOAD DOS BLOCKS
		    $(".section").each(function(i, j){
				//do something with the element here.
				var idNameModel = $(this).attr('id');
				var elemento = $(".mulitplefileuploader-"+idNameModel.toLowerCase());

				var uploadObj = elemento.uploadFile({
			        url: webroot+"assets/uploadAjax/upload.php",
					multiple:false,
					dragDrop:false,
					maxFileCount:1,
			        fileName: "myfile",
			        allowedTypes:"jpg,png,gif,doc,pdf,zip,xls,xlsx,doc,docx,ppt",
			        returnType:"json",
					showFileCounter:false,
					dragDropStr: "<span><b>Arraste e solte o arquivo aqui</b></span>",
				    abortStr:"abortar",
					cancelStr:"cancelar",
					doneStr:"feito",
					multiDragErrorStr: "Não foi possível subir estes arquivos.",
					extErrorStr:"Não autorizado. Veja as extensões possíveis: ",
					sizeErrorStr:"Arquivo muito pesado. O máximo permitido é: ",
					uploadErrorStr:"Erro ao efetuar o upload",
					uploadStr:"Anexar arquivo",
			    	onSuccess:function(files,data,xhr,pd){
						$('.arquivo_'+idNameModel).val(data[0]);

			        },
			        showDelete:true,
			        deleteCallback: function(data,pd){
			            for(var i=0;i<data.length;i++){
			                $.post(webroot+"assets/uploadAjax/delete.php",{op:"delete",name:data[i]},
			                function(resp, textStatus, jqXHR){
			                    //Show Message
			                    $(".status").append("<div>Arquivo Deletado</div>");
			                });
			            }
			            pd.statusbar.hide(); //You choice to hide/not.
						$('.arquivo_'+idNameModel).val('');
			        }
			    });
			});
			// <<< UPLOAD DOS BLOCKS



			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			//+++++++ Tipo de Proposicao +++++++++++++++++++++++++++++++++//
			$('#selectTipo').change(function(){
				var valor = $('#selectTipo').val();
				// if( (valor == 1) || (valor == 3) ){
					$.ajax({
						type: "POST",
						url: "<?=$this->Html->url(array(
													'controller' => 'Fluxogramas',
													'action' => 'verificarEtapasDesteTipo',
													'admin' => 'true',
												))?>/"+ (valor),
						dataType: 'json',
						success: function(data){
							console.log(data);
							if (data != '') {
								$('.fluxograma').removeClass('hide');

								var selectDropdown = $("#selectEtapa");
								selectDropdown.empty();
								selectDropdown.html(' ');

								selectDropdown.append($("<option value='0'>Selecione a Etapa</option>"));
								selectDropdown.material_select();

								$('.select-fluxograma > span.caret').remove();
								$.each(data, function(index, value){
									selectDropdown.append($("<option>",{
										value: value['FluxogramaEtapa']['id'],
										text: value['FluxogramaEtapa']['etapa']
									}));
								});
								selectDropdown.material_select();
								$('.select-fluxograma > span.caret').remove();
							}else{
									$('.fluxograma').addClass('hide');
									$('#selectEtapa').val(0);
									$('#selectEtapa').material_select();
									$('.select-fluxograma > span.caret').remove();
							}
						},
						error: function(data){
							console.log('deu erro');
							console.log(data);
						},
					});





				// }else{
				// 	$('.fluxograma').addClass('hide');
				// 	$('#selectEtapa').val(0);
				// 	$('#selectEtapa').material_select();
				// 	$('.select-fluxograma > span.caret').remove();
				// }
			});




			// SETTAR SUBETAPAS >>>
			$('#selectEtapa').change(function(){
				var valorEtapaID = $('#selectEtapa').val();
				var selectDropdownSub = $("#selectSubEtapa");
				selectDropdownSub.empty();
				selectDropdownSub.html(' ');

				selectDropdownSub.append($("<option value='0'>Selecione a Sub-Etapa</option>"));
				selectDropdownSub.material_select();
				$('.select-fluxogramaSubEtapa > span.caret').remove();
				$.ajax({
					type: "POST",
					url: "<?=$this->Html->url(array(
												'controller' => 'Fluxogramas',
												'action' => 'verificarSubEtapasDesteTipo',
												'admin' => 'true',
											))?>/"+ (valorEtapaID),
					dataType: 'json',
					success: function(subData){
						var selectDropdownSub = $("#selectSubEtapa");

						selectDropdownSub.empty();
						selectDropdownSub.html(' ');

						selectDropdownSub.append($("<option value='0'>Selecione a Sub-Etapa</option>"));
						selectDropdownSub.material_select();
						$('.select-fluxogramaSubEtapa > span.caret').remove();
						if (subData != '') {
							$.each(subData, function(index, subEtapa){
								selectDropdownSub.append($("<option>",{
									value: subEtapa['FluxogramaSubEtapa']['id'],
									text: subEtapa['FluxogramaSubEtapa']['subetapa']
								}));
							});
							selectDropdownSub.material_select();
							$('.select-fluxogramaSubEtapa > span.caret').remove();

							$('.select-fluxogramaSubEtapa').removeClass('hide');
						}else{
							$('.select-fluxogramaSubEtapa').addClass('hide');
						}
					},
					error: function(subData){
						console.log('deu erro');
						console.log(data);
					},
				});
			});
			// <<< SETTAR SUBETAPAS


			//+++++++ Tipo de Proposicao +++++++++++++++++++++++++++++++++//
			//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//


			//+++++++ JUSTIFICATIVA ++++++++++++++++++++++++++++++++++++++//
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

			// >>> VERIFICAR EXIGENCIA DE JUSTIFICATIVA
			$('#status_type_id').change(function(){
				var valor = $('#status_type_id').val();

				$.ajax({
                    type: "POST",
                    url: "<?=$this->Html->url(array(
												'controller' => 'statusTypes',
												'action' => 'verificaexigencia',
												'admin' => 'true',
											))?>/"+ (valor),
                    dataType: 'json',
                    success: function(data){
                        // console.log(data);

						if (data) {
							// console.log('SIM!!!');
							$('#modaljustificativa').openModal({
								dismissible: false,
								opacity: .7,
								in_duration: 100,
								complete: function() {
									retornaStatusOriginal();
								}
							});

							$('#justificativa_txt').focus();
						}
                    },
                });
			});
			// <<< VERIFICAR EXIGENCIA DE JUSTIFICATIVA


			// >>> SALVA JUSTIFICATIVA
			$('#modaljustificativa .form.save-justificativa').click(function(){
				console.log("salvar justificativa");

		        $('.save-justificativa').toggleClass('hide');
		        $('.cancelar-justificativa').toggleClass('hide');

		        $('#modaljustificativa .preloader-wrapper').toggleClass('hide');

				$('#justificativa_status_type_id').val($('#status_type_id').val());

				var formLocal = $('#modaljustificativa form');
		        // var formLocal = formLocal.attr('id');
		        var serializeArray = formLocal.serialize();

		        $.ajax({
		            type: 'POST',
		            url: '<?=$this->Html->url(array("controller" => "justificativas", "action" => "salvar_justificativa_da_pl", "admin" => true))?>',
		            data: serializeArray,
					// dataType: 'json',
		            success: function(data){
						console.log(data);

		                $('.save-justificativa').toggleClass('hide');
						$('.cancelar-justificativa').toggleClass('hide');

		                $('#modaljustificativa .preloader-wrapper').toggleClass('hide');


						var texto_digitado = $('#justificativa_txt').val().replace(/\n/g, "<br />");
						console.log(texto_digitado);
						$('#retornoJustificativaTextoDigitado .texto').html(texto_digitado);

						$('#retornoJustificativaTextoDigitado').removeClass('hide');
						$('#modaljustificativa').closeModal();

		            },
		            error: function(data){
		                console.log('error: ' +(data));
						$('.save-justificativa').toggleClass('hide');
						$('.cancelar-justificativa').toggleClass('hide');
						$('#modaljustificativa .preloader-wrapper').toggleClass('hide');
		            }
		        });

		    });
			// <<< SALVA JUSTIFICATIVA


			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//

			$(document).ready(function(){
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

			});


		});
		var status_atual = '<?=$proposicao['Pl']['status_type_id'];?>';
		function retornaStatusOriginal() {
			$('#status_type_id').val(status_atual);

			//===> Recriando o Material Select
			$('#status_type_id').material_select();

			//===> Eliminando sujeira do Materi
			$('.select-status > span.caret').remove();
		}

		function deleteNT(url) {
		    if (confirm("Tem certeza que deseja Excluir esta Nota Tecnica?")) {
				$.ajax({
			        url: url,
			        success: function(data){
						if( data == true ){
							alert("Nota Técnica Excluida com sucesso.");
							location.reload();
						}else{
							alert("Erro ao excluir Nota Técnica.");
						}
			        },
			        error: function(data){
			            console.log('error');
						console.log(data);
			        }
			    });
		    }
		    return false;
		}
	</script>
	<?php
$this->end();

$this->start('css');
	echo $this->Html->css(array(
		'../assets/uploadAjax/uploadfile.css',
	));
$this->end();
// print_r($proposicao);
// die();

?>


	<!-- HEADER DA PÁGINA -->
	<div class="row padding-top-20">
		<div class="col s12">
			 <h3 class="titulo-pagina">
				<?php
					echo $proposicao['PlType']['tipo']. ' ' .$proposicao[$model]['numero_da_pl'].'/'.$proposicao[$model]['ano'];
				?>
				<input type="hidden" name="pl_id" id='pl_id' value="<?php echo $proposicao[$model]['id']?>">
				<input type="hidden" name="enviar_pl_email" id='enviar_pl_email' value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'enviar_atualizacao_pl_por_email', 'admin' => true, $proposicao[$model]['id']));?>">
				<input type="hidden" name="enviar_pl_email_generico" id='enviar_pl_email_generico' value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'enviar_atualizacao_pl_generica_por_email', 'admin' => true, $proposicao[$model]['id']));?>">
				 <a href="javascript: void(0);"  onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
			 </h3>
		 </div>
	 </div>
	<!-- / HEADER DA PÁGINA -->





	<div class="row padding-top-20">
		<input type="hidden" name="url_edit" id='url_edit' value="<?=$this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao[$model]['id'] ))?>">
		<?=$this->Form->create($model, array('type' => 'file', 'class' => 'col s12 formulario formPL', 'onSubmit' => 'return false'));?>
			<?php
				$disabled = 'disabled';
				if ($userAdmin == 1){
					$disabled = '';
				}


			   echo $this->Form->input('pl_id' ,  array(
						   'type' => 'hidden',
						   'id' => 'pl_id',
						   'value' => $proposicao[$model]['id'],
					   ));

			?>
			<div class="row">
	   			<div class="input-field col s1">
	   				<i class="material-icons prefix add-tipoPl">add</i>
					<input type="hidden" name="url_autocomplete" id="url_autocomplete" value="<?php echo $this->Html->url(array('action' => 'autocomplete', 'admin' => true))?>">
					<input type="hidden" id="url_addTipo" name="url_addTipo" value="<?php echo $this->Html->url(array('controller' => 'plTypes', 'action' => 'add', 'admin' => true))?>">
					<input type="hidden" name="add_situacaoPl" id="add_situacaoPl" value="<?php echo $this->Html->url(array('controller' => 'plSituacaos', 'action' => 'add', 'admin' => true))?>">
					<input type="hidden" name="add_tema" id="add_tema" value="<?php echo $this->Html->url(array('controller' => 'temas', 'action' => 'add', 'admin' => true))?>">
					<input type="hidden" name="mostrarContentTextArea" id="mostrarContentTextArea" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'buscarContent', 'admin' => true, $proposicao['Pl']['id']))?>">
					<input type="hidden" name="mostrarContentTextAreaTarefa" id="mostrarContentTextAreaTarefa" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'buscarContent', 'admin' => true, $proposicao['Pl']['id']))?>">
	   			</div>
				<div class="input-field col s11">
	   				<?php
	   				    echo $this->Form->input('tipo_id' ,  array(
									'label' => false,
									'div' => false,
									'type' => 'select',
									'class' => 'validate',
									'id' => 'selectTipo',
									'options' => $tipos,
									'empty' => ' ',
									'value' => $proposicao['Pl']['tipo_id'],
									$disabled
	   						   ));
	   				?>
	   				<label for="nossaposicao_texto">Tipo:</label>
	   			</div>
				<?php if( $userAdmin == 1 ): ?>
				<div class="row fluxograma <?php if( empty($proposicao['Pl']['etapa_id']) ){ echo 'hide'; }?>">
					<div class="input-field col s12 select-fluxograma">
						<?php
							echo $this->Form->input('etapa_id' ,  array(
										'label' 	=> false,
										'div' 		=> false,
										'id' 		=> 'selectEtapa',
										'type' 		=> 'select',
										'class' 	=> 'validate',
										'empty' 	=> 'Selcione a Etapa',
										'options'	=> $etapas
									));
						?>
						<label for="selectEtapa">Etapa atual no Fluxograma:</label>
					</div>

					<div class="input-field col s12 select-fluxogramaSubEtapa <?php if( empty($this->request->data['Pl']['subetapa_id']) ){ echo 'hide'; }?>">
						<?php
							echo $this->Form->input('subetapa_id' ,  array(
										'label' 	=> false,
										'div' 		=> false,
										'id' 		=> 'selectSubEtapa',
										'type' 		=> 'select',
										'class' 	=> 'validate',
										'empty' 	=> 'Selcione a Sub-Etapa',
										'options'	=> $subEtapas
									));
						?>
						<label for="selectEtapa">Sub-Etapa atual no Fluxograma:</label>
					</div>
				</div>
				<?php endif; ?>
				<div class="input-field col s1">
					<i class="material-icons prefix add-tema">add</i>
				</div>
				<div class="input-field col s11">
					<?php
					   echo $this->Form->input('tema_id' ,  array(
								   'label' => false,
								   'div' => false,
								   'type' => 'select',
								   'class' => 'validate',
								   'id' => 'selectTema',
								   'options' => $temas,
								   'empty' => ' ',
								   $disabled
							   ));
					?>
					<label for="nossaposicao_texto">Tema:</label>
				</div>
	   			<div class="input-field col s6">
	   				<?php
	                       echo $this->Form->input('numero_da_pl', array(
	                           'label' => false,
	                           'id'    => 'numero_da_pl',
	                           'class' => 'validate',
	                           'div' => false,
							   $disabled
	                       ));
	                   ?>
	    				<label for="numero_pl">Número</label>
	   			</div>
	   			<div class="input-field col s6">
	   				<?php
	                       echo $this->Form->input('ano', array(
	                           'label' => false,
	                           'id'    => 'ano_pl',
	                           'class' => 'validate',
	                           'div' => false,
							   $disabled
	                       ));
	                   ?>
	    				<label for="ano_pl">Ano</label>
	   			</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('link_da_pl' ,  array(
								'div' => false,
								'id' => 'link_pl',
								'class' => 'validate',
								'label' => false,
								$disabled
							));
					?>
					<label for="link_pl">Link</label>
				</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('apensados_da_pl' ,  array(
								'div' => false,
								'id' => 'apensados_da_pl',
								'class' => 'validate',
								'label' => false,
								$disabled
							));
					?>
					<label for="apensados_da_pl">Projetos Apensados</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('Autor.nome' ,  array(
								'type' => 'text',
								'div' => false,
								'id' => 'autor_nome',
								'class' => 'validate autocomplete',
								'label' => false,
								$disabled
							));
					?>
					<label for="autor_nome">Autor(a):</label>
				</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('Relator.nome' ,  array(
								'type' => 'text',
								'div' => false,
								'id' => 'relator_nome',
								'class' => 'validate autocomplete',
								'label' => false,
								$disabled
							));
					?>
					<label for="relator_nome">Relator(a):</label>
				</div>

				<div class="row">
		            <div class="input-field col s6 select-status">
		                <?php
		                    echo $this->Form->input('status_type_id' ,  array(
		                                'label' => false,
		                                'div' => false,
										'id' => 'status_type_id',
		                                'type' => 'select',
		                                'class' => 'validate',
		                                'options' => $nossaPosicao,
		                                $disabled
		                            ));
		                ?>
		                <label for="nossaposicao_texto">Status:</label>
		            </div>
		            <div class="input-field col s6 right">
		                <div class="row">
		                    <div class="input-field col s6 m6 l6 center">
		                        <div class="">Prioridade</div>
		                    </div>
		                    <div class="input-field col s6 flag-prioridade right">
		                        <div class="switch center-align">
		                            <label>
		                                Não
		                                <?php
		                                    echo $this->Form->input('prioridade', array(
		                                        'type' => 'checkbox',
		                                        'label' => false,
		                                        'div' => false,
		                                        $disabled
		                                    ));
		                                ?>
		                                <span class="lever"></span>
		                                Sim
		                            </label>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>




				<div class="row <?php
								if (!empty($dados['LogAtualizacaoPl'])) {
									echo 'hide';
								}?>" id="retornoJustificativaTextoDigitado">
					<div class="col s12">
						<h5>
							<span class="black-text">
								Justificativa:
							</span>
						</h5>
						<div class="texto">
						</div>
						<?php
						$dados = $proposicao;
						if (!empty($dados['LogAtualizacaoPl'])) {
							foreach ($dados['LogAtualizacaoPl'] as $logAtualizacao) {
								if ($logAtualizacao['nome_da_model'] == 'Justificativa') {
									?>
									<div class="atualizacao-feita ">
										<small class="atualizacao-realizada">
											<span>
												atualizado por:
												<?php echo $logAtualizacao['usuario_nome']; ?>
												em <strong id="dataHoraAtualizado"><?php echo CakeTime::format($logAtualizacao['modified'], '%d/%m/%Y às %H:%m');?></strong>

											</span>
										</small>
										<strong class="dataHoraAtualizado">
											<p class="text">
												<?=$logAtualizacao['txt']?>
											</p>
										</strong>

									</div>
									<?php
								}
							}
						}
						?>
						<hr>
					</div>
				</div>


				<div class="row">
		            <div class="col s12" id='notas_tecnicas'>
		                Notas Técnicas
						<a href="<?=$this->Html->url(array('controller' => 'notasTecnicas' , 'action' => 'add', 'admin' => true, $proposicao['Pl']['id']))?>" class="green-text textd-darken-3 tooltipped btn-edit" data-position="bottom" data-delay="50" data-tooltip="Editar esta Nota Tecnica">
							<i class="material-icons prefix ">note_add</i>
						</a>
							<br>
		                    <?php
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    //>>> UPLOAD
		                    ?>
		                        <!-- <div class="mulitplefileuploader-notas-tecnicas" data-return='arquivo_notas_tecnicas'>Upload</div> -->
								<?php
									if(!empty($proposicao['NotasTecnica'])):
										foreach($proposicao['NotasTecnica'] as $nota){
											if(!empty($nota['arquivo']) ):
									?>
											<br>

											<a href="javascript:void(0);" onclick='deleteNT("<?=$this->Html->url(array('controller' => 'pls' , 'action' => 'deleteNT', 'admin' => true,$nota['id'] , $proposicao['Pl']['id']))?>")' class="btn-floating red  right" data-position="bottom" data-delay="50" data-tooltip="Excluir esta Nota Tecnica">
												<i class="material-icons prefix ">delete</i>
											</a>
											<?php
												// echo $this->Form->postLink(
												// '<i class="material-icons">delete</i>',
												// array(
												// 	'controller' => 'Pls',
												// 	'action' => 'admin_deleteNT',
												// 	$nota['id'],
												// 	$proposicao['Pl']['id']
												// ),
												// array(
												// 	'confirm' => 'Tem certeza que deseja excluir esta Nota Tecnica?',
												// 	'class' => 'btn-floating red  right',
												// 	'data-position' => 'bottom',
												// 	'data-delay' => 50,
												// 	'data-tooltip' => "Apagar Nota Tecnica",
												// 	'escape'=>false
												// ));
											?>
												<div class="arquivoatual">

													<a href="<?=$this->Html->url(array('controller' => 'notasTecnicas' , 'action' => 'edit', 'admin' => true, $nota['id']))?>" class="green-text textd-darken-3 tooltipped btn-edit" data-position="bottom" data-delay="50" data-tooltip="Editar esta Nota Tecnica">
														<i class="material-icons prefix ">mode_edit</i>
													</a>
													<a href="<?php echo Router::url('/'.$nota['dir'].'/'.$nota['arquivo'], true);?>" target="_blank">
														<?php
															echo $nota['arquivo'];
														?>
													</a>
												</div>
												<hr>
								<?php
											endif;
										}
									endif;
								?>
		                    <?php
		                        // echo $this->Form->input('arquivo', array(
		                        //     'type' => 'hidden',
		                        //     'class' => 'arquivo_notas_tecnicas',
		                        // ));
			                ?>
		                    <?php
		                    //<<< UPLOAD
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    ?>
		            </div>
		        </div>


				<div class="row hide">
		            <div class="input-field col s12">
		                Notas Técnicas
		                    <?php
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    //>>> UPLOAD
		                    ?>
		                        <div class="mulitplefileuploader-notas-tecnicas" data-return='arquivo_notas_tecnicas'>Upload</div>
								<?php if(!empty($proposicao['Pl']['arquivo'])): ?>
									<div class="arquivoatual">
										<a href="<?php echo Router::url('/'.$proposicao['Pl']['arquivo'], true);?>" target="_blank">
											<?php
												$nameFile = strrchr($proposicao['Pl']['arquivo'], '/');
												echo substr($nameFile, 1);
											?>
										</a>
									</div>
								<?php endif; ?>
		                    <?php
		                        echo $this->Form->input('arquivo', array(
		                            'type' => 'hidden',
		                            'class' => 'arquivo_notas_tecnicas',
		                        ));
			                ?>
		                    <?php
		                    //<<< UPLOAD
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    ?>
		            </div>
		        </div>



			</div>



			<div class="row">
				<div class="input-field col s12">
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

					<?php if ($userAdmin == 1){ ?>
						<a class="modal-trigger btn waves-effect waves-light red darken-3 margin-left-15 delete" href="#modalDeletePl">
							<i class="material-icons left">delete</i>
							Deletar
						</a>
						<button class="btn waves-effect waves-light green darken-3 right margin-left-15 save" type="submit" name="action">
							<i class="material-icons left">done</i>
							Salvar
						</button>
					<?php } ?>
				</div>
			</div>



		<?=$this->Form->end();?>
	</div>

	<div class="divider with-collapsible"></div>





	<!-- >>> BLOCOS -->
	<?php
	$a_models_relacionadas = array("Foco", "OqueE", "NossaPosicao", "Situacao", "Tarefa");
	$a_models_relacionadas_titulos = array("Foco", "O que é?", "Nossa posição", "Situação", "Ação ABEAR");
	$countModels = count($a_models_relacionadas);

	foreach($a_models_relacionadas as $key => $model_rel):
			?>
			<div class="section" id="<?=$model_rel?>" data-id-registro="">
				<h5>
					<span class="black-text">
						<?php echo $a_models_relacionadas_titulos[$key]; ?>
					</span>
					<?php if(!empty($proposicao[$model_rel][0])): ?>
						<small>| atualizado em <strong id="dataHora"><?php echo CakeTime::format($proposicao[$model_rel][0]['modified'], '%d/%m/%Y às %H:%M');?></strong></small>
					<?php endif; ?>

					<?php if( ($model_rel == 'Foco') || ($model_rel == 'OqueE') || ($model_rel == 'NossaPosicao') ): ?>
						<?php if ($userAdmin == 1){ ?>
							<a href="javascript: void(0);" class="green-text textd-darken-3 tooltipped right btn-edit" id="edit_<?=$model_rel;?>" data-position="bottom" data-delay="50" data-tooltip="Editar este conteúdo">
								<i class="material-icons prefix ">mode_edit</i>
							</a>
						<?php } ?>
					<?php endif; ?>
				</h5>

				<input type="hidden" name="model_rel_name" id='model_rel_name' value="<?=$model_rel;?>">

				<div class="row">

				<?php
					$contador = 0;
					foreach($proposicao[$model_rel] as $indice => $registro){
						// print_r($proposicao[$indice]['Tarefa']);
						$idTextBlock = $proposicao[$model_rel][$indice]['id'];
						if( ($model_rel == 'Foco') || ($model_rel == 'OqueE')  || ($model_rel == 'NossaPosicao') ):
							?>
							<input type="hidden" name="url_alter_data" id="url_alter_data" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_edit_block', 'admin' => true, $proposicao[$model]['id'], $model_rel,$proposicao[$model_rel][$indice]['id']) )?>">
							<div class="texto">
								<div class="atualizacao-feita blockInf">
									<small class="atualizacao-realizada">
										<?php
											if($model_rel != "Situacao"){
												?>
												<span>
													<?php if(!empty($proposicao['LogAtualizacaoPl'][0]['usuario_nome'])){?>
														atualizado por:
														<?php echo $proposicao['LogAtualizacaoPl'][0]['usuario_nome']; ?>
														em <strong id="dataHoraAtualizado"><?php echo CakeTime::format($proposicao['LogAtualizacaoPl'][0]['modified'], '%d/%m/%Y às %H:%m');?></strong>
													<?php }?>

												</span>
												<?php
											}else{
												foreach($proposicao['LogAtualizacaoPl'] as $logAtualizacao):
													if( ($model_rel == $logAtualizacao['nome_da_model']) && ($proposicao[$model_rel][$indice]['id'] == $logAtualizacao['model_id']) ){
														if(!empty($logAtualizacao['usuario_nome'])):
															?>
															<span>
																atualizado por:
																<?php echo $logAtualizacao['usuario_nome']; ?>
																em <strong id="dataHoraAtualizado"><?php echo CakeTime::format($logAtualizacao['modified'], '%d/%m/%Y às %H:%m');?></strong>

															</span>
															<?php
														endif;
													}
												endforeach;
											}
										?>
									</small>
								</div>

								<p class="text">
									<?php
										echo $proposicao[$model_rel][$indice]['txt'];
									?>
								</p>
							</div>
							<?php
						else:
							if($model_rel == 'Situacao'){

								?>
								<div class="texto">
									<div class="atualizacao-feita blockInf">
										<small class="atualizacao-realizada">
											<?php
												if($contador != 0){
													$logAtualizacao = $proposicao["LogAtualizacaoPl"][$contador-1];
													?>
													<span class="">
									                    atualizado por:
									                    <?php echo $logAtualizacao['usuario_nome']; ?>
									                        em
															<strong id="dataHoraAtualizado">
									                            <?php
									                                echo CakeTime::format($logAtualizacao['created'], '%d/%m/%Y às %H:%M');
									                            ?>
															</strong>
									                </span>
													<?php
												}
												$contador++;
											?>
										</small>
									</div>
									<p class="text">
										<?php
											echo $registro['txt'];
										?>
										<?php if(!empty($proposicao[$model_rel][$indice]['arquivo'])): ?>
											<br>
											<a href="<?php echo $this->webroot.$proposicao[$model_rel][$indice]['arquivo']?>" target="_blank" class="waves-effect waves-light btn green darken-3">
			                                    <i class="material-icons left">file_download</i>Baixar Arquivo
			                                </a>
										<?php endif;?>
									</p>
								</div>

								<?php
							}

							if( $model_rel == 'Tarefa' ){
								$class_tarefa_realizada = "tarefa-nao-realizada";
								if ($registro['realizado']) {
									$class_tarefa_realizada = "tarefa-realizada";
								}
								?>
								<div class="col s12 m12 l6">

									<div class="contentTarefaPl <?=$class_tarefa_realizada?>">
										<div class="texto tarefa_<?=$registro['id']?>" id="ver_Tarefa_<?=$registro['id']?>">
											<?php if ($userAdmin == 1){ ?>
											<a href="#editTarefa_<?=$registro['id']?>" class="green-text textd-darken-3 tooltipped right modal-trigger btn-edit-tarefa-" id="edit_<?=$model_rel?>" data-idProposicao="<?php echo $registro['id']?>" data-position="bottom" data-delay="50" data-tooltip="Editar este conteúdo">
												<i class="material-icons prefix ">mode_edit</i>
											</a>
											<?php } ?>
											<div class="atualizacao-feita blockInf">

												<!-- <small class="atualizacao-realizada"> -->
													<span>
														<i class="material-icons no-bold">date_range</i>
									                    <!-- Data de Entrega: -->
															<strong id="dataHoraAtualizado">
									                            <?php
									                                echo CakeTime::format($registro['entrega'], '%d/%m/%Y');
									                            ?>
															</strong>
															&nbsp;&nbsp;
															<?php
															$realizado = 'Realizado';
															$icone = '<i class="material-icons green-text">done</i>';
															if($registro['realizado'] == 0){
																$realizado = '<strong class="fonte-maior-tarefa">Não Realizado</strong>';
																$icone = '';
															}

															if (!empty($icone)) {
																echo $icone;
															}
															?>
															<?=$realizado;?>
									                </span>
												<!-- </small> -->
											</div>
											<p class="titulo-tarefa">
												<?php
													echo $registro['titulo'];
												?>
											</p>
											<div class="text">
												<?php
													echo $registro['descricao'];
												?>
											</div>

											<?php
												////////////////////////////////////////////////////////////////////////////////////////
												// >>> editar tarefa da pl
											?>
												<div id="editTarefa_<?=$registro['id']?>" class="modal tarefaModal">
													<div class="modal-content">
														<h4 class="center"><?php echo $proposicao['PlType']['tipo']. ' ' .$proposicao[$model]['numero_da_pl'].'/'.$proposicao[$model]['ano']; ?></h4>

														<?=$this->Form->create('Tarefa', array('class' => 'formBlock'));?>
															<?php
																echo $this->Form->input('pl_id', array(
																	'type' => 'hidden',
																	'id' => 'tarefaPlId'
																));
															?>

															<div class="input-field col s6">
																<?php
																	echo $this->Form->input('Tarefa.titulo', array(
																		'type' => 'text',
																		'id'	=> 'tarefa_titulo_'.$registro['id'],
																		'div' => false,
																		'label' => false,
																		'value' => $registro['titulo']
																	));
																?>
																<label for="tarefa_titulo">Tarefa</label>
															</div>
															<?php
																echo $this->Form->input('Tarefa.descricao', array(
																	'type' => 'textarea',
																	'id' => 'tarefaEditDescricao_'.$registro['id'],
																	'class' => 'input-padrao',
																	'label' => false,
																	'value' => $registro['descricao']
																));
															?>
															<div class="input-field col m12">
																<?php
																$dia = CakeTime::format( 'd', $registro['entrega']);
																$mes = CakeTime::format( 'F', $registro['entrega']);
																$ano = CakeTime::format( 'Y', $registro['entrega']);

																echo $this->Form->input('Tarefa.entrega' ,  array(
																			'id' 	=> 'tarefa_dataEntrega_'.$registro['id'],
																			'label' => false,
																			'div' => false,
																			'type' => 'text',
																			'class' => 'validate datepicker',
																			'value' => $dia.' '.$meses[$mes].', '.$ano
																		));
																?>
																<label for="tarefa_dataEntrega">Data de Entrega</label>
															</div>
															<div class="col m12">
																<p>
																	<?php
																		$options = array(
																			'0' => 'Pendente',
																			'1' => 'Realizada'
																		);
																		echo $this->Form->input('realizado', array(
																			'type'=>'radio',
																			'options' => $options,
																			'div' => false,
																			'id' => 'tarefal_realizada_'.$registro['id'],
																			'class' => 'tarefa_realizadaClass_'.$registro['id'],
																			'default' => $registro['realizado']
																		));
																	 ?>
																</p>
															</div>

														<?php echo $this->Form->end();?>

													</div>
														<div class="modal-footer">
															<a href="#!"
																class="form btnEditTarefa modal-action waves-effect waves-green btn-flat"
																data-tarefaId="<?=$registro['id']?>"
																data-proposicaoID="<?=$proposicao[$model]['id']?>?>"
																data-urlEditTarefa="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_edit_tarefa', 'admin' => true, $registro['id'] ) );?>"
																data-nameBlock="Ação ABEAR"
																data-nameModel="<?=$model_rel?>"  >Editar</a>
														<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
													</div>
												</div>
											<?php
												// <<< editar tarefa da pl
												////////////////////////////////////////////////////////////////////////////////////////
											?>

										</div>
										<hr>
									</div>

								</div>
								<?php
							}
						endif;
					?>
				<?php } ?>

				</div>

				<?php if( ($model_rel == 'Foco') || ($model_rel == 'OqueE') || ($model_rel == 'NossaPosicao') ): ?>
					<div class="row edit-text hide">
						<div class="input-field col s12">
							<?=$this->Form->create($model_rel, array('enctype' => 'multipart/form-data', 'type' => 'file', 'class' => 'formBlock'));?>
								<?php
									echo $this->Form->input($model_rel.'.txt', array(
										'id' => strtolower($model_rel).'_texto',
										'class' => 'materialize-textarea',
										'label' => false,
										'value' => $proposicao[$model_rel][0]['txt']
									));

									echo $this->Form->input('name_block', array(
											'type'	=> 'hidden',
											'value'	=> $a_models_relacionadas_titulos[$key]
										));
								?>

							<?=$this->Form->end();?>
							<p class="no-padding-right">
								<a href="javascript: void(0);" class="waves-effect waves-light btn right green darken-3 form save" id="form_<?=$model_rel?>" onclick="Materialize.toast('<span>Notificar por E-mail</span><a class=&quot;btn-flat yellow-text enviarEmail-sim&quot; href=&quot;#!&quot;>Sim<a><a class=&quot;btn-flat yellow-text enviarEmail-nao&quot; href=&quot;#!&quot;>Não<a>', 5000)" data-nameBlock="<?php echo $a_models_relacionadas_titulos[$key]; ?>">
									<i class="material-icons left">autorenew</i>Atualizar
								</a>
							</p>
						</div>
					</div>
				<?php
					endif;
				?>
			</div>
			<?php if ($userAdmin == 1){ ?>
				<?php if( ($model_rel == 'Situacao') ): ?>
					<ul class="collapsible" data-collapsible="accordion" id="collapsible">
						<li>
							<div class="collapsible-header grey lighten-2"><i class="material-icons">add</i>Acrescentar atualização</div>
							<div class="collapsible-body input-padrao">
								<?=$this->Form->create($model_rel, array('enctype' => 'multipart/form-data', 'type' => 'file', 'class' => 'formBlock'));?>
									<input type="hidden" name="url_alter_data" id="url_alter_data" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_edit_block', 'admin' => true, $proposicao[$model]['id'] ) );?>">
									<?php
										echo $this->Form->input('arquivo', array(
											'type' => 'hidden',
											'class' => 'arquivo_'.$model_rel,
										));
									?>
									<?php
										echo $this->Form->input($model_rel. '.txt', array(
											'id' => strtolower($model_rel).'_texto',
											'class' => 'input-padrao',
											'placeholder' => 'Digite aqui a atualização',
											'label' => false
										));
										echo $this->Form->input('name_block', array(
											'type'	=> 'hidden',
											'value'	=> $a_models_relacionadas_titulos[$key]
										));
									?>
								<?php echo $this->Form->end();?>

								<div class="row">
									<br><br>
									<div class="col-s6 columns">
										<?php
										//////////////////////////////////////////////////////////////////////
										//////////////////////////////////////////////////////////////////////
										//>>> UPLOAD
										?>
											<div class="mulitplefileuploader-<?php echo strtolower($model_rel);?>" data-return='arquivo_<?=$model_rel?>'>Upload</div>
										<?php
										//<<< UPLOAD
										//////////////////////////////////////////////////////////////////////
										//////////////////////////////////////////////////////////////////////
										?>
									</div>
								</div>

								<p class="no-padding-right">
									<a href="javascript: void(0);" class="waves-effect waves-light btn right green darken-3 form save" id="form_<?=$model_rel?>" onclick="Materialize.toast('<span>Notificar por E-mail</span><a class=&quot;btn-flat yellow-text enviarEmail-sim&quot; href=&quot;#!&quot;>Sim<a><a class=&quot;btn-flat yellow-text enviarEmail-nao&quot; href=&quot;#!&quot;>Não<a>', 5000, 'rounded')" data-nameBlock="<?php echo $a_models_relacionadas_titulos[$key]; ?>">
										<i class="material-icons left">autorenew</i>Atualizar
									</a>
								</p>
							</div>
						</li>
					</ul>
				<?php
					else:
						if( ($model_rel == 'Tarefa') ){
							?>
							<ul class="collapsible" data-collapsible="accordion" id="collapsible">
								<li>
									<div class="collapsible-header grey lighten-2"><i class="material-icons">add</i>Acrescentar Ação ABEAR</div>
									<div class="collapsible-body input-padrao">
										<?=$this->Form->create($model_rel, array('enctype' => 'multipart/form-data', 'type' => 'file', 'class' => 'formBlock'));?>
											<input type="hidden" name="url_alter_data" id="url_alter_data" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_add_tarefa', 'admin' => true, $proposicao[$model]['id'] ) );?>">
											<?php
												echo $this->Form->input($model_rel. '.titulo', array(
													'id' => strtolower($model_rel).'_tituloNew',
													'class' => 'input-padrao_',
													'placeholder' => 'Digite aqui o titulo da Tarefa',
													'label' => false
												));
												echo '<br>Descrição';
												echo $this->Form->input($model_rel. '.descricao', array(
													'type' => 'textarea',
													'id' => strtolower($model_rel).'_textoNew',
													'class' => 'input-padrao',
													'label' => false
												));
												echo $this->Form->input('name_block', array(
													'type'	=> 'hidden',
													'value'	=> $a_models_relacionadas_titulos[$key]
												));
											?>

											<br>

											<div class="row">
												<div class="input-field col s12">
													<?php
													   echo $this->Form->input('entrega' ,  array(
																   'label' => false,
																   'div' => false,
																   'id' => strtolower($model_rel).'_entregaNew',
																   'type' => 'text',
																   'class' => 'validate datepicker',
															   ));
													?>
													<label for="nossaposicao_texto">Data de Entrega</label>
												</div>
											</div>
										<?php echo $this->Form->end();?>

										<p class="no-padding-right">
											<a href="javascript: void(0);" class="waves-effect waves-light btn right green darken-3 form save-tarefa" id="form_<?=$model_rel?>"
												data-nameBlock="<?php echo $a_models_relacionadas_titulos[$key]; ?>"
												data-idDaTarefa="<?php if(!empty($registro['Tarefa'])){echo $registro['Tarefa']['id'];}?>"
												data-urlPl="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_add_tarefa', 'admin' => true, $proposicao[$model]['id'] ) );?>"
												data-nameModel="<?=$model_rel?>">
												<i class="material-icons left">autorenew</i>
												Atualizar
											</a>
										</p>
									</div>
								</li>
							</ul>

							<?php
						}
					endif;
				?>
			<?php } ?>
			<div class="divider"></div>
		<!-- <<< BLOCOS -->
		<?php
	endforeach;
	?>










	<!-- Modal Structure -->
	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> Proposição alterada com sucesso
	?>
		<div id="modalPlAlteradaSucesso" class="modal">
			<div class="modal-footer">
				<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
			</div>
			<div class="modal-content">
				<h4>
					Proposição
					<span class="right">
						<i class="medium material-icons green-text text-darken-3">thumb_up</i>
					</span>
				</h4>
				<h5 class="padding-top-20">
					Proposição alterada com sucesso.
				</h5>
			</div>
		</div>
	<?php
		// <<< Proposição alterada com sucesso
		////////////////////////////////////////////////////////////////////////////////////////
	?>






	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> Erro na alteração da proposção
	?>
		<div id="modalPlAlteradaErro" class="modal">
			<div class="modal-footer">
				<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
			</div>
			<div class="modal-content">
				<h4>
					Proposição
					<span class="right">
						<i class="medium material-icons red-text text-darken-3">thumb_down</i>
					</span>
				</h4>
				<h5 class="padding-top-20">
					Erro ao alterar Proposição. Tente novamente mais tarde.
				</h5>
			</div>
		</div>
	<?php
		// <<< Erro na alteração da proposção
		////////////////////////////////////////////////////////////////////////////////////////
	?>






	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> Enviando E-mail
	?>
	    <div id="modalEmailEnviando" class="modal">
		    <div class="modal-content">
				<h4>Envio de Email</h4>
				<p>Aguarde, seu e-mail esta sendo enviado.</p>
		    </div>
	    </div>
	<?php
		// <<< Enviando E-mail
		////////////////////////////////////////////////////////////////////////////////////////
	?>







	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> E-mail Enviado com Sucesso
	?>
	    <div id="modalEmailEnviado" class="modal">
		    <div class="modal-footer">
		    	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
		    </div>
	    	<div class="modal-content">
				<h4>
					Envio de Email
					<i class="medium material-icons green-text text-darken-3 right">done_all</i>
				</h4>
				<p>Seu E-mail foi enviado com sucesso.</p>
	    	</div>
	  	</div>
	<?php
		// <<< E-mail Enviado com Sucesso
		////////////////////////////////////////////////////////////////////////////////////////
	?>







	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> Erro ao enviar E-mail
	?>
	    <div id="modalEmailErroNoEnvio" class="modal">
		    <div class="modal-footer">
		    	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
		    </div>
	    	<div class="modal-content">
				<h4>
					Envio de Email
					<i class="medium material-icons red-text text-darken-3 right">thumb_down</i>
				</h4>
				<p>Desculpe, seu E-mail não pode ser enviado.<br>Tente novamente mais tarde.</p>
	    	</div>
		</div>
	<?php
		// <<< Erro ao enviar E-mail
		////////////////////////////////////////////////////////////////////////////////////////
	?>







	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> Confimação de Delete Proposição
	?>
	    <div id="modalDeletePl" class="modal">
			<div class="modal-content">
				<h4>Deletar</h4>
				<p>Deseja deletar esta Proposição?</p>
		    </div>
		    <div class="modal-footer">
				<div class="row">
					<div class="col s8 offset-s2">
				    	<a href="#!" class="btn waves-effect waves-light green darken-3 left margin-left-15 deletePL" id="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'delete', 'admin' => true, $proposicao['Pl']['id']))?>">Sim</a>
				    	<a href="#!" class="btn waves-effect waves-light red darken-3 right margin-left-15 modal-close waves-effect waves-green">Não</a>
						<input type="hidden" name="list-proposicoes" id="list-proposicoes" value="<?php echo Router::url('/', true);?>">
					</div>
				</div>
		    </div>
	    </div>
	<?php
		// <<< Confimação de Delete Proposição
		////////////////////////////////////////////////////////////////////////////////////////
	?>





	<?php
		////////////////////////////////////////////////////////////////////////////////////////
		// >>> JUSTIFICATIVA
	?>
		<div id="modaljustificativa" class="modal modal-fixed-footer">
			<div class="modal-content">
				<h4>Informe a justificativa</h4>
				<?=$this->Form->create('Justificativa', array('id' => 'justificativaForm', 'class' => 'formBlock'));?>
					<?php
						echo $this->Form->input('pl_id', array(
							'type' => 'hidden',
							'default' => $proposicao[$model]['id'],
						));
						echo $this->Form->input('status_type_id', array(
							'type'	=> 'hidden',
							'id'	=> 'justificativa_status_type_id'
						));
					?>
					<?php
						echo $this->Form->input('justificativa', array(
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
				<a href="#!" class="modal-action waves-effect waves-light btn right green darken-3 form save-justificativa"><i class="material-icons left">autorenew</i>Atualizar</a>
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat cancelar-justificativa">Cancelar</a>
			</div>
		</div>
	<?php
		// <<< JUSTIFICATIVA
		////////////////////////////////////////////////////////////////////////////////////////
	?>




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

				<a href="#" class="waves-effect waves-light btn green darken-3 enviarAtualizacaoEmail" data-position='bottom' data-delay='50' data-tooltip="O e-mail será enviado a todos os usuários.">
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
		// >>> Enviar atualização por email
	?>
		<div id="modalNotificacaoPorEmail" class="modal">
			<div class="modal-content">
				<h4 class="center">Enviar Atualização por E-mail</h4>

				<br>
				<br>
				<div class="row">
					<div class="col l6 m12 s12 center btn-tarefa-enviar">
						<a class="modal-action modal-close waves-effect waves-light red darken-3 btn exit naoEnviarNotificacaoPorEmail" href="javascript:void(0)">
							<i class="mdi-navigation-close left"></i>
							Cancelar
						</a>
					</div>
					<div class="col l6 m12 s12 center btn-tarefa-enviar">
						<a href="#" class="waves-effect waves-light btn green darken-3 enviarNotificacaoPorEmail" data-position='bottom' data-delay='50' data-tooltip="Enviar E-mail." data-urlEnviarNotificacaoPorEmail="<?=$this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_tarefa_enviar_email', 'admin' => true ) )?>">
							<i class="material-icons left">send</i>Enviar por E-mail
						</a>
					</div>
				</div>
			</div>
		</div>

	<?php
		// <<< Enviar atualização por email
		////////////////////////////////////////////////////////////////////////////////////////
	?>





	<?php
		$this->start('script');
		echo $this->Html->script('../assets/tinymce/tinymce.min.js');
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				tinymce.init({
					selector: "textarea:not(.sem-editor)",
					language : 'pt_BR',
					paste_text_sticky : true,//retira a formatação
					plugins : 'link',
					menubar: false,
					formats: false,
					toolbar: "link",
					// plugins : 'advlist autolink link image lists charmap preview media code',
					relative_urls: false,
					remove_script_host: false
				});
			});
		</script>
	<?php
	$this->end();
	?>



	HISTÓRICO:
	Veja como esta proposição estava em uma data anterior:
	<?=$this->Form->create('FormScreen', array('type' => 'file', 'class' => 'col s12 formulario formPL'));?>
	<?php echo $this->Form->input('data', array(
		'class' => 'datepicker'
	)); ?>

	<?php
		echo $this->Form->button('<i class="material-icons left">done</i>Buscar' ,  array(
			'type' => 'submit',
			'div' => true,
			'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
		));
	?>

	<?php $this->end(); ?>