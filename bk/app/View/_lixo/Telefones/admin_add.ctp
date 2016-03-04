<?php ?>

<div class="medium-9 columns ">
	<div class="row titulo-grid pRelative">
		<div class="small-12 columns">
			<h4>Adicionar Lista de Telefones</h4>
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
						
						<div class="small-12 columns" id="checkboxes">
							<h6>SETOR</h6>
							<!--checkbox-->
								<?php
								echo '<p style="color: #616161;">Selecione o(s) Setor(es): </p>';
								echo $this->Form->input('todos', array(   
						                                                'id' => 'empresa',
						                                                'type' => 'checkbox',
						                                                'class' => 'empresas',
						                                                'onChange' => 'todos(this)'
						                                            ));
						        echo '<p></p>';
								echo $this->Form->select('Setor', $setores, array(
																					'id' => 'setor',
																					'multiple' => 'checkbox',
																				));
								?>
							<!--checkbox -->
							<p></p>
						</div>
						
						<div class="small-12 columns">
							<?= $this->Form->input('telefones' ,  array(
																		'label' => 'Lista de telefones', 
																		'div' => false,
																		'class' => 'small-12 columns',
																		)); ?>
							<p></p>
						</div>
						
						
						<div class='small-4 columns centered'>
							<?php 
							$options = array('1' => 'Ativo', '0' => 'Inativo');
							$attributes = array('legend' => false,'id'=>'cad_add');
							
							echo $this->Form->radio('ativo', $options, $attributes);
							?>
						</div>
						
					
						<div class='small-12 columns'>
							<?= $this->Form->button('Adicionar' ,  array(
																		'label' => 'Adicionar',
																		'type' => 'submit', 
																		'div' => true,
																		'class' => 'radius tiny bt-talkinghub right',
																		)); ?>
						</div>
					<?= $this->Form->end(); ?>
					
				</div>
			</div>
		</div>
	</div>

</div>