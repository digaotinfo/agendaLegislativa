<?php
$this->start('script');
	echo $this->Html->script(array(
		'../assets/uploadAjax/jquery.uploadfile.min.js',
	));
	echo $this->Html->script('zoio.js');
	?>
	<script>
		$(document).ready(function(){
			$('.modal-trigger').leanModal();
			// >>> UPLOAD NOTAS TECNICAS
			var elementoNotasTecnicas = $(".mulitplefileuploader-notas-tecnicas");
			var uploadObjNotasTecnicas = elementoNotasTecnicas.uploadFile({
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
					$('.arquivo_notas_tecnicas').val(data[0]);
					$('.arquivoatual').remove();// <<<	REMOVE DIV DO TITULO DO ARQUIVO

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
					$('.arquivo_notas_tecnicas').val('');
				}
			});
			// <<< UPLOAD NOTAS TECNICAS


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




		});
		var status_atual = '<?=$this->request->data['Pl']['status_type_id'];?>';
		function retornaStatusOriginal() {
			$('#status_type_id').val(status_atual);

			//===> Recriando o Material Select
			$('#status_type_id').material_select();

			//===> Eliminando sujeira do Materi
			$('.select-status > span.caret').remove();
		}

	</script>
	<?php
$this->end();

$this->start('css');
	echo $this->Html->css(array(
		'../assets/uploadAjax/uploadfile.css',
	));
$this->end();

