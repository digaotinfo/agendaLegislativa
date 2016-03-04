<?php
echo $this->Html->css('scaffold');
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
<div class="<?php echo $pluralVar;?> index">
<h2><?php echo $pluralHumanName;?></h2>
<table cellpadding="0" cellspacing="0">

<!--
<tr>
<?php foreach ($scaffoldFields as $_field):?>
	<th><?php echo $this->Paginator->sort($_field);?></th>
<?php endforeach;?>
	<th><?php echo __d('cake', 'Acoes');?></th>
</tr>
-->

<?php
	if(!isSet($fieldToImg)) {
		$fieldToImg = array();
	}

	if(!isSet($showFields)) {
		foreach($scaffoldFields as $fieldName) {
			$showFields[$fieldName] = $fieldName;
		}
	}
?>

<tr>
<?php foreach ($showFields as $fieldKey => $customFields):?>
	<th><?php echo $this->Paginator->sort($customFields);?></th>
<?php endforeach;?>
	<th><?php echo __d('cake', 'Acoes');?></th>
</tr>


<?php
$i = 0;
foreach (${$pluralVar} as ${$singularVar}):
	echo "<tr>";
		//foreach ($scaffoldFields as $_field) {
		foreach ($showFields as $_field => $value) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $_alias => $_details) {
					if ($_field === $_details['foreignKey']) {
						$isKey = true;
						if(!in_array($_field, $fieldToImg)) {
							echo "<td>" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "</td>";
						} else {
							echo 'converter';
						}
						break;
					}
				}
			}
			if ($isKey !== true) {
				if(!in_array($_field, $fieldToImg)) {
					//echo "<td>[]" .${$singularVar}[$modelClass][$_field] . "</td>";
					
					$campo_nome = $_field;
					$model_nome	= $modelClass;
					
					if (strrpos($_field, '.')):
						$a_field = explode('.', $_field);
						
						$model_nome	= $a_field[0];
						$campo_nome = $a_field[1];
					endif;
					
					
					echo "<td>";
						if (!empty($schemaTable)):
							//echo '___'. $schemaTable[$campo_nome]['type'] .'___';
							
							if (!empty($schemaTable[$campo_nome]['type'])):
								if ($schemaTable[$campo_nome]['type'] == 'boolean'):
									if (${$singularVar}[$model_nome][$campo_nome] == 1):
										echo '&radic;';
									else:
										echo '';
									endif;
								else:
									echo ${$singularVar}[$model_nome][$campo_nome];
								endif;
							else:
								echo ${$singularVar}[$model_nome][$campo_nome];
							endif;
						else:
							echo ${$singularVar}[$model_nome][$campo_nome];
						endif;
					echo "</td>";
				} else {
					$convertImage = '';
					
					if(h(${$singularVar}[$modelClass][$_field])!='') {
						$convertImage = '<img src="'.$this->webroot . h(${$singularVar}[$modelClass][$_field]).'" alt="" />';
					}
					
					echo '<td>'. $convertImage .'</td>';
				}
			}
		}

		echo '<td class="actions">';
		echo $this->Html->link(__d('cake', 'Visualizar'), array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey]));
		echo $this->Html->link(__d('cake', 'Editar'), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]));
		echo $this->Form->postLink(
			__d('cake', 'Deletar'),
			array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
			null,
			__d('cake', 'Tem certeza que deseja excluir esse registro?')
		);
		echo '</td>';
	echo '</tr>';

endforeach;

?>
</table>
	<p><?php
	//echo $this->Paginator->counter(array(
	//	'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	//));
	?></p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __d('cake', 'Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__d('cake', 'Proximo') .' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<?php
//if ($userAdmin == 1):
	?>
	<div class="actions">
		<h3><?php echo __d('cake', 'Açoes'); ?></h3>
		<ul>
			<li><?php echo $this->Html->link(__d('cake', 'Adicionar %s', $singularHumanName), array('action' => 'add')); ?></li>
			<?php
			$done = array();
			foreach ($associations as $_type => $_data) {
				foreach ($_data as $_alias => $_details) {
					if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
						echo "<li>" . $this->Html->link(__d('cake', 'Listar %s', Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index')) . "</li>";
						echo "<li>" . $this->Html->link(__d('cake', 'Adicionar %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add')) . "</li>";
						$done[] = $_details['controller'];
					}
				}
			}
			?>
		</ul>
	</div>
	<?php
//endif;
