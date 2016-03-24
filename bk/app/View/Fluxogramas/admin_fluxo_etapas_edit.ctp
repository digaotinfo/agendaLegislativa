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
			Editar Etapa
			<a href="<?php echo $this->Html->url(array('controller' => 'Fluxogramas', 'action' => 'admin_fluxoEtapasList', $this->request->data['PlType']['id'])); ?>" onclick='window.history.back();'  class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
		</h3>
	 </div>
 </div>
 <!-- / HEADER DA PÁGINA -->


 <div class="row padding-top-20">

    <?= $this->Form->create($model, array('type'=>'file', 'data-abide' => '', 'class' => 'col s12'));?>
        <?php
            echo $this->Form->input('id', array('type' => 'hidden'));
        ?>
        <div class="row">
            <?php
				echo $this->Form->input('pl_type_id' ,  array(
							'label' => false,
							'div' 	=> false,
							'type' 	=> 'hidden'
					));
            ?>
            </div>
            <div class="input-field col s12">
                <?php
                    echo $this->Form->input('etapa' ,  array(
                        'div' => false,
                        'id' => 'etapa',
                        'class' => 'validate',
                        'label' => false,
                        'length' => "100",
                        'maxlength' => "100",
                    ));

                ?>
                <label for="etapa">Nome da Etapa</label>
	        </div>

            <div class="input-field col s12">
                <?php
                    echo $this->Form->input('descricao' ,  array(
                        'div' => false,
                        'id' => 'descricao',
                        'class' => 'validate',
                        'label' => false,
                        'length' => "150",
                        'maxlength' => "150",
                    ));

                ?>
                <label for="descricao">Descrição</label>
            </div>

			<div class="input-field col s12">
                <?php
                    echo $this->Form->input('ordem' ,  array(
                        'div' => false,
                        'id' => 'ordem',
                        'class' => 'validate',
                        'label' => false,
                    ));

                ?>
                <label for="ordem">Ordem</label>
            </div>
        </div>

		<h3>Nova Sub-Etapa</h3>
		<hr>

		<div class="row">
			<div class="input-field col s12">
				<?php
					echo $this->Form->input('FluxogramaSubEtapa.subetapa' ,  array(
						'div' => false,
						'id' => 'subetapa',
						'class' => 'validate',
						'label' => false,
						'length' => "100",
						'maxlength' => "100",
					));

				?>
				<label for="subetapa">Nome da Sub-Etapa</label>
			</div>

			<div class="input-field col s12">
				<?php
					echo $this->Form->input('FluxogramaSubEtapa.descricao' ,  array(
						'div' => false,
						'id' => 'descricao',
						'class' => 'validate',
						'label' => false,
						'length' => "150",
						'maxlength' => "150",
					));

				?>
				<label for="descricao">Descrição</label>
			</div>
		</div>



        <div class="row">
            <div class="input-field col s12">
				<?php
					echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
						'label' => 'Salvar',
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




	<div class="row">
		<h4>Lista de Sub-Etapas</h4>
		<hr>
		<?php foreach( $this->request->data['FluxogramaSubEtapa'] as $subEtapa ): ?>
			<div class="col s12 m12 l6">
				<div class="contentTarefaPl tarefa-nao-realizada">
					<?//= $this->Form->create('FluxogramaSubEtapa', array('type'=>'file', 'data-abide' => '', 'class' => 'col s12'));?>
						<div class="texto tarefa_<?php echo $subEtapa['id']; ?>" id="ver_Tarefa_<?php echo $subEtapa['id']; ?>">
							<a href="#editTarefa_<?php echo $subEtapa['id']; ?>" class="green-text textd-darken-3 tooltipped modal-trigger" id="edit_Tarefa" data-position="bottom" data-delay="50" data-tooltip="Editar esta sub-etapa">
								<i class="material-icons prefix ">mode_edit</i>
							</a>
							<a href="#modalExcluirSubEtapa_<?php echo $subEtapa['id']; ?>" class="red-text textd-darken-3 tooltipped modal-trigger right" data-position="bottom" data-delay="50" data-tooltip="Excluir esta sub-etapa">
								<i class="material-icons prefix ">close</i>
							</a>

							<p class="titulo-tarefa">
								<?php echo $subEtapa['subetapa']; ?>
								<small class="right">ordem: <?php  echo $subEtapa['ordem']; ?></small>
							</p>
							<div class="text">
								<p><?php echo $subEtapa['descricao']; ?></p>
							</div>
						</div>
						<?//= $this->Form->end(); ?>
					<hr>
				</div>
			</div>

			<div id="editTarefa_<?php echo $subEtapa['id'];?>" class="modal tarefaModal">
				<?=$this->Form->create('FluxogramaSubEtapaEdit', array('type'=>'file', 'data-abide' => '', 'class' => 'col s12'));?>
					<div class="modal-content">
						<h4 class="center">Alterar Sub-Etapa</h4>
						<?php
							echo $this->Form->input('FluxogramaSubEtapaEdit.subetapa_id' ,  array(
								'type' => 'hidden',
								'div' => false,
								'id' => 'subetapa_id',
								'class' => 'validate',
								'label' => false,
								'value' => $subEtapa['id']
							));

						?>
							<div class="input-field col s12">
								<?php
									echo $this->Form->input('FluxogramaSubEtapaEdit.subetapa' ,  array(
										'div' => false,
										'id' => 'subetapa',
										'class' => 'validate',
										'label' => false,
										'length' => "100",
										'maxlength' => "100",
										'value' => $subEtapa['subetapa']
									));

								?>
								<label for="subetapa">Nome da Sub-Etapa</label>
							</div>

							<div class="input-field col s12">
								<?php
									echo $this->Form->input('FluxogramaSubEtapaEdit.descricao' ,  array(
										'div' => false,
										'id' => 'descricao',
										'class' => 'validate',
										'label' => false,
										'length' => "150",
										'maxlength' => "150",
										'value' => $subEtapa['descricao']
									));

								?>
								<label for="descricao">Descrição</label>
							</div>

							<div class="input-field col s12">
								<?php
									echo $this->Form->input('FluxogramaSubEtapaEdit.ordem' ,  array(
										'div' => false,
										'id' => 'ordem',
										'class' => 'validate',
										'label' => false,
										'value' => $subEtapa['ordem']
									));
								?>
								<label for="descricao">Ordem</label>
							</div>
					</div>
					<div class="modal-footer">
						<?php
							echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
								'label' => 'Salvar',
								'type' => 'submit',
								'div' => true,
								'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
							));
						?>
						<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
					</div>
				<?= $this->Form->end(); ?>
			</div>



			<div id="modalExcluirSubEtapa_<?php echo $subEtapa['id']; ?>" class="modal">
				<div class="modal-content">
					<h4>Deletar</h4>
					<p>Deletar Sub-Etapa: <?php echo $subEtapa['subetapa']; ?></p>
				</div>
				<div class="modal-footer">
					<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">CANCELAR</a>
					<?php
					echo $this->Form->postLink(
						'DELETAR',
						array(
							'controller' => 'Fluxogramas',
							'action' => 'admin_fluxoSubEtapasDelete',
							$this->request->data['FluxogramaEtapa']['pl_type_id'],
							$this->request->data['FluxogramaEtapa']['id'],
							$subEtapa['id']
						),
						array(
							'confirm' => 'Tem certeza que deseja excluir esta Sub-Etapa?',
							'class' => 'modal-action modal-close waves-effect waves-green btn-flat tooltipped',
							'data-position' => 'bottom',
							'data-delay' => 50,
							'data-tooltip' => "Apagar Etapa",
							'escape'=>false
						)
					);
					?>



				</div>
			</div>

		<?php endforeach; ?>
	</div>
