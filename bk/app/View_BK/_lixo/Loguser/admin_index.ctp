<?php
	//print_r($users);
?>
<div class="medium-9 columns">

	<!--- TEMAS -->
	<div class="row titulo-grid">
		<div class="small-7 columns">
			<h4>LOGINS REALIZADOS</h4>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			<table>
				<thead>
					<tr>
						<th class="hide-for-small"><?=$this->Paginator->sort('id', 'ID');?></th>
						<th width="180"><?=$this->Paginator->sort('created', 'Data');?></th>
						<th width="180"><?=$this->Paginator->sort('User.username', 'Usuário');?></th>
						<th width="100"><?=$this->Paginator->sort('Setor.setor', 'Setor');?></th>
						<th><?=$this->Paginator->sort('Role.title', 'Tipo');?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($users as $registro):
							?>
						<tr>
							<td class="text-center hide-for-small"><?=$registro[$model]['id']?></td>
							<td><?=$this->Time->format($registro[$model]['created'], '%d %m, %Y %H:%M');?></td>
							<td><?=$registro['User']['username']?></td>
							<td><?=$registro['Setor']['setor']?></td>
							<td><?=$registro['Role']['title']?></td>
						</tr>
						<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- END TEMAS -->
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