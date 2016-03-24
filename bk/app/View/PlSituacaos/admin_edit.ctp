<?php

?>
<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		 <h3 class="titulo-pagina">
			 Alterar Tipo
			 <a href="javascript: void(0);" onclick='window.history.back();'  class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
		 </h3>
	 </div>
 </div>
 <!-- / HEADER DA PÁGINA -->


 <div class="row padding-top-20">

 <?= $this->Form->create($model, array('type'=>'file', 'data-abide' => '', 'class' => 'col s12'));?>
 	<?php
 		echo $this->Form->input('id', array('type' => 'hidden'));
 	?>
		<div class="row">
			<div class="input-field col s12">
				<?php
					echo $this->Form->input('situacao' ,  array(
								'div' => false,
								'id' => 'situacao',
								'class' => 'validate',
								'label' => false,
							));

				?>
				<label for="nome">Situação</label>
			</div>
		</div>

 		<div class="row">
 			<div class="input-field col s12">
                <!-- Switch -->
                <div class="switch">
                    <label>
                        Desativada
                        <?php
                            echo $this->Form->input('ativo', array(
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false
                            ));
                        ?>
                        <!-- <input type="checkbox"> -->
                        <span class="lever"></span>
                        Ativa
                    </label>
                </div>

                <!-- Disabled Switch -->

  			</div>
  		</div>




  		<div class="row">
  			<div class="input-field col s12">
				<?php
					echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
						'label' => 'Salvar',
						'type' => 'submit',
						'div' => true,
						'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
					));
				?>
 				<?php
					// echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
					// 	'type' => 'submit',
					// 	'div' => true,
					// 	'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
					// ));
					?>
  				<a href="javascript: void(0);" onclick='window.history.back();' class="waves-effect waves-light btn right red darken-3">
  					<i class="material-icons left">close</i>Cancelar
  				</a>
  			</div>
  		</div>


 	<?= $this->Form->end(); ?>
