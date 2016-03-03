<?php

$this->start('script');
	echo $this->Html->script(array(
		'../assets/uploadAjax/jquery.uploadfile.min.js',
	));
	?>
	<script>
		$(document).ready(function(){
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
			                    $(".status").append("<div>File Deleted</div>");
			                });
			            }
			            pd.statusbar.hide(); //You choice to hide/not.
						$('.arquivo_'+idNameModel).val('');
			        }
			    });

			});
		});

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
				<?=$this->request->data[$model]['numero_da_pl']?>
				<input type="hidden" name="pl_id" id='pl_id' value="<?php echo $this->request->data[$model]['id']?>">
				<input type="hidden" name="enviar_pl_email" id='enviar_pl_email' value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'enviar_atualizacao_pl_por_email', 'admin' => true, $this->request->data[$model]['id']));?>">
				 <a href="javascript: void(0);" class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
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
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('numero_da_pl' ,  array(
								'div' => false,
								'id' => 'numero_pl',
								'class' => 'validate',
								'label' => false,
								$disabled
							));
					?>
					<label for="numero_pl">Número da PL</label>
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
					<label for="link_pl">Link da PL</label>
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
		$a_models_relacionadas = array("Foco", "OqueE", "OndeEsta", "NossaPosicao");
		$a_models_relacionadas_titulos = array("Foco", "O que é?", "Onde está? Com quem está?", "Nossa posição");
		$countModels = count($a_models_relacionadas);

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

					<?php if( ($model_rel == 'Foco') || ($model_rel == 'OqueE') ): ?>
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
						if( ($model_rel == 'Foco') || ($model_rel == 'OqueE') ):
							?>
							<input type="hidden" name="url_alter_data" id="url_alter_data" value="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo_edit_block', 'admin' => true, $this->request->data[$model]['id'], $model_rel,$this->request->data[$model_rel][$indice]['id']) )?>">
							<div class="texto">
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
								<p class="text">
									<?php
										echo strip_tags($this->request->data[$model_rel][$indice]['txt']);
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

				<?php if( ($model_rel == 'Foco') || ($model_rel == 'OqueE') ): ?>
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
				<?php if( ($model_rel != 'Foco') && ($model_rel != 'OqueE') ): ?>
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
											'placeholder' => 'aki'
										));
									?>
									<?php
										echo $this->Form->input($model_rel. '.txt', array(
											'id' => strtolower($model_rel).'_texto',
											'class' => 'input-padrao',
											'placeholder' => 'Digite aqui a atualização',
											'label' => false
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
			 <!-- <a class="waves-effect waves-light btn" onclick="Materialize.toast('<span>Notificar por E-mail</span><a class=&quot;btn-flat yellow-text&quot; href=&quot;#!&quot;>Undo<a>', 5000)">Toast!</a> -->
	<?php
		endforeach;
	?>

	<!-- <<< BLOCOS -->
<?php
	$this->start('script');
		echo $this->Html->script('zoio.js');
	$this->end();
?>
