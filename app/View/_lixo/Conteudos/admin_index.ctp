<?php
//print_r($conteudos);
//print_r($Conteudoempresa);
//print_r($count_image);
//print_r($empresas);
/*
foreach($conteudos as $teste){
	foreach($teste['Empresa'] as $fads){
		print_r($fads);
	}
}
*/
?>
<div class='medium-9 columns'>
	<div id='conteudoG'>
		<?=$this->element('conteudo_generico_header')?>


		<div class='open_div'>
			<div class="row titulo-grid">
				<div class="small-4 columns title">
					<h4></h4>
				</div>

				<div class="small-5 columns">
					<a href="<?=$this->Html->url(array('controller' => 'conteudos', 'action' => 'admin_add'))?>" class="radius button thirdary right tiny">Adicionar</a>
				</div>
			</div>
			<div class="row grid-geral" id="gridTema">
				<div  class="small-12 columns">
					<table>
						<thead>
							<tr>
								<th class="hide-for-small">
									<p align='center'>
										<!--ID-->
										<?=$this->Paginator->sort('id', 'ID');?>
									</p>
								</th>
								<th width="320">
									<!--
										<p align='center'>Título</p>
									-->
									<p align='center'>
										<?=$this->Paginator->sort('titulo', 'Título');?>
									</p>
								</th>
								<th  width="220">
									<p align='center'>
										<!-- Categoria -->
										<?=$this->Paginator->sort('Categoria');?>
									</p>
								</th>
								<th  width="120">
									<p align='center'>
										<!-- Empresa -->
										<?=$this->Paginator->sort('setor', 'Setores');?>
									</p>
								</th>
								<th>
									<p align='center'>
										<!-- Publicado -->
										<?=$this->Paginator->sort('publicar', 'Publicado');?>
									</p>
								</th>
								<th  width="150">
									<p align='center'>
										<!-- Data -->
										<?=$this->Paginator->sort('created', 'Data');?>
									</p>
								</th>
								<th>
									<p align='center'>
										<!-- Fotos -->
										<?=$this->Paginator->sort('total_galeria', 'Fotos');?>
									</p>
								</th>
								<th width="150"><p align='center'>Ação</p></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if (empty($conteudos)) {
							?>
							<tr>
								<td class="text-center hide-for-small" colspan="8">Nenhum registro encontrado.</td>
							</tr>
							<?php
						} else {
							foreach($conteudos as $conteudo):
								$class = 'inativo';
									if($conteudo[$model]['publicar'] == 1){
										$class = 'ativo';
								}
								?>
								<tr>
									<td class="text-center hide-for-small"><?=$conteudo[$model]['id']?></td>
									<td><?=$conteudo[$model]['titulo']?></td>
									<td><?=$conteudo['Categoria']['categoria']?></td>
									<td>
										<?php
											foreach($conteudo['Setor'] as $setor){
												echo $setor['setor']. '<br />';
											}
										?>
									</td>
									<td> <div class="ponto-<?=$class?> with-link"></div> </td>
									<td><?=$conteudo[$model]['created']?></td>
									<td align='center' class='bt_foto_mais'>
										<?=$conteudo[$model]['total_galeria']?>
										<a href='<?=$this->Html->url(
																	array(
																		'controller' => 'conteudos',
																		'action' => 'galeria',
																		$conteudo[$model]['id']
																	));?>'>+</a>
									</td>
									<td class="bt-acoes text-center">
	
										<!-- BOTOES DE ACAO -->
										<a href="<?=$this->Html->url(array('controller' => 'conteudos', 'action' => 'admin_visualizar', $conteudo[$model]['id']))?>" class="radius button action bt_v">Visualizar</a>
										<a href="<?=$this->Html->url(array('controller' => 'conteudos', 'action' => 'admin_edit', $conteudo[$model]['id']))?>" class="radius button action bt_e">Editar</a>
										
										<?=$this->Form->postLink('Excluir',
												array('controller' => 'conteudos', 'action' => 'delete', $conteudo[$model]['id']),
												array('confirm' => 'Tem certeza que deseja excluir este Conteudo?', 'class' => 'radius button action bt_x')
											);
												?>
										<!-- END BOTOES DE ACAO -->
	
									</td>
								</tr>
								<?php 
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
