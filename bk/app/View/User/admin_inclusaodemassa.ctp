<div class="medium-9 columns">

	<div class="row titulo-grid">
		<div class="small-12 columns">
			<h4>Criar Usuário</h4>
			<div class='bt_voltar' onclick='window.history.back();'>
				<div class='img'></div>
				<p>VOLTAR</p>
			</div>
		</div>
	</div>
	<div class="row grid-geral" id="gridTema">
		<div  class="small-12 columns">
			
			
			<?= $this->Form->create($model, array( 'data-abide' => ''));?>
				
				
				
				<div class="row">


					<div class="small-12 columns" id='checkboxes'>
						<h6>SETOR</h6>
						<!--checkbox-->
							<?php
							echo '<p style="color: #616161;">Selecione o(s) Setor(es): </p>';
							echo $this->Form->input('todos', array(   
					                                                'id' => 'empresa',
					                                                'type' => 'checkbox',
					                                                'class' => 'empresas',
					                                                'onChange' => 'todos(this)'
					                                            ));
					        echo '<p></p>';
							echo $this->Form->select('Setor', $setores, array(
																				'id' => 'empresa',
																				'multiple' => 'checkbox',
																			));
							?>
						<!--checkbox -->
						<p></p>
					</div>

					<?php
					/*
					<div class="small-12 columns">
						<div class="email-field">
							< ? php
				                echo $this->Form->input('empresa_id', array(
				                     //'name' => 'data[User][role_id]',
									 'label' => 'Setor',
				                     'type' => 'select',
				                     'options' => array(''=> '-- Selecione a Empresa --', $setores),
				                     //'selected' => $this->data['User']['role_id']
				                ));
							? >
						</div>
					</div>
					*/
					?>
				</div>
				
				
				<div class="row">
					<div class="small-12 columns">
						<div class="name-field">
							<?=$this->Form->input('emails', $options = array(
																			'label' => 'Emails',
																			'between' => 'Insira os e-mails separados apenas por espaço, e não por vírgula',
																			'div' => false, 
																			'type' => 'textarea',
																			'class' => 'notiny',
																			'style' => 'min-height:200px;',
																		));?>
						</div>
					</div>
				</div>
				
				<!--
				<div class="row">
					<div class="small-12 columns">
						<div class="email-field">
							<?php
				                echo $this->Form->input('role_id', array(
				                     //'name' => 'data[User][role_id]',
									 'label' => 'Nível de permissão',
				                     'type' => 'select',
				                     'options' => $rolesAll,
				                     //'selected' => $this->data['User']['role_id']
				                ));
							?>
						</div>
					</div>
				</div>
				-->
				
				
				<div class="row">
					<div class="small-12 columns">
						<?=$this->Form->input('Salvar', $options = array(
																		'type' => 'submit',
																		'label' => false,
																		'div' => false, 
																		'class' => 'button radius right',
																	));?>
					</div>
				</div>
			<?=$this->Form->end();?>
				
			
		</div>
	</div>
</div>