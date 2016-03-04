<?php 
//print_r($imagem);

?> 
<div class="medium-9 columns">
		<?php 
		echo $this->Form->create($model);
		echo $this->Form->input('imagem_id', array('type' => 'hidden', 'value' => $imagem[$model]['id']));
		?>
	<div class="row titulo-grid pRelative">
		<div class="small-12 columns">
			<h4>Galeria de "<?=$conteudo['Conteudo']['titulo']?>"</h4>

			<a href="<?=$this->Html->url(array('controller' => 'conteudos', 'action' => 'admin_edit', $imagem[$model]['conteudo_id']))?>" class="radius button tiny bt-talkinghub">Editar Conteúdo</a>
		</div>
	<div class='bt_voltar' onclick='window.history.back();'>
		<div class='img'></div>
			<p>VOLTAR</p>
		</div>
	</div>
	<div class='row'>
		<div class='medium-12 columns'>
							<div class='medium-11 columns hide-for-large-up text-left' align='center'><h6 class="alert-text">Obs.: não recomentamos alterações ou adicões de novas imagens através de um dispositivo móvel: celular ou tablet.</h6></div>
				<form>
					<div class='row'>
						<div class='medium-8 medium-centered columns' style='margin-bottom: 20px;'>
							<?=$this->Html->image('../'. $imagem[$model]['img_file'])?>
						</div>
					</div>
					<div class='row'>
						<div class='medium-12 columns'>
							<div class='row'>
								<?= $this->Form->input('legenda' ,  array(
																		'label' => 'Legenda',
																		'type' => 'text', 
																		'div' => true,
																		'value' => $imagem[$model]['legenda']
																			)); ?>
	
							<div class='row'>
							
							<div class='row'>
								<div class='medium-12 columns' align='center'>
								<?= $this->Form->button('Editar Legenda' ,  array(
																			'type' => 'submit', 
																			'div' => true,
																			'class' => 'radius tiny bt-talkinghub',
																				)); 
								?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div>
	
	
	<div class="medium-2 columns">&nbsp;</div>
	<?= $this->Form->end(); ?>
</div>