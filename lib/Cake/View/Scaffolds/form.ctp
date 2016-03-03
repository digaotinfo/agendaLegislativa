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
<div class="<?php echo $pluralVar;?> form">
<?php
	//die(print_r($scaffoldFields));
	echo $this->Form->create($modelClass, array('enctype' => 'multipart/form-data', 'data-abide' => ''));
	echo $this->Form->inputs( $scaffoldFields, array('created', 'modified', 'updated'), $zInput);
	echo $this->Form->end(__d('cake', 'Enviar'));
?>
</div>

<?php
if ($userAdmin == 1):
	?>
	<div class="actions">
		<h3><?php echo __d('cake', 'Acoes'); ?></h3>
		<ul>
	<?php if ($this->request->action != 'add'): ?>
			<li><?php echo $this->Form->postLink(
				__d('cake', 'Deletar'),
				array('action' => 'delete', $this->Form->value($modelClass . '.' . $primaryKey)),
				null,
				__d('cake', 'Are you sure you want to delete # %s?', $this->Form->value($modelClass . '.' . $primaryKey)));
			?></li>
	<?php endif;?>
			<li><?php echo $this->Html->link(__d('cake', 'Listar') . ' ' . $pluralHumanName, array('action' => 'index'));?></li>
			
			<?php
			$done = array();
			foreach ($associations as $_type => $_data) {
				foreach ($_data as $_alias => $_details) {
					if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
						echo "\t\t<li>" . $this->Html->link(__d('cake', 'Listar %s', Inflector::humanize($_details['controller'])), array('controller' => $_details['controller'], 'action' => 'index')) . "</li>\n";
						echo "\t\t<li>" . $this->Html->link(__d('cake', 'Adicionar %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add')) . "</li>\n";
						$done[] = $_details['controller'];
					}
				}
			}
			?>
		</ul>
	</div>
	<?php
endif;
