<?php
$this->start('script');
?>
<script type="text/javascript">
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
</script>
<?php
$this->end();
?>
<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		 <h3 class="titulo-pagina">
			 Cadastrando nova Tarefa
			 <a href="javascript: void(0);" onclick='window.history.back();'  class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
		 </h3>
	 </div>
 </div>
 <!-- / HEADER DA PÁGINA -->


 <div class="row padding-top-20">

 <?= $this->Form->create($model, array('type'=>'file', 'data-abide' => '', 'class' => 'col s12'));?>
 		<div class="row">
 			<div class="input-field col s12">
 				<?php
 					echo $this->Form->input('titulo' ,  array(
 								'div' => false,
 								'id' => 'titulo',
 								'class' => 'validate',
 								'label' => false,
 							));

 				?>
  				<label for="nome">Nome da Tarefa</label>
  			</div>

			<div class="col s12">
 				<?php
 					echo $this->Form->input('descricao' ,  array(
								'type' => 'textarea',
 								'div' => false,
 								'id' => 'descricao',
 								'class' => 'validate',
 								'label' => 'Descricao',
 							));

 				?>
  			</div>
			<div class="col m12 padding-top-20">
				<?php
					echo $this->Form->input('usuarios', array(
							'label'		=> false,
							'type' 		=> 'select',
							'multiple' 	=> 'checkbox',
							'options' 	=> $usuariosLista,
							'name'		=> 'Usuarios'
						))
				?>
			</div>
			<div class="input-field col s12">
				<?php
				   echo $this->Form->input('entrega' ,  array(
							   'label' => false,
							   'div' => false,
							   'type' => 'text',
							   'class' => 'validate datepicker',
						   ));
				?>
				<label for="nossaposicao_texto">Data de Entrega</label>
			</div>


  		</div>




 		<div class="row">
 			<div class="col s8">
				<div class="input-field col s6">
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
	                        <span class="lever"></span>
	                        Ativa
	                    </label>
	                </div>
	  			</div>
	 			<div class="input-field col s6">
	                <!-- Switch -->
	                <div class="switch">
	                    <label>
	                        Nao Realizado
	                        <?php
	                            echo $this->Form->input('realizado', array(
	                                'type' => 'checkbox',
	                                'label' => false,
	                                'div' => false
	                            ));
	                        ?>
	                        <!-- <input type="checkbox"> -->
	                        <span class="lever"></span>
	                        Realizado
	                    </label>
	                </div>
	  			</div>
 			</div>
  		</div>

		<br>
		<br>


  		<div class="row">
  			<div class="input-field col m12">
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
