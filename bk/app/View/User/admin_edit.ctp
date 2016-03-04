<?php
	echo $this->element('validacao_senha_forte');
?>

<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		 <h3 class="titulo-pagina">
			Editar Usuário
			<a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
		 </h3>
	 </div>
 </div>
 <!-- / HEADER DA PÁGINA -->

<div class="row padding-top-20">

<?= $this->Form->create($model, array('type'=>'file', 'data-abide' => '', 'class' => 'col s12'));?>
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('password', array('type' => 'hidden'));
	?>
		<div class="row">
			<div class="input-field col s12">
				<?php
					echo $this->Form->input('name' ,  array(
								'placeholder' => 'Nome',
								'div' => false,
								'id' => 'nome',
								'class' => 'validate',
								'label' => false,
							));

				?>
 				<label for="nome">Nome Completo</label>
 			</div>
 		</div>



 		<div class="row">
 			<div class="input-field col s12">
 				<?php
					echo $this->Form->input('username' ,  array(
								'div' => false,
								'id' => 'nome',
								'class' => 'validate',
								'label' => false,
							));
				?>
 				<label for="username">Username:</label>
 			</div>
 		</div>

 		<div class="row">
 			<div class="input-field col s12">
				<?php
					echo $this->Form->input('newpassword' ,  array(
								'type'	=> 'password',
								'div' => false,
								'id' => 'senha',
								'class' => 'validate',
								'label' => false,
							));
				?>
 				<label for="senha">Senha:</label>
 			</div>
 		</div>

 		<div class="row">
 			<div class="input-field col s12">
				<?php
					echo $this->Form->input('password_verify' ,  array(
								'type'	=> 'password',
								'div' => false,
								'id' => 'senha_confirmacao',
								'class' => 'validate',
								'label' => false,
								'onChange' => 'checkPasswordMatch();'
							));
				?>
				<label for="senha_confirmacao">Confirme a Senha:</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<?php
					echo $this->Form->input('email' ,  array(
								'placeholder' => 'E-mail',
								'div' => false,
								'id' => 'email',
								'class' => 'validate',
								'label' => false,
							));

				?>
 				<label for="email">E-mail</label>
 			</div>
 		</div>

		<?php if ($userAdmin == 1){ ?>
	 		<div class="row">
	 			<div class="file-field input-field col s12">
					<?php
						echo $this->Form->input('empresa_id' ,  array(
									'label' => false,
									'div' => false,
									'type' => 'select',
									'class' => 'validate',
									'options' => $empresasAll,
									'selected' => $this->data['User']['empresa_id'],
									'empty' => ' -- Sem Empresa -- '
								));
					?>
	 				<label>Empresa</label>
	 			</div>
	 		</div>
	 		<div class="row">
	 			<div class="file-field input-field col s12">
					<?php
						echo $this->Form->input('role_id' ,  array(
									'label' => false,
									'div' => false,
									'type' => 'select',
									'class' => 'validate',
									'options' => $rolesAll,
									'selected' => $this->data['User']['role_id'],
								));
					?>
	 				<label>Nível de permissão do usuário</label>
	 			</div>
	 		</div>
		<?php } ?>

 		<div class="row">
 			<div class="input-field col s12">
				<?php
					echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
						'type' => 'submit',
						'div' => true,
						'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
					));
				?>


 				<a href="javascript: void(0);" onclick='window.history.back();' class="waves-effect waves-light btn right red darken-3">
 					<i class="material-icons left">close</i>Cancelar
 				</a>
 			</div>
 		</div>


	<?= $this->Form->end(); ?>
	<!-- Modal Structure -->
		<div id="modalverificaSenha" class="modal">
			<div class="modal-content">
				<h4>Senha Inválida</h4>
			</div>
			<div class="modal-footer">
				<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
			</div>
		</div>
 </div>

	<?php
	$this->start('script');
	?>
		<script type="text/javascript">
			function checkPasswordMatch() {
				var password = $("#senha").val();
				var confirmPassword = $("#senha_confirmacao").val();

				if (password != confirmPassword){
					$('#modalverificaSenha').openModal();
				}
			}

			$(document).ready(function () {
				$('.modal-close').click(function(){
					$('#senha, #senha_confirmacao').val("");
					$('#senha').focus();
				});

			});
		</script>
	<?php
	$this->end();
	?>
