<?php 

$this->start('script');
	?>
	<script>
		/*
		$(document).ready(function(){
			$('#form_push').submit(function(){
				if ($('#texto_frase').val() != '') {
					window.location = '<?=$this->Html->url(array('action' => 'enviarpush'))?>/'+ $('#texto_frase').val();
				} else {
					alert('Favor preencher o campo de frase.');
				}
				
				
				return false;
			});
		});
		*/
	</script>
	<?php
$this->end();

$s_frase = '';
if (!empty($frase)) {
	$s_frase = $frase[$model]['frase'];
}
?>
			<div class="medium-9 columns">
				<div class="row titulo-grid pRelative">
					<div class="small-12 columns">
						<h4>Enviar Push Notification</h4>
					</div>
					<div class='bt_voltar' onclick='window.history.back();'>
						<div class='img'></div>
						<p>VOLTAR</p>
					</div>
				</div>
				<div class='row'>
					<div class='medium-12 columns'>
						<div class='row'>
							<div class='medium-12 columns'>
								<div class='row'>
								<?=$this->Form->create($model, array(
																	//'id' => 'form_push', 
																	'url' => array('controller' => 'notificacoes', 'action' => 'enviarpushprod'),
																	
																))?>
								
									<div class="small-12 columns">
										<?php
										echo '<p style="color: #616161;">Selecione a(s) Empresa(s): </p>';
										echo $this->Form->select('empresas', $empresas, array(   
											                                                'id' => 'empresa',
											                                                'multiple' => 'checkbox',
											                                                'class' => 'empresas'
											                                            ));
										?>
									</div>
									
									<div class="small-12 columns">
										<p></p>
										<?= $this->Form->input('frase' ,  array(
																				'label' => 'Frase da notificação', 
																				'div' => true,
																				'class' => 'medium-8 columns',
																				'id' => 'texto_frase',
																				'default' => $s_frase,
										)); ?>

									</div>
									<div class='medium-12 columns'>
										<?= $this->Form->button('Enviar' ,  array(
																					'label' => false,
																					'type' => 'submit', 
																					'div' => false,
																					'class' => 'radius tiny bt-talkinghub right',
										)); ?>
									</div>
								
								<?= $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		
		