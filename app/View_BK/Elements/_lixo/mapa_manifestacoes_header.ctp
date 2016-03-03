<?php 
	//print_r(); 
	//print_r();
?>
<div class="row">
	<div class="small-12 columns">
		<div class='row titulo-grid'>
			<div class='small-12 columns'>
				<h4>Mapa de Manifestações</h4>
			</div>
		</div>
		<div class='row titulo-grid generico_header'>
			<?php 
			echo $this->Form->create('filtro')
				?>
				<div class="small-10 columns">
					<h5>Filtro de mapa de manifestações:</h5>
				</div>
				<div class="small-2 columns">
					<div class="bt_hide _mais right" data-toggle="" data-toggle-id="formulario_busca"></div>
				</div>
				<div id="formulario_busca" class="hide">
					<div class='small-3 columns'>
						<!--checkbox-->
						<?php    
							echo '<p style="color: #616161;">Selecione a(s) Empresa(s): </p>';
				          	echo $this->Form->select('Empresas', $empresas, array(   
				                                                'id' => 'empresa',
				                                                'multiple' => 'checkbox',
				                                                'class' => 'empresas'
				                                            ));
				        
						//<!-- end checkbox -->
						?>
					</div>
					<div class="small-9 columns">
						
						<!-- <div class="small-12"> -->
							<div class='medium-4 columns'>
								<?php
								echo '<p style="color: #616161;">Estado: <br>';
								echo $this->Form->input('estado_id', array(	
																		'label' => false,
																		'div' => false,
																		'empty' => 'Selecionar',
																		'id'    => 'local_estate',
																	));
								echo '</p>';
								?>

							</div>
							<div class='medium-8 columns'>
								<?php
								echo '<p style="color: #616161;">Cidade: <br>';
								echo $this->Form->input('cidade_id', array(
																		'label' => false,
																		'div' => false,
																		'options' => array('Selecionar o Estado'),
																		'disabled' => true,
																		'id' => 'local_city',
																			'value' => 'name'
														));
								echo '</p>';
								?>

							</div>
						<!-- </div> -->
						
						
						<div class="small-12 columns">
							<?php
							echo '<p style="color: #616161;">Buscar por texto: <br>';
							echo $this->Form->input('busca', array(
																	'label' => false,
																	'div' => false,
																	'placeholder' => 'Digite aqui o texto que deseja buscar'
																));	
							echo '</p>';
							?>
							<?php 								
							echo $this->Form->input('Filtrar', array(
																	'label' => false,
																	'div' => false,
																	'type' => 'submit',
																	'class' => 'radius button thirdary right tiny'
																));	
							?>
						</div>
					</div>
				</div>
				<?php
			echo $this->Form->end();
			?>
		</div>
	</div>
</div>
<style type="text/css">

</style>

<?php
$this->start('script');
?>
<!--
<script>
$(document).ready(function(){
$('#escolha_conteudo_generico').change(function(){
	//debugger
	//console.log($(this).val());
	
	//window.location = '<?=$this->Html->url(array('action' => 'index'))?>/index/'+ $(this).val();
	break;
	return false;
});
});
</script>
-->
<?php
$this->end();
?>