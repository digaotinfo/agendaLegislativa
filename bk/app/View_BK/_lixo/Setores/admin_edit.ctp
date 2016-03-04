<?php 
//print_r($this->request->data); 
?>
<div class="medium-9 columns ">
		<div class="row titulo-grid pRelative">
			<div class="small-12 columns">
				<h4>Editar Setor</h4>
				<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
			</div>
			
		</div>
		<div class='row'>
			<div class='medium-12 columns'>
				<div class='row'>
					<div class='medium-12 columns'>
						<?=$this->Form->create($model, array('type' => 'post'))?>
							<?=$this->Form->input('id', array('type' => 'hidden'))?>
							<?= $this->Form->input('setor' ,  array(
												'label' => 'NOME DO SETOR',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>

							<div class='row'>
						
								<div class='medium-4 columns centered'>
									<?php
									$options = array('1' => 'Ativo', '0' => 'Inativo');

									$attributes = array('legend' => false,'id'=>'cad_add', 'ativo', 'default' => 1);

									echo $this->Form->radio('ativo', $options, $attributes);
									?>
								</div>
								<div class='medium-12 columns'>
									<?= $this->Form->button('enviar' ,  array(
												'label' => 'Enviar',
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