<?php
$this->start('script');
	?>
	<script charset="utf-8">
		$('.modal-trigger').leanModal();
	</script>
	<?php
$this->end();
?>
<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		 <h3 class="titulo-pagina">
			 Usuários cadastrados

			 <a href="<?=$this->Html->url(array('controller' => 'user', 'action' => 'add'))?>" class="btn-floating right  green darken-3 tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar um novo usuário"><i class="material-icons">add</i></a>
		 </h3>
	 </div>
 </div>
<!-- / HEADER DA PÁGINA -->


<!--- BUSCA -->
<div class="row padding-top-20">
	<div class="col s12">

		<nav class="grey darken-2">
			<div class="nav-wrapper">
				<?php echo $this->Form->create($model); ?>
                    <div class="input-field">
						<?php
							echo $this->Form->input('search', array(
								'type' 	=> 'search',
								'label' => false,
								'div'	=> false,
								'class'	=> 'search',
								'id'	=> 'search',
								'placeholder'	=> 'Buscar Usuario',

							));
						?>
                        <label for="search"><i class="material-icons">search</i></label>
                    </div>
				<?php echo $this->Form->end() ?>
			</div>
		</nav>
	</div>
</div>
<!--- / BUSCA -->



<div class="row padding-top-20">
	<div class="col s12">

		<table class="striped">
			<thead>
				<tr>
					<th data-field="nome"><?=$this->Paginator->sort('username', 'Usuário');?></th>
					<th data-field="arquivp"><?=$this->Paginator->sort('Role.title', 'Tipo');?></th>
					<th width="130px" data-field="action" class="center-align">Ações</th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($users as $registro): ?>
					<tr>
						<td><?=$registro[$model]['username']?></td>
						<td><?=$registro['Role']['title']?></td>
						<td align="center">
							<a href="#modal<?=$registro[$model]['id']?>" class="btn-floating grey darken-1 tooltipped modal-trigger" data-position="bottom" data-delay="50" data-tooltip="Visualizar Usuário"><i class="material-icons">pageview</i></a>

							<a href="<?php echo $this->Html->url(array(
																		'controller' => 'user',
																		'action' => 'edit',
																		'admin' => true,
																		$registro[$model]['id']
																	))?>" class="btn-floating green darken-1 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Editar Usuário"><i class="material-icons">edit</i></a>

							<?php
								echo $this->Form->postLink(
									'<i class="material-icons">delete</i>',
									array(
										'controller' => 'user',
										'action' => 'admin_delete',
										$registro[$model]['id']),
									array(
										'confirm' => 'Tem certeza que deseja excluir este Usuário?',
										'class' => 'btn-floating red tooltipped',
										'data-position' => 'bottom',
										'data-delay' => 50,
										'data-tooltip' => "Apagar Usuário",
										'escape'=>false
									)
								);
							?>
						</td>
					</tr>
					<div id="modal<?=$registro[$model]['id']?>" class="modal">
						<div class="modal-content">
							<h4 class="black-text"><?=$registro[$model]['name']?></h4>
							<p>
								<strong>Username: </strong> <?=$registro[$model]['username']?><br>
								<strong>E-mail: </strong> <?=$registro[$model]['email']?><br>
								<strong>Nível de permissão: </strong> <?=$registro['Role']['title']?><br>
								<strong>Empresa: </strong> <?=$registro['Empresa']['nome']?><br>

								<br><br>
								<a href="#" class="waves-effect waves-light btn green darken-3">
									<i class="material-icons left">send</i>enviar por e-mail
								</a>
							</p>
						</div>
							<div class="modal-footer">
								<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
							</div>
					</div>
				<?php endforeach; ?>

			</tbody>
		</table>

	</div>
</div>
<!-- / MIOLO -->


<ul class="pagination ">
	<?php
	    if($this->params->paging[$model]['pageCount'] > 1):
	        echo $this->Paginator->prev(
	                '<i class="material-icons">chevron_left</i>',
	                array('tag' => 'li', 'escape' => false),
	                '',
	                array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false
	            )
	        );


	        $numbers = $this->Paginator->numbers(array(
	                                        'separator' => '',
	                                        'currentClass' => 'active',
	                                        'tag' => 'li',
	        								));
	        $numbers = preg_replace("#\<li class=\"active\"\>([0-9]+)\<\/li\>#", "<li class=\"active\"><a href=''>$1</a></li>",$numbers);
	        echo $numbers;


	        echo $this->Paginator->next(
	            '<i class="material-icons">chevron_right</i>',
	            array('tag' => 'li', 'escape' => false),
	            '',
	            array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false
	        ));
	    endif;
	?>
</ul>
