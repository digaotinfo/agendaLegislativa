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
