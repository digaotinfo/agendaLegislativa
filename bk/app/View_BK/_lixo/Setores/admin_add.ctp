<?php ?>

<div class="medium-9 columns ">
	<div class="row titulo-grid pRelative">
		<div class="small-12 columns">
			<h4>Adicionar um novo Setor</h4>
			<div class='bt_voltar' onclick='window.history.back();'>
				<div class='img'></div>
				<p>VOLTAR</p>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='small-12 columns'>
			<div class='row'>
				<div class='small-12 columns'>
					
					<?=$this->Form->create($model)?>
						<?= $this->Form->input('setor' ,  array(
																	'label' => 'NOME DO SETOR', 
																	'placeholder' => '' , 
																	'div' => true,
																	'class' => 'medium-8 columns',
																	)); ?>

						<div class='row'>
						
							<div class='medium-12 columns centered'>
								<?php 
								$options = array('1' => 'Ativo', '0' => 'Inativo');
								$attributes = array('legend' => false,'id'=>'cad_add', 'default' => 1);
								
								echo $this->Form->radio('ativo', $options, $attributes);
								?>																				
							</div>
							
							
							<div class='medium-12 columns'>
								<?= $this->Form->button('Adicionar' ,  array(
																			'label' => 'Adicionar',
																			'type' => 'submit', 
																			'div' => true,
																			'class' => 'radius tiny bt-talkinghub right',
																			)); ?>
							</div>
						</div>
					<?= $this->Form->end(); ?>
					
				</div>
			</div>
		</div>
	</div>

</div>