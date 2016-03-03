<?php
	//print_r($users);
?>
<div class="medium-9 columns">

	<!--- TEMAS -->
	<div class="row titulo-grid">
		<div class="small-7 columns">
			<h4>VERSÃO APP ANDROID</h4>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div class="small-12 columns">
			<?php
			if (empty($registro)) {
				?>
				<a href="<?=$this->Html->url(array(
													'action' => 'add',
												));?>" class='button '> Adicionar Versão </a>
				<?php
			} else {
				?>
				<table>
					<thead>
						<tr>
							<th class="hide-for-small">Última Versão</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center hide-for-small"><?=$registro[$model]['versao']?></td>
							<td>
								<a href="<?=$this->Html->url(array(
																'action' => 'edit', $registro[$model]['id']))?>" class="radius button action">
									Editar
								</a>
							</td>
						</tr>
					</tbody>
				</table>
				<?php
			}
			?>
			
		</div>
	</div>
</div>