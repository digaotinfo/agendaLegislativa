<?php
//print_r($schemaTable);
$this->start('script');
	//echo $this->Html->script('ajaxupload.3.5.js');
$this->end();
?>
<!--- FORM -->

	<div class="row titulo-grid">
		<div class="small-7 columns">
			<h4>SUBIR UM ARQUIVO</h4>
                        
		</div>
		<div class="small-5 columns">
			<a href="<?=$this->Html->url(array('controller' => 'index', 'action' => 'index'));?>" class="radius button secondary right tiny bt-talkinghub">Voltar</a>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			
			
			<?= $this->Form->create($model, array('type'=>'file', 'data-abide' => ''));?>
				
				
				<div class="row">
					<div class="small-12 columns">
						<p class="italic between">
							Para que o aplicativo consiga mostrar as imagens/arquivos (links) corretamente, renomeie-as, de forma a não usar nenhum tipo de caracter especial ou espaço, por exemplo: 
							ao invés de "Imagem de Ação Quinta-Feira.png", use "imagem_de_acao_quinta_feira.jpg".
						</p>
					</div>
				</div>
				
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<h6>Arquivo</h6>
					</div>
					<div class="small-12 columns">
						<?php
						echo $this->element('admin_input_file_img', array(
																		'acao' => 'add',
																		'coluna_banco' => 'arquivo',
																		'label' => false
																	));
						?>
					</div>
				</div>
				<div class="row"><div class="small-12 columns">&nbsp;</div></div>
				
				
				
				<div class="small-12 columns">
					<?=$this->Form->input('Salvar', $options = array(
																	'type' => 'submit',
																	'label' => false,
																	'div' => false, 
																	'id' => 'bt_submit',
																	'class' => 'button radius',
																));?>
				</div>
			<?=$this->Form->end();?>
			
			
			
		</div>
	</div>
<!-- END FORM -->