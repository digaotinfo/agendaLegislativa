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
            Status
			 <?php
 			if ($userAdmin == 1){
 				?>
	             <a href="<?=$this->Html->url(array('controller' => 'StatusTypes', 'action' => 'add'))?>" class="btn-floating right  green darken-3 tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar um novo status"><i class="material-icons">add</i></a>
				 <?php
			 }
			?>
         </h3>
     </div>
 </div>
<!-- / HEADER DA PÁGINA -->


<!--- BUSCA -->
<div class="row padding-top-20 ">
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
								'placeholder'	=> 'Buscar Status',

							));
						?>
                        <label for="search"><i class="material-icons">search</i></label>
				<?php echo $this->Form->end() ?>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</div>
<!--- / BUSCA -->

<div class="row padding-top-20 arquivos">
    <div class="col s12">

        <table class="striped">
            <thead>
                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.status_name', 'Status');?></th>
                    <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.exigir_justificativa', 'Exigir Justificativa');?></th>
                    <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.ativo', 'Ativo');?></th>
                    <th width="150px" data-field="action" class="center-align">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($registros as $registro): ?>
                    <tr>
                        <td><?=$registro[$model]['status_name'];?></td>
                        <td>
                            <?php
                                $icon2 = '';
                                if($registro[$model]['exigir_justificativa'] == 1){
                                    $icon2 = 'done';
                                }else{
                                    $icon2 = 'not_interested';
                                }
                            ?>
                            <i class="material-icons"><?php echo $icon2; ?></i>
                        </td>
                        <td>
                            <?php
                                $icon = '';
                                if($registro[$model]['ativo'] == 1){
                                    $icon = 'done';
                                }else{
                                    $icon = 'not_interested';
                                }
                            ?>
                            <i class="material-icons"><?php echo $icon; ?></i>
                        </td>
                        <td class="center-align">
							<?php
						   if ($userAdmin == 1){

								echo $this->Html->Link(
									'<i class="material-icons">edit</i>',
									array(
										'controller' => 'StatusTypes',
										'action' => 'admin_edit',
										$registro[$model]['id']),
									array(
										'class' => 'btn-floating green darken-1 tooltipped margin-right-4',
										'data-position' => 'bottom',
										'data-delay' => 50,
										'data-tooltip' => "Editar Status",
										'escape'=>false
									)
								);

								echo $this->Form->postLink(
									'<i class="material-icons">delete</i>',
									array(
										'controller' => 'StatusTypes',
										'action' => 'admin_delete',
										$registro[$model]['id']),
									array(
										'confirm' => 'Tem certeza que deseja excluir este Status?',
										'class' => 'btn-floating red tooltipped',
										'data-position' => 'bottom',
										'data-delay' => 50,
										'data-tooltip' => "Apagar Status",
										'escape'=>false
									)
								);

							}
							?>

                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>

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
