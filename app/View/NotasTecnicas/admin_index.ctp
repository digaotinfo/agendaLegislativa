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
            Notas Tecnicas
			 <?php
 			if ($userAdmin == 1){
 				?>
	             <a href="<?=$this->Html->url(array('controller' => 'notasTecnicas', 'action' => 'add'))?>" class="btn-floating right  green darken-3 tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar um novo arquivo"><i class="material-icons">add</i></a>
				 <?php
			 }
			?>
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
								'placeholder'	=> 'Buscar por Nota Tecnica',

							));
						?>
                        <label for="search"><i class="material-icons">search</i></label>
                        <!-- <i class="material-icons">close</i> -->
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
                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.nome', 'Nome');?></th>
                    <!-- <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.arquivo', 'Arquivo');?></th> -->
                    <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort('Pl.numero_da_pl', 'Proposição');?></th>
                    <th width="150px" data-field="action" class="center-align">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($registros as $registro): ?>
                    <tr>
                        <td>
							<a href="<?=Router::url('/'.$registro[$model]['dir'].'/'.$registro[$model]['arquivo'], true);?>" target="_blank">
								<?=$registro[$model]['nome'];?>
							</a>
						</td>
                        <!-- <td>
							<a href="<?=Router::url('/'.$registro[$model]['dir'].'/'.$registro[$model]['arquivo'], true);?>" target="_blank">
								<?=$registro[$model]['arquivo'];?>
							</a>
						</td> -->
                        <td>
							<?php
								$proposicao = $registro['Pl']['PlType']['tipo'].' '.$registro['Pl']['numero_da_pl'].'/'.$registro['Pl']['ano'];
							?>
							<a href="<?=$this->Html->url(array('controller' => 'pls', 'action' => 'ver_completo', 'admin' => true, $registro['Pl']['id']));?>">
								<?=$proposicao;?>
							</a>
						</td>
                        <td class="center-align">
                            <a href="#modal<?=$registro[$model]['id'];?>" class="btn-floating grey darken-1 tooltipped modal-trigger" data-position="bottom" data-delay="50" data-tooltip="Visualizar Arquivo"><i class="material-icons">pageview</i></a>
							<?php
						   if ($userAdmin == 1){

								echo $this->Html->Link(
									'<i class="material-icons">edit</i>',
									array(
										'controller' => 'notasTecnicas',
										'action' => 'admin_edit',
										$registro[$model]['id']),
									array(
										'class' => 'btn-floating green darken-1 tooltipped margin-right-4',
										'data-position' => 'bottom',
										'data-delay' => 50,
										'data-tooltip' => "Editar Nota Tecnica",
										'escape'=>false
									)
								);

								echo $this->Form->postLink(
									'<i class="material-icons">delete</i>',
									array(
										'controller' => 'notasTecnicas',
										'action' => 'admin_delete',
										$registro[$model]['id']),
									array(
										'confirm' => 'Tem certeza que deseja excluir esta Nota Tecnica?',
										'class' => 'btn-floating red tooltipped',
										'data-position' => 'bottom',
										'data-delay' => 50,
										'data-tooltip' => "Apagar Nota Tecnica",
										'escape'=>false
									)
								);

							}
							?>

                        </td>
                    </tr>
                    <div id="modal<?=$registro[$model]['id'];?>" class="modal">
                        <div class="modal-content">
                            <h4 class="black-text"><?=$registro[$model]['nome'];?></h4>
                            <p>
                                <br><br>
                                <a href="<?=$this->webroot.$registro[$model]['dir'].'/'.$registro[$model]['arquivo'];?>" target="_blank" class="waves-effect waves-light btn green darken-3">
                                    <i class="material-icons left">file_download</i>Baixar <?=$registro[$model]['arquivo'];?>
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
