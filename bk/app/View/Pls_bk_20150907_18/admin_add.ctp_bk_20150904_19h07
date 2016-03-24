<?php
$this->start('script');
	echo $this->Html->script('jquery.autocomplete.min.js');
	echo $this->Html->script('currency-autocomplete.js');
	echo $this->Html->script('zoio.js');
	?>
	<script charset="utf-8">
        $('.modal-trigger').leanModal();
    </script>
	<?php
$this->end();
?>

<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
    <div class="col s12">
         <h3 class="titulo-pagina">
             Cadastrando Projetos de Lei
             <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
         </h3>
     </div>
 </div>
 <!-- / HEADER DA PÁGINA -->

 <div class="row padding-top-20">

    <?=$this->Form->create($model, array('class' => 'col s12'))?>
        <input type="hidden" name="url_autocomplete" id="url_autocomplete" value="<?php echo $this->Html->url(array('action' => 'autocomplete', 'admin' => true))?>">
        <input type="hidden" name="add_situacaoPl" id="add_situacaoPl" value="<?php echo $this->Html->url(array('controller' => 'plSituacaos', 'action' => 'add', 'admin' => true))?>">
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
						   ));
				?>
				<label for="nossaposicao_texto">Tipo:</label>
			</div>
			<div class="input-field col s1">
				<i class="material-icons prefix add-situacaoPl">add</i>
			</div>
			<div class="input-field col s11">
				<?php
				   echo $this->Form->input('situacao_id' ,  array(
							   'label' => false,
							   'div' => false,
							   'type' => 'select',
							   'class' => 'validate',
							   'id' => 'selectSituacao',
							   'options' => $situacao,
						   ));
				?>
				<label for="nossaposicao_texto">Situação:</label>
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
 				<label for="numero_pl">Número da PL</label>
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
 				<label for="ano_pl">Ano da PL</label>
			</div>
             <div class="input-field col s12">
                <?php
                    echo $this->Form->input('link_da_pl', array(
                         'label' => false,
                         'id'    => 'link_pl',
                         'class' => 'validate',
                         'div' => false
                    ));
                ?>
                 <label for="link_pl">Link da PL</label>
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
                     echo $this->Form->input('OndeEsta.txt', array(
                          'label' => false,
                          'id'    => 'ondeesta_texto',
                          'class' => 'materialize-textarea',
                          'div' => false
                     ));
                 ?>
                 <label for="ondeesta_texto">Onde Está? Com quem?:</label>
             </div>
         </div>

         <div class="row">
             <div class="input-field col s12">

                 <?php
                    echo $this->Form->input('status_type_id' ,  array(
                                'label' => false,
                                'div' => false,
                                'type' => 'select',
                                'class' => 'validate',
                                'options' => $nossaPosicao,
                            ));
                 ?>
                 <label for="nossaposicao_texto">Nossa Posição - Status:</label>
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
                 <label for="nossaposicao_texto">Nossa Posição - Texto:</label>
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
