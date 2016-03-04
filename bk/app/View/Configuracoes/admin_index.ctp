<?php   ?>
<div class='msmall-12 columns'>

	<div id='registros'>
		<div class="row titulo-grid">
			<div class="small-7 columns">
				<h4>Configurações do site</h4>
			</div>
			
		</div>
		<div class="row grid-geral" id="gridTema">
			<div  class="small-12 columns">
				<table>
					<thead>
						<tr>
							<!-- <th class="hide-for-small"><p align='center'>ID</p></th> -->
							<th width="300">
								<p align='left'>
									<?=$this->Paginator->sort('nome', 'Nome da Categoria');?>
								</p>
							</th>
							<th width="10">
								<p align='center'>
									<?=$this->Paginator->sort('ativo', 'Ativo');?>
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
								<td><?=$registro[$model]['nome'];?></td>
								<td> <div class="ponto-<?=$class?> with-link"></div> </td>
								<td class="bt-acoes text-center">
									<!-- BOTOES DE ACAO -->
									<a href=' <?=$this->Html->url(array(	
															'controller' => 'categorias', 	
															'action' => 'admin_view', $registro[$model]['id']
															)
													);
												?>' class='radius button action bt_e'>
													Visualizar
									</a>
									<a href=' <?=$this->Html->url(array(	
															'controller' => 'categorias', 	
															'action' => 'admin_edit', $registro[$model]['id']
															)
													);
												?>' class='radius button action bt_e'>
													Editar
									</a>
									
									
									<?=$this->Form->postLink('Excluir',
											array('controller' => 'categorias', 'action' => 'delete', $registro[$model]['id']),
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
