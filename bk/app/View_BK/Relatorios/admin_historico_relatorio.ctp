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
            Histórico de Relatórios
         </h3>
     </div>
 </div>
<!-- / HEADER DA PÁGINA -->


<!--- BUSCA -->
<div class="row padding-top-20 hide">
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
                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.nome_relatorio', 'Nome');?></th>
                    <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.usuario_name', 'Usuário');?></th>
                    <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.created', 'Gerado');?></th>
                    <th width="150px" data-field="action" class="center-align">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($registros as $registro): ?>
                    <tr>
                        <td>
                        	<?php 
                        		echo $registro[$model]['nome_relatorio'];
                        	?>
                        </td>
                        <td>
                            <?php    
                                echo $registro[$model]['usuario_name'];
                            ?>
                        </td>
                        <td>
                            <?php
                            	echo CakeTime::format($registro[$model]['created'], '%d/%m/%Y às %H:%m');
                            ?>
                        </td>
                        <td class="center-align">
							<?php
						   		if ($userAdmin == 1){
	                        		?>
		                        	<a class="btn waves-effect  btn-floating tooltipped" href="<?php echo Router::url('/'.$registro[$model]['url'], true);?>" data-position='bottom' data-delay='50' data-tooltip="Baixar Relatório" target="_blank">
		                        		<i class="material-icons right">file_download</i>
		                        	</a>
							
									<?php
									echo $this->Form->postLink(
										'<i class="material-icons">delete</i>',
										array(
											'controller' => 'Relatorios',
											'action' => 'delete',
											'admin' => true,
											$registro[$model]['id']),
										array(
											'confirm' => 'Tem certeza que deseja excluir este Relatório?',
											'class' => 'btn-floating red tooltipped',
											'data-position' => 'bottom',
											'data-delay' => 50,
											'data-tooltip' => "Apagar Relatório",
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