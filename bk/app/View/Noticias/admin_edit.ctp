<?php ?>

<div class="small-12 columns ">
	<div class="row titulo-grid">
		<div class="small-12 columns">
			<h4>Adicionar uma nova Notícia</h4>
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
					
					<?=$this->Form->create($model, array('type' => 'post'))?>
						<?=$this->Form->input('id', array('type' => 'hidden'))?>


				        <?=$this->Form->input('categoria_id', array(
																	'options' => array('' => '-- Selecione a Categoria --', $categorias),
																	'label' => false,
																	'id'    => 'categorias',
																));
								?>

						<?= $this->Form->input('titulo' ,  array(
																	'label' => 'Título', 
																	'placeholder' => 'título da notícia' , 
																	'div' => true,
																	'class' => 'medium-8 columns',
																	)); ?>

						<?= $this->Form->input('chamada' ,  array(
																	'label' => 'Chamada', 
																	'placeholder' => 'chamada da notícia' , 
																	'div' => true,
																	'class' => 'medium-8 columns',
																	)); ?>
						<?= $this->Form->input('texto' ,  array(
																	'label' => 'Texto', 
																	'placeholder' => '' , 
																	'div' => true,
																	'class' => 'medium-8 columns',
																	)); ?>


						<div class="row">
							<br><br>
							<div class="small-12 columns">
								<label>Imagem</label>
							</div>
							<div class="small-12 columns">
								<?php
								echo $this->element('admin_input_file_img', array(
																				'acao' => 'edit',
																				'coluna_banco' => 'imagem',
																				'label' => false
																			));
								?>
							</div>
						</div>

						<div class='row'>
							<hr>
							<div class='medium-12 columns centered'>
								<label>Manter ativa esta notícia?</label>
								<?php 
								$options = array('1' => 'Sim', '0' => 'Não');
								$attributes = array('legend' => false,'id'=>'ativo', 'default' => 1);
								
								echo $this->Form->radio('ativo', $options, $attributes);
								?>																				
							</div>
							
							<div class='medium-12 columns'>
								<?= $this->Form->button('Salvar' ,  array(
																			'label' => 'Salvar',
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