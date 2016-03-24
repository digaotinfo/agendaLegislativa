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
			Log de acesso por Usuário
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
					<th data-field="data" width="200"><?=$this->Paginator->sort('url', 'Data');?></th>
					<th data-field="nome"><?=$this->Paginator->sort('username', 'Usuário');?></th>
					<th data-field="arquivp"><?=$this->Paginator->sort('User.Role.title', 'Tipo');?></th>
					<th data-field="url"><?=$this->Paginator->sort('url', 'URL');?></th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($users as $registro): ?>
					<tr>
						<td><?=CakeTime::format($registro[$model]['created'], '%d/%m/%Y às %H:%M');?></td>
						<td><?=$registro['User']['username']?></td>
						<td><?=$registro['User']['Role']['title']?></td>
						<td><?=$registro[$model]['url']?></td>
					</tr>
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
