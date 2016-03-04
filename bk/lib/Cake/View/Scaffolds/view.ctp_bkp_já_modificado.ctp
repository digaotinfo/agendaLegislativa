<?php
//echo $this->Html->css('scaffold');
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

	<div class="row titulo-grid">
		<div class="medium-8 small-12 columns">
			<h4><?php echo __d('cake', 'Visualizar %s', $singularHumanName); ?></h4>
		</div>
		<div class="medium-4 small-12 columns">
			<a href="<?=$this->Html->url(array('action' => 'index'));?>" class="radius button secondary expand right tiny bt-talkinghub">
				Voltar
			</a>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			<?php
			$i = 0;
			foreach ($scaffoldFields as $_field) {
				$isKey = false;
				if (!empty($associations['belongsTo'])) {
					foreach ($associations['belongsTo'] as $_alias => $_details) {

						/// Para campos com relacionamento
						if ($_field === $_details['foreignKey']) {
							$isKey = true;
							echo "\t\t<div class='small-5 medium-4 columns borda-abaixo'>" . Inflector::singularize(Inflector::humanize( Inflector::tableize($_alias) )) . ": </div>\n";
							echo "\t\t<div class='small-7 medium-8 columns borda-abaixo'>\n\t\t\t" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "\n\t\t&nbsp;</div>\n";
							break;
						}
					}
				}
				
				/// Para campos SEM relacionamento
				if ($isKey !== true) {		
					echo "\t\t<div class='small-5 medium-4 columns borda-abaixo'>" . Inflector::humanize($_field) . ": </div>\n";
					//echo "\t\t<dd>" . h(${$singularVar}[$modelClass][$_field]) . "&nbsp;</dd>\n";

					if (!empty($schemaTable[$_field]['type'])):
						if ($schemaTable[$_field]['type'] == 'boolean'):
							if (${$singularVar}[$modelClass][$_field] == 1):
								$campo_value = '&radic;';
							else:
								$campo_value = '';
							endif;
						else:
							$campo_value = ${$singularVar}[$modelClass][$_field];
						endif;
					else:
						$campo_value = ${$singularVar}[$modelClass][$_field];
					endif;

					//echo "\t\t<div class='small-7 medium-8 columns borda-abaixo'>" . ${$singularVar}[$modelClass][$_field] . "&nbsp;</div>\n";
					echo "\t\t<div class='small-7 medium-8 columns borda-abaixo'>" . $campo_value . "&nbsp;</div>\n";
				}
			}
			?>
		</div>
	</div>



	<div class="row titulo-grid">
		<div class="small-12 columns titulo-grid">
			<h4>Ações</h4>
		</div>
		<div class="small-12 columns text-center">
			<a href="<?=$this->Html->url(array(
												'action' => 'edit', 
												${$singularVar}[$modelClass][$primaryKey]
										));?>" class="radius button secondary tiny bt-talkinghub">
				Editar <?=$singularHumanName?>
			</a>

			<?php
			echo $this->Form->postLink('Deletar '. $singularHumanName,
				array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
				array('confirm' => 'Tem certeza que deseja excluir este Tema?', 'class' => 'radius button alert secondary tiny bt-talkinghub')
			);
			?>
			<a href="<?=$this->Html->url(array(
												'action' => 'index', 
										));?>" class="radius button secondary tiny bt-talkinghub">
				Listar <?=$pluralHumanName?>
			</a>

			<a href="<?=$this->Html->url(array(
												'action' => 'add', 
										));?>" class="radius button secondary tiny bt-talkinghub">
				Adicionar novo <?=$singularHumanName?>
			</a>
		</div>
	</div>


	<?php
	$done = array();
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {

			if ($_details['controller'] != 'users') {
				?>
				<div class="row">
					<div class="small-12 columns">
						<div class="small-12 columns titulo-grid">
							<br>
							<br>
							<h4><?=Inflector::humanize($_details['controller']);?></h4>
						</div>
						<?php
						if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {

							?>
							<a href="<?=$this->Html->url(array(
																'controller' => $_details['controller'], 
																'action' => 'index',
														));?>" class="radius button secondary tiny bt-talkinghub">
								Listar <?=Inflector::humanize($_details['controller']);?>
							</a>

							<a href="<?=$this->Html->url(array(
																'controller' => $_details['controller'], 
																'action' => 'add',
														));?>" class="radius button secondary tiny bt-talkinghub">
								Adicionar <?=Inflector::humanize(Inflector::underscore($_alias));?>
							</a>
							<?php
							$done[] = $_details['controller'];
						}
						?>
					</div>
				</div>
				<?php
			}
		}
	}
	?>




	<?php
	if (!empty($associations['hasOne'])) :
		foreach ($associations['hasOne'] as $_alias => $_details): 
			?>
			<div class="row">
				<div class="small-12 columns">
					<h4><?php echo __d('cake', "%s Relacionados", Inflector::humanize($_details['controller'])); ?></h4>
					<?php 
					if (!empty(${$singularVar}[$_alias])):
						?>
						<dl>
							<?php
							$i = 0;
							$otherFields = array_keys(${$singularVar}[$_alias]);
							foreach ($otherFields as $_field) {
								echo "\t\t<div class='small-5 medium-4 columns borda-abaixo'>" . Inflector::humanize($_field) . "</div>\n";
								echo "\t\t<div class='small-7 medium-8 columns borda-abaixo'>\n\t" . ${$singularVar}[$_alias][$_field] . "\n&nbsp;</div>\n";
							}
							?>
						</dl>
						<?php 
					endif; 
					?>
					<div class="row titulo-grid">
						<div class="small-12 columns titulo-grid">
							<h4>Ações</h4>
						</div>
						<div class="small-12 columns text-center">
							<a href="<?=$this->Html->url(array(
																'controller' => $_details['controller'],
																'action' => 'edit', 
																${$singularVar}[$_alias][$_details['primaryKey']]
														));?>" class="radius button secondary tiny bt-talkinghub">
								Editar <?=Inflector::humanize(Inflector::underscore($_alias))?>
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php
		endforeach;
	endif;

	if (empty($associations['hasMany'])) {
		$associations['hasMany'] = array();
	}
	if (empty($associations['hasAndBelongsToMany'])) {
		$associations['hasAndBelongsToMany'] = array();
	}
	$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
	$i = 0;
	foreach ($relations as $_alias => $_details):
		$otherSingularVar = Inflector::variable($_alias);
		?>
		<div class="row titulo-grid">
			<div class="medium-8 small-12 columns">
				<h4><?php echo __d('cake', "%s Relacionados", Inflector::humanize($_details['controller'])); ?></h4>
			</div>
			<div class="medium-4 small-12 columns">
				<a href="<?=$this->Html->url(array(
													'controller' => $_details['controller'],
													'action' => 'add', 
											));?>" class="radius button secondary expand right tiny bt-talkinghub">
					Adicionar <?=Inflector::humanize(Inflector::underscore($_alias));?>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<?php 
				if (!empty(${$singularVar}[$_alias])):
					?>
					<table cellpadding="0" cellspacing="0">
						<tr>
							<?php
							$otherFields = array_keys(${$singularVar}[$_alias][0]);
							if (isset($_details['with'])) {
								$index = array_search($_details['with'], $otherFields);
								unset($otherFields[$index]);
							}
							foreach ($otherFields as $_field) {
								echo "\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
							}
							?>
							<th class="actions">Acoes</th>
						</tr>
						<?php
						$i = 0;
						foreach (${$singularVar}[$_alias] as ${$otherSingularVar}):
							?>
							<tr>
								<?php

								foreach ($otherFields as $_field) {
									echo "\t\t\t<td>" . ${$otherSingularVar}[$_field] . "</td>\n";
								}

								?>

								<td class="bt-acoes text-center">
									<!-- BOTOES DE ACAO -->
									<a href="<?=$this->Html->url(array(
																	'controller' => $_details['controller'], 
																	'action' => 'view', 
																	${$otherSingularVar}[$_details['primaryKey']]
																))?>" class="radius button action">Visualizar</a>
									<a href="<?=$this->Html->url(array(
																	'controller' => $_details['controller'], 
																	'action' => 'view', 
																	${$otherSingularVar}[$_details['primaryKey']]
																))?>" class="radius button action">Editar</a>
									<?php
									echo $this->Form->postLink('Excluir',
										array(
											'controller' => $_details['controller'], 
											'action' => 'delete', 
											${$otherSingularVar}[$_details['primaryKey']]
										),
										array('confirm' => 'Tem certeza que deseja excluir este Tema?', 'class' => 'radius button action')
									);
									?>
									<!-- END BOTOES DE ACAO -->
								</td>
								<?php
								// echo "\t\t\t<td class=\"actions\">\n";
								// echo "\t\t\t\t" . $this->Html->link(__d('cake', 'Visualizar'), array('controller' => $_details['controller'], 'action' => 'view', ${$otherSingularVar}[$_details['primaryKey']])). "\n";
								// echo "\t\t\t\t" . $this->Html->link(__d('cake', 'Editar'), array('controller' => $_details['controller'], 'action' => 'edit', ${$otherSingularVar}[$_details['primaryKey']])). "\n";
								// echo "\t\t\t\t" . $this->Form->postLink(__d('cake', 'Deletar'), array('controller' => $_details['controller'], 'action' => 'delete', ${$otherSingularVar}[$_details['primaryKey']]), null, 'Tem certeza que deseja excluir esse registro?'). "\n";
								// echo "\t\t\t</td>\n";
								?>
							</tr>
							<?php
						endforeach;
						?>
					</table>
					<?php 
				endif; 
				?>
			</div>
		</div>
		<?php 
	endforeach;
	?>
