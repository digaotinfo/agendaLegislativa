<?php
$this->start('script');
	echo $this->Html->script('../assets/uploadAjax/jquery.uploadfile.min.js');
    echo $this->Html->script('jquery.autocomplete.min.js');
    echo $this->Html->script('currency-autocomplete.js');
    echo $this->Html->script('zoio.js');
	?>
	<script charset="utf-8">
        $('.modal-trigger').leanModal();
    </script>

    <script>
        $(document).ready(function(){
            //do something with the element here.
            var elemento = $(".mulitplefileuploader-notas-tecnicas");

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
                    $('.arquivo_notas_tecnicas').val(data[0]);

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
                    $('.arquivo_notas_tecnicas').val('');
                }
            });

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
							if (data != '') {
								$('.fluxograma').removeClass('hide');

								var selectDropdown = $("#selectEtapa");
								var selectDropdownSub = $("#selectSubEtapa");
								selectDropdown.empty();
								selectDropdown.html(' ');

								selectDropdown.append($("<option value='0'>Selecione a Etapa</option>"));
								selectDropdown.material_select();

								selectDropdownSub.empty();
								selectDropdownSub.html(' ');

								selectDropdownSub.append($("<option value='0'>Selecione a Sub-Etapa</option>"));
								selectDropdownSub.material_select();
								$('.select-fluxogramaSubEtapa > span.caret').remove();
								$('.select-fluxograma > span.caret').remove();
								$.each(data, function(index, etapa){
									selectDropdown.append($("<option>",{
										value: etapa['FluxogramaEtapa']['id'],
										text: etapa['FluxogramaEtapa']['etapa']
									}));
								});
								selectDropdown.material_select();
								$('.select-fluxograma > span.caret').remove();
								selectDropdownSub.material_select();
								$('.select-fluxogramaSubEtapa > span.caret').remove();
							}else {
								$('.fluxograma').addClass('hide');
								$('#selectEtapa').val(0);
								$('#selectEtapa').material_select();
								$('.select-fluxograma > span.caret').remove();

								$('.fluxograma').addClass('hide');
								$('#selectSubEtapa').val(0);
								$('#selectSubEtapa').material_select();
								$('.select-fluxogramaSubEtapa > span.caret').remove();
							}
						},
						error: function(data){
							console.log('deu erro');
							console.log(data);
						},
					});
				// }else{
					// $('.fluxograma').addClass('hide');
					// $('#selectEtapa').val(0);
					// $('#selectEtapa').material_select();
					// $('.select-fluxograma > span.caret').remove();
					//
					// $('.fluxograma').addClass('hide');
					// $('#selectSubEtapa').val(0);
					// $('#selectSubEtapa').material_select();
					// $('.select-fluxogramaSubEtapa > span.caret').remove();

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
            Cadastrando Nova Proposição
            <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
         </h3>
     </div>
 </div>
 <!-- / HEADER DA PÁGINA -->

 <div class="row padding-top-20">

    <?=$this->Form->create($model, array('class' => 'col s12'))?>
        <input type="hidden" name="url_autocomplete" id="url_autocomplete" value="<?php echo $this->Html->url(array('action' => 'autocomplete', 'admin' => true))?>">
        <input type="hidden" name="add_situacaoPl" id="add_situacaoPl" value="<?php echo $this->Html->url(array('controller' => 'plSituacaos', 'action' => 'add', 'admin' => true))?>">
        <input type="hidden" name="add_tema" id="add_tema" value="<?php echo $this->Html->url(array('controller' => 'temas', 'action' => 'add', 'admin' => true))?>">
        <div class="row">
			<div class="input-field col s1">
				<i class="material-icons prefix add-tipoPl">add</i>
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
                               'empty' => ' -- Selecione -- ',
						   ));
				?>
				<label for="nossaposicao_texto">Tipo:</label>
			</div>
			<div class="row fluxograma hide">
				<div class="input-field col s12 select-fluxograma">
					<?php
						echo $this->Form->input('etapa_id' ,  array(
									'label' 	=> false,
									'div' 		=> false,
									'id' 		=> 'selectEtapa',
									'type' 		=> 'select',
									'class' 	=> 'validate',
									'empty' 	=> 'Selcione a Etapa',
								));
					?>
					<label for="selectEtapa">Add Nova Etapa ao Fluxograma:</label>
				</div>
				<div class="input-field col s12 select-fluxogramaSubEtapa hide">
					<?php
						echo $this->Form->input('subetapa_id' ,  array(
									'label' 	=> false,
									'div' 		=> false,
									'id' 		=> 'selectSubEtapa',
									'type' 		=> 'select',
									'class' 	=> 'validate',
									'empty' 	=> 'Selcione a Sub-Etapa',
								));
					?>
					<label for="selectSubEtapa">Add nova Sub-Etapa ao Fluxograma:</label>
				</div>
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
                               'empty' => ' -- Selecione -- ',
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
                        'div' => false
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
                        'div' => false
                    ));
                ?>
 				<label for="ano_pl">Ano</label>
			</div>
             <div class="input-field col s6">
                <?php
                    echo $this->Form->input('link_da_pl', array(
                         'label' => false,
                         'id'    => 'link_pl',
                         'class' => 'validate',
                         'div' => false
                    ));
                ?>
                 <label for="link_pl">Link</label>
             </div>
             <div class="input-field col s6">
                <?php
                    echo $this->Form->input('apensados_da_pl', array(
						'label' => false,
						'id'    => 'apensados_da_pl',
						'class' => 'validate',
						'div' => false
                    ));
                ?>
                 <label for="apensados_da_pl">Projetos Apensados</label>
             </div>
         </div>

        <div class="row">
            <div class="input-field col s6">
                <?php
                    echo $this->Form->input('status_type_id' ,  array(
                                'label' => false,
                                'div' => false,
                                'type' => 'select',
                                'class' => 'validate',
                                'options' => $nossaPosicao,
                            ));
                ?>
                <label for="nossaposicao_texto">Status:</label>
            </div>
            <div class="input-field col s6">
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
                                        'div' => false
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

        <div class="row">
             <div class="input-field col s6">
                 <?php
                     echo $this->Form->input('autor', array(
                          'label' => false,
                          'id'    => 'autor_nome',
                          'class' => 'validate autocomplete',
                          'div' => false
                     ));
                 ?>
                 <label for="autor_nome">Autor(a):</label>
             </div>
             <div class="input-field col s6">
                 <?php
                     echo $this->Form->input('relator', array(
                          'label' => false,
                          'id'    => 'relator_nome',
                          'class' => 'validate autocomplete',
                          'div' => false
                     ));
                 ?>
                 <label for="relator_nome">Relator(a):</label>
             </div>
        </div>


         <div class="row">
             <div class="input-field col s12">
                 <i class="material-icons prefix">mode_edit</i>
                 <?php
                     echo $this->Form->input('Foco.txt', array(
                          'label' => false,
                          'id'    => 'foco_texto',
                          'class' => 'materialize-textarea',
                          'div' => false
                     ));
                 ?>
                 <label for="foco_texto">Foco:</label>
             </div>
         </div>

         <div class="row">
             <div class="input-field col s12">
                 <i class="material-icons prefix">mode_edit</i>
                 <?php
                     echo $this->Form->input('OqueE.txt', array(
                          'label' => false,
                          'id'    => 'oquee_texto',
                          'class' => 'materialize-textarea',
                          'div' => false
                     ));
                 ?>
                 <label for="oquee_texto">O que é?:</label>
             </div>
         </div>
         <div class="row">
             <div class="input-field col s12">
                 <i class="material-icons prefix">mode_edit</i>
                 <?php
                     echo $this->Form->input('Situacao.txt', array(
                          'label' => false,
                          'id'    => 'Situacao_texto',
                          'class' => 'materialize-textarea',
                          'div' => false
                     ));
                 ?>
                 <label for="situacao_texto">Situação:</label>
             </div>
         </div>

         <div class="row">
             <div class="input-field col s12">
                 <i class="material-icons prefix">mode_edit</i>

                 <?php
                     echo $this->Form->input('NossaPosicao.txt', array(
                          'label' => false,
                          'id'    => 'nossaposicao_texto',
                          'class' => 'materialize-textarea',
                          'div' => false
                     ));
                 ?>
                 <label for="nossaposicao_texto">Nossa Posição:</label>
             </div>
         </div>
        <div class="row">
            <div class="input-field col s6">
                Notas Técnicas
                    <?php
                    //////////////////////////////////////////////////////////////////////
                    //////////////////////////////////////////////////////////////////////
                    //>>> UPLOAD
                    ?>
                        <div class="mulitplefileuploader-notas-tecnicas" data-return='arquivo_notas_tecnicas'>Upload</div>
                    <?php
                    //<<< UPLOAD
                    //////////////////////////////////////////////////////////////////////
                    //////////////////////////////////////////////////////////////////////
                    ?>
                    <?php
                        echo $this->Form->input('arquivo', array(
                            'type' => 'hidden',
                            'class' => 'arquivo_notas_tecnicas',
                        ));
                    ?>
            </div>
        </div>
        <div class="row">
             <div class="input-field col s12">
                <?php
                    echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
                        'type' => 'submit',
                        'div' => true,
                        'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                    ));
                ?>
                 <a  href="javascript: void(0);" onclick='window.history.back();' class="waves-effect waves-light btn right red darken-3">
                     <i class="material-icons left">close</i>Cancelar
                 </a>
             </div>
         </div>
    <?=$this->Form->end();?>
 </div>
