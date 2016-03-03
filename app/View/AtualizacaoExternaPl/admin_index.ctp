<?php
$this->start('css');
?>
<style media="screen">
	.atualizacao-email .bold{
		font-weight: 900;
		font-size: 17px;
		color: #272323;
		background-color: #EFE8E8;
	}
	.atualizacao-email td{
		background-color: #ffffff;
	}
</style>
<?php
$this->end();
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
            Atualizações Externas
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
								'placeholder'	=> 'Buscar Atualizações',

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

<div class="row padding-top-20 atualizacao-email">
    <div class="col s12">

        <table class="striped">
            <thead>
                <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.remetente', 'Remetente');?></th>
                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.assunto', 'Assunto');?></th>
                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.lido', 'Lido');?></th>
                    <th width="150px" data-field="action" class="center-align">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($registros as $registro):
						$classBold = '';
						if( $registro[$model]['lido'] == 0 ){
							$classBold = 'bold';
						}
					?>
                    <tr>
                        <td class="<?php echo $classBold;?>"><?=$registro[$model]['remetente'];?></td>
                        <td class="<?php echo $classBold;?>"><?=$registro[$model]['assunto'];?></td>
						<td class="<?php echo $classBold;?>"	>
                            <?php
                                $icon = '';
                                if($registro[$model]['lido'] == 1){
                                    $icon = 'done';
                                }else{
                                    $icon = 'not_interested';
                                }
                            ?>
                            <i class="material-icons"><?php echo $icon; ?></i>
                        </td>
                        <td class="center-align <?php echo $classBold;?>">
                            <a href="<?php
										echo $this->Html->url(array(
															'controller' => 'AtualizacaoExternaPls',
															'action' => 'admin_verAtualizacao',
															$registro[$model]['id'])); ?>" class="btn-floating green darken-1 margin-right-4">
                                <i class="material-icons">search</i>
                            </a>
                        </td>
                    </tr>

                    <!-- <div id="modal<?php echo $registro[$model]['id']?>" class="modal">
                        <div class="modal-content">
                            <h4><?php echo $registro[$model]['tipo']?></h4>
                            <p><strong>De onde: </strong><?php echo $registro[$model]['remetente']?></p>
                            <p><strong>Proposição: </strong><?php echo $registro[$model]['tipo'].' '. $registro[$model]['numero_da_pl'].'/'.$registro[$model]['ano'];?></p>
                            <p><strong>Data: </strong><?php echo $registro[$model]['data_atualizacao_terceiros']?></p>
                            <p><strong>Ações: </strong><?php echo $registro[$model]['txt_atualizacao']?></p>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
                        </div>
                     </div> -->

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
