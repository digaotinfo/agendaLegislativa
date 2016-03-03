<?php 
//print_r($this->request->data); 

?>
<div class="small-12 columns ">
		<div class="row titulo-grid">
			<div class="small-12 columns">
				<h4>Editar Configurações do site</h4>
			</div>
			
		</div>
		<div class='row'>
			<div class='medium-12 columns'>
				<div class='row'>
					<div class='medium-12 columns'>
						<?=$this->Form->create($model, array('type' => 'post'))?>
							<?=$this->Form->input('id', array('type' => 'hidden'))?>

							<br>
							<h5>Configurações de Meta Tags para o Google</h5>
							<?= $this->Form->input('tag_title' ,  array(
												'label' => 'Tag Title',
												'between' => '<small>Responsável pelo título do site</small>',
												'placeholder' => 'Nome do Site',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('tag_keywords' ,  array(
												'label' => 'Tag Keywords',
												'between' => '<small>
																Palavras chave que ajudarão nas buscas no Google.<br>
																<span class="alert-text">OBS.: Deverão ser separadas por virgula</span>
															</small>',
												'div' => true,
												'placeholder' => 'café, vendas, ofertas, produtos, agilidade',
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('tag_description' ,  array(
												'label' => 'Tag Description',
												'between' => '<small>
																Um texto descritivo curto que define o seu site.<br>
															</small>',
												'div' => true,
												'placeholder' => 'A pioneira em vendas de café on-line...',
												'class' => 'medium-8 columns',
											)); ?>

							<div class="row">
								<div class="small-12 columns">
									<label>Imagem para o Facebook</label>
									<small>Esta imagem aparecerá no Facebook caso algum usuário faça uma publicação de uma página do seu site.</small>
								</div>
								<div class="small-12 columns">
									<?php
									echo $this->element('admin_input_file_img', array(
																					'acao' => 'edit',
																					'coluna_banco' => 'facebook_logo',
																					'label' => false
																				));
									?>
								</div>
							</div>


							<hr>

							<br>
							<h5>Configurações de e-mail para disparo do formulário de contato</h5>
							<?= $this->Form->input('email_destinatario' ,  array(
												'label' => 'E-mail de destinatário',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('email_remetente_host' ,  array(
												'label' => 'Host',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('email_remetente' ,  array(
												'label' => 'E-mail que fará o envio',
												'between' => '<small>Deverá ser um e-mail existente</small>',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('email_remetente_senha' ,  array(
												'label' => 'Senha do e-mail que fará o envio',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('email_cc' ,  array(
												'label' => 'E-mail CC',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>

							<hr>


							<br>
							<h5>Endereço das páginas de redes sociais</h5>
							<?= $this->Form->input('url_facebook' ,  array(
												'label' => 'Página do Facebook',
												'placeholder' => 'http://facebook.com/...',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('url_instagram' ,  array(
												'label' => 'Perfil do Instagram',
												'placeholder' => 'http://instagram.com/...',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('url_twitter' ,  array(
												'label' => 'Perfil do Twitter',
												'placeholder' => 'http://twitter.com/...',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>

							<hr>


							<br>
							<h5>
								Telefones, endereços e e-mails da empresa <br>
								<small>Estes dados serão mostrados para o usuário</small>
							</h5>
							<?= $this->Form->input('telefone' ,  array(
												'label' => 'Telefone',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('email_contato' ,  array(
												'label' => 'E-mail para contato',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('endereco_linha_1' ,  array(
												'label' => 'Endereço 1',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>
							<?= $this->Form->input('endereco_linha_2' ,  array(
												'label' => 'Endereço 2',
												'div' => true,
												'class' => 'medium-8 columns',
											)); ?>

							<hr>



							<div class='row'>
								<div class='medium-12 columns'>
									<?= $this->Form->button('Salvar' ,  array(
												'label' => 'Salvar',
												'type' => 'submit',
												'div' => true,
												'class' => 'radius tiny bt-talkinghub right',
											)); ?>
								</div>
							</div>
						<?= $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>

</div>