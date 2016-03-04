<?php
//print_r($schemaTable);
$this->start('script');
	//echo $this->Html->script('ajaxupload.3.5.js');
$this->end();
?>
<!--- FORM -->

	<div class="row titulo-grid">
		<div class="small-7 columns">
			<h4>EDITAR TÓPICO</h4>
		</div>
		<div class="small-5 columns">
			<a href="<?=$this->Html->url(array('controller' => 'index', 'action' => 'index'));?>" class="radius button secondary right tiny bt-talkinghub">Voltar</a>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			
			
			<?= $this->Form->create($model, array('type'=>'file', 'data-abide' => ''));?>
				<?= $this->Form->input('id', array('type' => 'hidden'));?>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="assunto_id-field">
							<label class="small-12 medium-1 columns isolado">
								<span data-tooltip class="has-tip" title="Tema que irá pertencer este tópico.">
									Tema
									<small class="alert">*</small>
								</span>
							</label>
							<div class="small-12 medium-11 columns">
								<?=$this->Form->input('tema_id', array(
																'label' => false,
																'div' => false, 
																'type' => 'select',
																'default' => $temas,
															));?>
							</div>
							
						</div>
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<div class="topico_ptbr-field">
							<?=$this->Form->input('topico_ptbr', $options = array(
																			'label' => 'Tópico | PTBR',
																			'div' => false, 
																			'after' => 'Informe o Tópico em português',
																		));?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="topico_eng-field">
							<?=$this->Form->input('topico_eng', $options = array(
																			'label' => 'Tópico | ENG',
																			'div' => false, 
																			'after' => 'Informe o Tópico em inglês',
																		));?>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="topico_esp-field">
							<?=$this->Form->input('topico_esp', $options = array(
																			'label' => 'Tópico | ESP',
																			'div' => false, 
																			'after' => 'Informe o Tópico em espanhol',
																		));?>
						</div>
					</div>
				</div>
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<label data-bar>
							<span>
							Texto | PT-BR <small class="alert">*</small>
							</span>
						</label>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="texto_ptbr-field">
							<?=$this->Form->input('texto_ptbr', $options = array(
																		'label' => false,
																		'div' => false, 
																		'after' => 'Informe o Texto em português',
																	));?>
						</div>
					</div>
				</div>
				<div class="row"><div class="small-12 columns">&nbsp;</div></div>
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<label data-bar>
							<span>
							Texto | ENG
							</span>
						</label>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="texto_eng-field">
							<?=$this->Form->input('texto_eng', $options = array(
																		'label' => false,
																		'div' => false, 
																		'after' => 'Informe o Texto em Inglês',
																	));?>
						</div>
					</div>
				</div>
				<div class="row"><div class="small-12 columns">&nbsp;</div></div>
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<label data-bar>
							<span>
							Texto | ESP
							</span>
						</label>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<div class="texto_esp-field">
							<?=$this->Form->input('texto_esp', $options = array(
																		'label' => false,
																		'div' => false, 
																		'after' => 'Informe o Texto em Espanhol',
																	));?>
						</div>
					</div>
				</div>
				<div class="row"><div class="small-12 columns">&nbsp;</div></div>
				
				
				
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<label data-bar>
							<span>
							Adicionar Imagens
							</span>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<p class="italic between">
							Para que o aplicativo consiga mostrar as imagens corretamente, renomeie-as, de forma a não usar nenhum tipo de caracter especial ou espaço, por exemplo: 
							ao invés de "Imagem de Ação Quinta-Feira.png", use "imagem_de_acao_quinta_feira.jpg".
						</p>
					</div>
				</div>
				
				
				
				
				<div class="row">
					<div class="small-12 columns">
						<h6>Imagem em Português</h6>
					</div>
					<div class="small-12 columns">
						<?php
						echo $this->element('admin_input_file_img', array(
																		'coluna_banco' => 'ilustracao_ptbr',
																		'label' => 'Imagem PTBR:'
																	));
						?>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<h6>Imagem em Inglês</h6>
					</div>
					<div class="small-12 columns">
						<?php
						echo $this->element('admin_input_file_img', array(
																		'coluna_banco' => 'ilustracao_eng',
																		'label' => 'Imagem ENG:'
																	));
						?>
					</div>
				</div>
				
				<div class="row">
					<div class="small-12 columns">
						<h6>Imagem em Espanhol</h6>
					</div>
					<div class="small-12 columns">
						<?php
						echo $this->element('admin_input_file_img', array(
																		'coluna_banco' => 'ilustracao_esp',
																		'label' => 'Imagem ESP:'
																	));
						?>
					</div>
				</div>
				<div class="row"><div class="small-12 columns">&nbsp;</div></div>
				
				
				
				
				
				<div class="small-3 columns">
					<div class="ordem-field">
						<?=$this->Form->input('ordem', $options = array(
																		'type' => 'number',
																		'label' => 'Ordem',
																		'div' => false, 
																		'default' => 1,
																	));?>
					</div>
				</div>
				
				<div class="small-9 columns">
					<div class="ativo-field">
						<label>Ativo</label>
						<?=$this->Form->input('ativo', $options = array(
																		'label' => false,
																		'div' => false, 
																		'default' => 1,
																	));?>
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