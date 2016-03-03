<?php
$this->start('script');

$this->end();
?>
<div class="row">

	<div class="col l8 s12 center-align">

		<div class="col m8 offset-m4 offset-l5 valign-wrapper" style="height:600px">
			<div class="card blue-grey lighten-5 valign s12 col">
				<div class="card-content white-text valign-wrapper">
					<div class="col m6 s12 valign">
						<?php echo $this->Html->image('header_logo-abear.png', array('class' => 'responsive-img'));?>
					</div>
					<div class="col m6 s12 valign left-align">
						<span class="card-title grey-text">Agenda Legislativa</span>
					</div>
				</div>

				<?php
				echo $this->Form->create('User', array('data-abide' => '', )); //'class' => 'row espaco-topo'
					?>
					<div class="col s12">
						<div class="input-field col s12">
							<?php
								echo $this->Form->input('username' ,  array(
											'placeholder' => 'usuário',
											'div' => false,
											'id' => 'usuario',
											'class' => 'validate grey-text',
											'label' => false,
										));
										?>
							<label for="usuario" class=" grey-text">Usuário</label>
						</div>
					</div>
					<div class="col s12">
						<div class="input-field col s12">
							<?php
								echo $this->Form->input('password' ,  array(
									'type' => 'password',
									// 'pattern' => '[a-zA-Z]+',
									'label' => false,
									'div' => false,
									'id' => 'senha',
									'class' => 'validate grey-text',
									'placeholder' => 'senha'
								));
								?>
							<label for="senha" class=" grey-text">Senha</label>
						</div>
					</div>

					<div class="col s12">
						<div class="input-field col s12 right-align">
							<?= $this->Form->button('Entrar' ,  array(
												'label' => 'Entrar',
												'type' => 'submit',
												'div' => true,
												'class' => 'btn waves-effect waves-light green darken-3',
											)); ?>
						</div>
					</div>
					<div class="col s12">&nbsp;</div>
					<?php
				echo $this->Form->end;
				?>
			</div>

		</div>


	</div>

</div>
