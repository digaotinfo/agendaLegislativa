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
            Tipos Fluxograma
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
								'placeholder'	=> 'Buscar Tipo',

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
                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.tipo', 'Tipo');?></th>
                    <th width="150px" data-field="action" class="center-align">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php
					foreach($registros as $registro):
						if( count($registro['FluxogramaEtapa']) >= 1 ){
							?>
		                    <tr>
		                        <td><?=$registro[$model]['tipo'];?></td>
		                        <td class="center-align">
									<?php
								   if ($userAdmin == 1){

										// echo $this->Html->Link(
										// 	'<i class="material-icons">edit</i>',
										// 	array(
										// 		'controller' => 'Fluxogramas',
										// 		'action' => 'admin_fluxoEtapasList',
										// 		$registro[$model]['id']),
										// 	array(
										// 		'class' => 'btn-floating green darken-1 tooltipped margin-right-4',
										// 		'data-position' => 'bottom',
										// 		'data-delay' => 50,
										// 		'data-tooltip' => "Editar Tipo",
										// 		'escape'=>false
										// 	)
										// );
									}

		                            echo $this->Html->Link(
		                                '<i class="material-icons">search</i>',
		                                array(
		                                    'controller' => 'Fluxogramas',
		                                    'action' => 'admin_fluxoGeralVerGeral',
		                                    $registro[$model]['id']),
		                                array(
		                                    'class' => 'btn-floating green darken-1 tooltipped margin-right-4',
		                                    'data-position' => 'bottom',
		                                    'data-delay' => 50,
		                                    'data-tooltip' => "Ver Fluxograma",
		                                    'escape'=>false
		                                )
		                            );

									?>

		                        </td>
		                    </tr>
                			<?php
						}
					endforeach;
				?>

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
