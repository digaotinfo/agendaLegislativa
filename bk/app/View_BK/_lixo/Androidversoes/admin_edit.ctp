<?php
	echo $this->element('validacao_senha_forte');
?>
<div class="medium-9 columns">

	<div class="row titulo-grid">
		<div class="small-7 columns">
			<h4>EDITAR VERSÃO</h4>
		</div>

		<div class='bt_voltar' onclick='window.history.back();'>
			<div class='img'></div>
				<p>VOLTAR</p>
			</div>
		</div>
		<div class="row grid-geral" id="gridTema">
			<div  class="small-12 columns">
				
				<?= $this->Form->create($model, array('data-abide' => ''));?>
				
					<?php		
					echo $this->Form->input('id', array('type' => 'hidden'));
					?>
					
					<div class="row">
						<div class="small-12 columns">
							<div class="name-field">
								<?=$this->Form->input('versao', $options = array(
																				'label' => 'Versão',
																				'div' => false, 
																			));?>
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="small-12 columns">
							<?=$this->Form->input('Salvar', $options = array(
																			'type' => 'submit',
																			'label' => false,
																			'div' => false, 
																			'class' => 'button radius',
																		));?>
						</div>
					</div>
				<?=$this->Form->end();?>
					
				
			</div>
		</div>
	
	</div>	
</div>