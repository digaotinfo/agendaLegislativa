<?php   

if (!empty($this->request->data['filtro'])) {
	$this->start('script');
		?>
		<script type="text/javascript">
		$(document).ready(function(){
			$('[data-toggle]').click();
		});
		</script>
		<?php
	$this->end();
}

?>




<div class='msmall-12 columns'>

	<div id='registros'>
		<div class="row titulo-grid">
			<div class="small-7 columns">
				<h4>Notícias</h4>
			</div>
			<div class="small-5 columns text-right">
				<a href="<?=$this->Html->url(array('controller' => 'noticias', 'action' => 'admin_add'))?>" class="radius button thirdary right tiny bt-talkinghub">Adicionar</a>
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
					<div class='small-12 medium-6 columns'>
						<p style="color: #616161;">Selecione a(s) Categoria(s): </p>
						<div class='left'>
							<?php 
							/*
							Liberar este código, caso queira um selectbox
							echo $this->Form->input('categorias', array(
																	'label' => false,
																	'options' => array('' => '-- Categorias --', $categorias),
																	'default' => $categoria_id,
																	'id'    => 'escolha_conteudo_generico',
																));
							*/
							echo $this->Form->select('categorias', $categorias, array(   
								                                                'id' => 'escolha_conteudo_generico',
								                                                'multiple' => 'checkbox',
								                                                'class' => 'empresas'
								                                            ));
							?>
						</div>
					</div>
					

					<div class="small-9 medium-10 columns">
						<?php
						echo $this->Form->input('busca', array(
																'label' => false,
																'placeholder' => 'Digite aqui o texto que deseja buscar'
															));	
						?>
					</div>
					
					<div class='small-3 medium-2 columns'>
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
				<hr>
			</div>
		</div>



		<div class="row grid-geral" id="gridTema">
			<div  class="small-12 columns">
				<table>
					<thead>
						<tr>
							<!-- <th class="hide-for-small"><p align='center'>ID</p></th> -->
							<th width="400">
								<p align='left'>
									<?=$this->Paginator->sort('Noticia.titulo', 'Título');?>
								</p>
							</th>
							<th width="200">
								<p align='left'>
									<?=$this->Paginator->sort('Categoria.nome', 'Categoria Relacionada');?>
								</p>
							</th>
							<th width="10">
								<p align='center'>
									<?=$this->Paginator->sort('Noticia.ativo', 'Ativo');?>
								</p>
							</th>
							<th width="200">
								<p align='center'>
									Ação
								</p>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($registros as $registro): 
							$class = 'inativo';
							if($registro[$model]['ativo'] == 1){
								$class = 'ativo';
							}
							?>
							<tr>

								<!-- <td class="text-center hide-for-small"><?=$registro[$model]['id'];?></td> -->
								<td>
									<h4>
										<?=$registro[$model]['titulo'];?><br>
										<small><?=$registro[$model]['chamada'];?></small>
									</h4>

								</td>
								<td>
									<a href="<?=$this->Html->url(array(
																	'controller' => 'categorias',
																	'action' => 'view',
																	$registro['Categoria']['id']
																))?>">
										<?=$registro['Categoria']['nome'];?>
									</a>
								</td>
								<td> <div class="ponto-<?=$class?> with-link"></div> </td>
								<td class="bt-acoes text-center">
									<!-- BOTOES DE ACAO -->
									<a href=' <?=$this->Html->url(array(	
															'controller' => 'noticias', 	
															'action' => 'admin_edit', $registro[$model]['id']
															)
													);
												?>' class='radius button action bt_e'>
													Editar
									</a>
									
									
									<?=$this->Form->postLink('Excluir',
											array('controller' => 'noticias', 'action' => 'delete', $registro[$model]['id']),
											array('confirm' => 'Tem certeza que deseja excluir esta categoria?', 'class' => 'radius button action bt_x')
									);
									?>
									<!-- END BOTOES DE ACAO -->
								</td>

							</tr>
							<?php 
						endforeach; 
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="page_selector text-center">
		<?php
		
		$paginacao = $this->Paginator->params();
		
		if ($paginacao['pageCount'] > 1) {
		    echo $this->Paginator->prev(
		                                'PÁGINA ANTERIOR',
		                                null,
		                                null,
		                                array('id' => 'last')
		                                );
		
		    echo $this->Paginator->numbers(array(
		               							 'separator' => '',
		               							 'currentTag' => 'a',
		               							 'tag' => 'div',
		               							 'class' => 'bt'
		
					                            ));
		
		
		    echo $this->Paginator->next(
		                                'PRÓXIMA PÁGINA',
		                                null,
		                                null,
		                                array('id' => 'next')
		                                );
		}
	    ?>
	</div>
</div>
