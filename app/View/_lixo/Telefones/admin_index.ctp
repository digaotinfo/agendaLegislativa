<?php   
	
	//print_r($registros);
?>
<div class='medium-9 columns'>

	<div id='empresas'>
		<div class="row titulo-grid">
			<div class="small-12 columns">
				<h4>Telefones</h4>
			</div>
			
			
			<?php
			/// FILTRO
			///==============================================================
			?>
			<div class='small-12 columns'>
				<?php 
				echo $this->Form->create('filtro')
				?>
				<div class='small-10 columns'>
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
				<div class='small-2 columns'>
					<?php 								
					echo $this->Form->input('Filtrar', array(
															'label' => false,
															'type' => 'submit',
															//'id'    => 'escolha_conteudo_generico',
															'class' => 'radius button thirdary right tiny'
														));											
				?>
					
				</div>
				<?php
				echo $this->Form->end();
				?>
			</div>
			<?php
			///==============================================================
			?>
			
			
			
			
			<div class="small-5 columns">
				<a href="<?=$this->Html->url(array('controller' => 'telefones', 'action' => 'admin_add'))?>" class="radius button thirdary right tiny bt-talkinghub">Adicionar</a>
			</div>
		</div>
		
		<div class="row">
			<div class="small-12 columns">
				<h6>Atenção</h6>
				<p>O aplicativo irá mostrar apenas o último registro ativo pertinente ao(s) setor(s) do usuário.</p>
			</div>
		</div>
		<div class="row grid-geral" id="gridTema">
			<div  class="small-12 columns">
				<table>
					<thead>
						<tr>
							<th class="hide-for-small"><p align='center'>ID</p></th>
							<th width="400"><p align='center'>Telefones</p></th>
							<th width="400"><p align='center'>Setores</p></th>
							<th width="100"><p align='center'>No AR</p></th>
							<th width="200"><p align='center'>Ação</p></th>
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

								<td class="text-center hide-for-small"><?=$registro[$model]['id'];?></td>
								<td><?=$registro[$model]['telefones'];?></td>
								<td>
									<?php
										foreach($registro['Setor'] as $setor) {
											echo $setor['setor'] .'<br>';
										}
									?>
								</td>
								<td> <div class="ponto-<?=$class?> with-link"></div> </td>
								<td class="bt-acoes text-center">
									<!-- BOTOES DE ACAO -->

										<a href=' <?=$this->Html->url(array(	
																'controller' => 'telefones', 	
																'action' => 'admin_edit', $registro[$model]['id']
																)
														);
													?>' class='radius button action bt_e'>
														Editar
										</a>
										
										<?=$this->Form->postLink('Excluir',
												array('controller' => 'telefones', 'action' => 'delete', $registro[$model]['id']),
												array('confirm' => 'Tem certeza que deseja excluir esta lista de telefones?', 'class' => 'radius button action bt_x')
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
