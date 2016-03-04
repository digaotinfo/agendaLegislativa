<?php 
	//print_r($registros); 
	//print_r($conteudo);
?>
<div class="row">
	<div class="small-12 columns">
		<div class='row titulo-grid'>
			<div class='small-12 columns'>
				
				<h4>Conteúdo</h4>
			</div>
		</div>
		<div class='row titulo-grid generico_header'>
			<div class="small-10 columns">
				<h5>Filtro de conteúdo:</h5>
			</div>
			<div class="small-2 columns">
				<div class="bt_hide _mais right" data-toggle="" data-toggle-id="formulario_busca"></div>
			</div>
			
			<div id="formulario_busca" class="hide">
				<?php 
				
				/// FILTRO DE LISTA
				echo $this->Form->create('filtro')
					?>
					<div class='medium-6 small-12 columns'>
						<!--checkbox-->
						<?php    
							echo '<p style="color: #616161;">Selecione o(s) Setor(es): </p>';
				          	echo $this->Form->select('Setores', $setores, array(   
				                                                'id' => 'setor',
				                                                'multiple' => 'checkbox',
				                                                'class' => 'empresas'
				                                            ));
				        
						//<!-- end checkbox -->
						?>
					</div>
					
					<div class='medium-6 small-12 columns'>
						<div class='categoria'>
							<?php 
							/*
							echo $this->Form->input('categorias', array(
																	'label' => false,
																	'options' => array('' => '-- Categorias --', $categorias),
																	'default' => $categoria_id,
																	'id'    => 'escolha_conteudo_generico',
																));
							*/
							echo '<p style="color: #616161;">Selecione a(s) Categoria(s): </p>';
							echo $this->Form->select('categorias', $categorias, array(   
								                                                'id' => 'escolha_conteudo_generico',
								                                                'multiple' => 'checkbox',
								                                                'class' => 'empresas'
								                                            ));
							?>
						</div>
					</div>
					
					<div class="small-12 columns">
						<?php
						echo $this->Form->input('busca', array(
																'label' => false,
																'placeholder' => 'Digite aqui o texto que deseja buscar'
															));	
						?>
					</div>
					
					<div class='small-2 columns end'>
						<?php 								
						echo $this->Form->input('Filtrar', array(
																'label' => false,
																'type' => 'submit',
																//'id'    => 'escolha_conteudo_generico',
																'class' => 'radius button thirdary tiny expand'
															));											
						?>
						
					</div>
					<?php
				echo $this->Form->end();
				?>
			</div>
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