?>


	<!-- HEADER DA PÁGINA -->
	<div class="row padding-top-20">
		<div class="col s12">
			 <h3 class="titulo-pagina">
				<?php
					echo $this->request->data['PlType']['tipo']. ' ' .$this->request->data[$model]['numero_da_pl'].'/'.$this->request->data[$model]['ano'];
				?>
				<input type="hidden" name="pl_id" id='pl_id' value="<?php echo $this->request->data[$model]['id']?>">
				<input type="hidden" name="enviar_pl_email" id='enviar_pl_email' value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'enviar_atualizacao_pl_por_email', 'admin' => true, $this->request->data[$model]['id']));?>">
				 <a href="javascript: void(0);"  onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
			 </h3>
		 </div>
	 </div>
	<!-- / HEADER DA PÁGINA -->





	<div class="row padding-top-20">
		<input type="hidden" name="url_edit" id='url_edit' value="<?=$this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $this->request->data[$model]['id'] ))?>">
		<?=$this->Form->create($model, array('type' => 'file', 'class' => 'col s12 formulario formPL', 'onSubmit' => 'return false'));?>
			<?php
				$disabled = 'disabled';
				if ($userAdmin == 1){
					$disabled = '';
				}
			?>
			<div class="row">
	   			<div class="input-field col s1">
	   				<i class="material-icons prefix add-tipoPl">add</i>
					<input type="hidden" id="url_addTipo" name="url_addTipo" value="<?php echo $this->Html->url(array('controller' => 'plTypes', 'action' => 'add', 'admin' => true))?>">
					<input type="hidden" name="add_situacaoPl" id="add_situacaoPl" value="<?php echo $this->Html->url(array('controller' => 'plSituacaos', 'action' => 'add', 'admin' => true))?>">
					<input type="hidden" name="add_tema" id="add_tema" value="<?php echo $this->Html->url(array('controller' => 'temas', 'action' => 'add', 'admin' => true))?>">
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
									'value' => $this->request->data['Pl']['tipo_id'],
									$disabled
	   						   ));
	   				?>
	   				<label for="nossaposicao_texto">Tipo:</label>
	   			</div>
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
				<div class="input-field col s12">
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
			</div>
			<div class="row">
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('autor' ,  array(
								'div' => false,
								'id' => 'autor_nome',
								'class' => 'validate',
								'label' => false,
								$disabled
							));
					?>
					<label for="autor_nome">Autor(a):</label>
				</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('relator' ,  array(
								'div' => false,
								'id' => 'relator_nome',
								'class' => 'validate',
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
						$dados = $this->request->data;
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
		            <div class="input-field col s12">
		                Notas Técnicas
		                    <?php
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    //>>> UPLOAD
		                    ?>
		                        <div class="mulitplefileuploader-notas-tecnicas" data-return='arquivo_notas_tecnicas'>Upload</div>
								<?php if(!empty($this->request->data['Pl']['arquivo'])): ?>
									<div class="arquivoatual">
										<a href="<?php echo Router::url('/'.$this->request->data['Pl']['arquivo'], true);?>" target="_blank">
											<?php
												$nameFile = strrchr($this->request->data['Pl']['arquivo'], '/');
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
	$a_models_relacionadas = array("Foco", "OqueE", "NossaPosicao", "Situacao");
	$a_models_relacionadas_titulos = array("Foco", "O que é?", "Nossa posição", "Situação");
	// $a_models_relacionadas_titulos = array("Foco", "O que é?", "Nossa posição", "Onde está? Com quem está?");
	$countModels = count($a_models_relacionadas);
	$contador = 1;
	foreach($a_models_relacionadas as $key => $model_rel):
			?>
			<div class="section" id="<?=$model_rel?>" data-id-registro="">
				<h5>
					<span class="black-text">
						<?php echo $a_models_relacionadas_titulos[$key]; ?>
					</span>
					<?php if(!empty($this->request->data[$model_rel][0])): ?>
						<small>| atualizado em <strong id="dataHora"><?php echo CakeTime::format($this->request->data[$model_rel][0]['modified'], '%d/%m/%Y às %H:%m');?></strong></small>
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

				<?php
					foreach($this->request->data[$model_rel] as $indice => $registro){
						$idTextBlock = $this->request->data[$model_rel][$indice]['id'];
						if( ($model_rel == 'Foco') || ($model_rel == 'OqueE')  || ($model_rel == 'NossaPosicao') ):
							?>
							<input type="hidden" name="url_alter_data" id="url_alter_data" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_edit_block', 'admin' => true, $this->request->data[$model]['id'], $model_rel,$this->request->data[$model_rel][$indice]['id']) )?>">
							<div class="texto">
								<div class="atualizacao-feita blockInf">
									<small class="atualizacao-realizada">
										<?php
											if($model_rel != "Situacao"){
												?>
												<span>
													<?php if(!empty($this->request->data['LogAtualizacaoPl'][0]['usuario_nome'])){?>
														atualizado por:
														<?php echo $this->request->data['LogAtualizacaoPl'][0]['usuario_nome']; ?>
														em <strong id="dataHoraAtualizado"><?php echo CakeTime::format($this->request->data['LogAtualizacaoPl'][0]['modified'], '%d/%m/%Y às %H:%m');?></strong>
													<?php }?>

												</span>
												<?php
											}else{
												foreach($this->request->data['LogAtualizacaoPl'] as $logAtualizacao):
													if( ($model_rel == $logAtualizacao['nome_da_model']) && ($this->request->data[$model_rel][$indice]['id'] == $logAtualizacao['model_id']) ){
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
										echo strip_tags($this->request->data[$model_rel][$indice]['txt']);
									?>
								</p>
							</div>
							<?php
						else:
							$this->request->data[$model_rel] = array_reverse($this->request->data[$model_rel]);
							?>
							<div class="texto">
								<div class="atualizacao-feita blockInf">
									<small class="atualizacao-realizada">
										<?php
											foreach($this->request->data['LogAtualizacaoPl'] as $logAtualizacao):
												if( ($model_rel == $logAtualizacao['nome_da_model']) && ($this->request->data[$model_rel][$indice]['id'] == $logAtualizacao['model_id']) ){

													if(!empty($logAtualizacao['usuario_nome'])):
														?>
															<span>
																atualizado por:
																<?php echo $logAtualizacao['usuario_nome']; ?>
																<?php
																	if(!empty($this->request->data[$model_rel][0])):
																	?>
																	em <strong id="dataHoraAtualizado">
																		<?php
																			// echo $logAtualizacao['modified'];
																			echo CakeTime::format($logAtualizacao['modified'], '%d/%m/%Y às %H:%m');
																		?>
																<?php endif; ?>
															</span>
														<?php
													endif;
												}
											endforeach;
											echo $contador++;
										?>
									</small>
								</div>
								<p class="text">
									<?php
										echo strip_tags($this->request->data[$model_rel][0]['txt']);
									?>
									<?php if(!empty($this->request->data[$model_rel][$indice]['arquivo'])): ?>
										<br>
										<a href="<?php echo $this->webroot.$this->request->data[$model_rel][$indice]['arquivo']?>" target="_blank" class="waves-effect waves-light btn green darken-3">
		                                    <i class="material-icons left">file_download</i>Baixar Arquivo
		                                </a>
									<?php endif;?>
								</p>
							</div>

							<?php
						endif;
					?>
				<?php } ?>

				<?php if( ($model_rel == 'Foco') || ($model_rel == 'OqueE') || ($model_rel == 'NossaPosicao') ): ?>
					<div class="row edit-text hide">
						<div class="input-field col s12">
							<?=$this->Form->create($model_rel, array('enctype' => 'multipart/form-data', 'type' => 'file', 'class' => 'formBlock'));?>
								<?php
									echo $this->Form->input($model_rel.'.txt', array(
										'id' => strtolower($model_rel).'_texto',
										'class' => 'materialize-textarea',
										'label' => false,
										'value' => strip_tags($this->request->data[$model_rel][0]['txt'])
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
				<?php endif; ?>
			</div>
			<?php if ($userAdmin == 1){ ?>
				<?php if( ($model_rel != 'Foco') && ($model_rel != 'OqueE') && ($model_rel != 'NossaPosicao') ): ?>
					<ul class="collapsible" data-collapsible="accordion" id="collapsible">
						<li>
							<div class="collapsible-header grey lighten-2"><i class="material-icons">add</i>Acrescentar atualização</div>
							<div class="collapsible-body input-padrao">
								<?=$this->Form->create($model_rel, array('enctype' => 'multipart/form-data', 'type' => 'file', 'class' => 'formBlock'));?>
									<input type="hidden" name="url_alter_data" id="url_alter_data" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_edit_block', 'admin' => true, $this->request->data[$model]['id'] ) );?>">
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
				    	<a href="#!" class="btn waves-effect waves-light green darken-3 left margin-left-15 deletePL" id="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'delete', 'admin' => true, $this->request->data['Pl']['id']))?>">Sim</a>
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
							'default' => $this->request->data[$model]['id'],
						));
						echo $this->Form->input('status_type_id', array(
							'type'	=> 'hidden',
							'id'	=> 'justificativa_status_type_id'
						));
					?>
					<?php
						echo $this->Form->input('justificativa', array(
							'id' => 'justificativa_txt',
							'class' => 'input-padrao',
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
		$this->start('script');
		echo $this->Html->script('../assets/tinymce/tinymce.min.js');
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				tinymce.init({
					selector: "textarea",
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
