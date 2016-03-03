<?php ?>
	<h1> Arquivos </h1>
	<div id="conteudo_form">
		<?php echo $this->Html->link('[Novo arquivo]', array('action' => 'uploads')); ?>
		<br><br>

        <table>
            <tr>
                <th>Arquivo</th>
                <th>Url do arquivo</th>
                <th>&nbsp;</th>
            </tr>

            <?php 
			foreach ($registros as $registro): 
				?>
                <tr>
                    <td>
			<?php $pos_string = strrpos($registro[$model]['arquivo'], '/'); ?>
                 <?php echo $pos_string = substr($registro[$model]['arquivo'], $pos_string+1); ?>
                        <?php //  echo $registro[$model]['arquivo']; ?>
                    	
                    </td>
                    
                    <td><?= Router::url('/'.$registro[$model]['arquivo'], true)  ; ?></td>
                    <!--<td><?//= Router::url('/uploads/arquivos/'.$registro[$model]['arquivo'], true)  ; ?></td>-->
                    
                    <td>
						<?php
						echo $this->Form->postLink('[apagar]',
							array('action' => 'delete', $registro[$model]['id']),
							array('confirm' => 'Tem certeza?'));
						?>
					</td>
				</tr>
            	<?php 
			endforeach; 
			?>
		</table>
		
		<?=$this->Paginator->numbers();?>

    </div>
