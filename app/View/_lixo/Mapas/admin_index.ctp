<?php //print_r($manifestacoes);?>
<div class="medium-9 columns">
	<div id='conteudoG'>
	
	<?=$this->element('mapa_manifestacoes_header')?>
	
		<div class='open_div'>
				<div class="row titulo-grid">
					<div class="small-4 columns title">
						<h4></h4>
					</div>
	
					<div class="small-5 columns">
						<a href="<?=$this->Html->url(array('controller' => 'mapas', 'action' => 'admin_add'))?>" class="radius button thirdary right tiny">Adicionar</a>
					</div>
				</div>
				<div class="row grid-geral" id="gridTema">
					<div  class="small-12 columns">
						<table>
							<thead>
								<tr>
									<th class="hide-for-small">
										<p align='center'>
											<!-- ID -->
											<?=$this->Paginator->sort('id', 'ID');?>
										</p>
									</th>
									<th width="420">
										<p align='center'>
											<!-- Local -->
											<?=$this->Paginator->sort('Estado.nome', 'Estado');?>
										</p>
									</th>
									<th width="420">
										<p align='center'>
											<!-- Local -->
											<?=$this->Paginator->sort('Cidade.nome', 'Cidade');?>
										</p>
									</th>
									<th width="420">
										<p align='center'>
											<!-- Local -->
											<?=$this->Paginator->sort('local', 'Local');?>
										</p>
									</th>
									<th  width="320">
										<p align='center'>
											<!-- Empresa -->
											<?=$this->Paginator->sort('empresa', 'Empresas');?>
										</p>
									</th>
									<th>
										<p align='center'>
											<!-- Publicado -->
											<?=$this->Paginator->sort('publicar', 'Publicado');?>
										</p>
									</th>
									<!-- <th><p align='center'>Fotos</p></th> -->
									<th><p align='center'>Ação</p></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (empty($manifestacoes)) {
									?>
									<tr>
										<td class="text-center hide-for-small" colspan="7">Nenhum registro encontrado.</td>
									</tr>
									<?php
								} else {
									
									foreach($manifestacoes as $manifestacoes): 
										
										$class = 'inativo';
											if($manifestacoes[$model]['publicar'] == 1){
												$class = 'ativo';
										}
										?>
										<tr>
											<td class="text-center hide-for-small"><?=$manifestacoes[$model]['id']?></td>
											<td><?=$manifestacoes['Estado']['nome']?></td>
											<td><?=$manifestacoes['Cidade']['nome']?></td>
											<td><?=$manifestacoes[$model]['local']?></td>
											<td>
											<?php
												foreach($manifestacoes['Empresa'] as $empresa){
													echo $empresa['empresa']. '<br />';
												}
											?>
										</td>
											<td> <div class="ponto-<?=$class?> with-link"></div> </td>
											<!--Galeria de imagem -->
		<!--
											<td align='center' class='bt_foto_mais'>
												<?=$manifestacoes[$model]['total_galeria_manifestacao']?>
													<a href='<?=$this->Html->url(array('controller' => 'mapas', 'action' => 'galeria', 'admin' => true, $manifestacoes[$model]['id']))?>'>
														+
													</a>
											</td>
		-->
											<!--End Galeria de imagem -->
											<td class="bt-acoes text-center">
			
												<!-- BOTOES DE ACAO -->
												<a href="<?=$this->Html->url(array('controller' => 'mapas', 'action' => 'admin_visualizar', $manifestacoes[$model]['id']))?>" class="radius button action bt_v">Visualizar</a>
												<a href="<?=$this->Html->url(array('controller' => 'mapas', 'action' => 'admin_edit', $manifestacoes[$model]['id']))?>" class="radius button action bt_v">Editar</a>
			
												<?=$this->Form->postLink('Excluir',
														array('controller' => 'mapas', 'action' => 'delete', $manifestacoes[$model]['id']),
														array('confirm' => 'Tem certeza que deseja excluir este Tópico?', 'class' => 'radius button action bt_x')
													);
														?>
												<!-- END BOTOES DE ACAO -->
			
											</td>
										</tr>
										<? 
									endforeach; 
								}
								?>
	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<div class="page_selector text-center">
				<?php
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
                ?>
	</div>
</div>
