<?php

?>
<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		 <h3 class="titulo-pagina">
			 Alterar Tipo
			 <a href="javascript: void(0);" onclick='window.history.back();'  class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
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
 					echo $this->Form->input('tipo' ,  array(
 								'div' => false,
 								'id' => 'tipo',
 								'class' => 'validate',
 								'label' => false,
 							));

 				?>
  				<label for="nome">Tipo</label>
  			</div>
  		</div>

 		<div class="row">
 			<div class="input-field col s12">
                <!-- Switch -->
                <div class="switch">
                    <label>
                        Desativada
                        <?php
                            echo $this->Form->input('ativo', array(
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false
                            ));
                        ?>
                        <!-- <input type="checkbox"> -->
                        <span class="lever"></span>
                        Ativa
                    </label>
                </div>

                <!-- Disabled Switch -->

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

	<br>
		<br>
			<br>
				<br>
					<br>
						<br>
					<br>
				<br>
			<br>
		<br>
	<br>
	<h3>
		Etapas
		<?php
		echo $this->Html->Link(
		'<i class="material-icons">add</i>',
		array(
			'controller' => 'Fluxogramas',
			'action' => 'admin_fluxoEtapasAdd',
			$this->request->data[$model]['id']),
			array(
				'class' => 'btn-floating green darken-1 tooltipped margin-right-4 right',
				'data-position' => 'bottom',
				'data-delay' => 50,
				'data-tooltip' => "Adicionar Etapa",
				'escape'=>false
			)
		);
		?>
	</h3>
	<?php $model = "FluxogramaEtapa"; ?>
	<hr>

	<div class="row padding-top-20 arquivos">
	    <div class="col s12">

	        <table class="striped">
	            <thead>
	                    <th data-field="nome" class="nome-short"><?=$this->Paginator->sort($model.'.etapa', 'Etapa');?></th>
	                    <th data-field="arquivp" class="arquivo-short"><?=$this->Paginator->sort($model.'.ordem', 'Ordem');?></th>
	                    <th width="150px" data-field="action" class="center-align">Ações</th>
	                </tr>
	            </thead>

	            <tbody>
	                <?php foreach($registros as $registro): ?>
	                    <tr>
	                        <td><?php echo $registro[$model]['etapa'];?></td>
	                        <td><?php echo $registro[$model]['ordem'];?></td>

	                        <td class="center-align">
								<?php
							   if ($userAdmin == 1){

									echo $this->Html->Link(
										'<i class="material-icons">edit</i>',
										array(
											'controller' => 'Fluxogramas',
											'action' => 'admin_fluxoEtapasEdit',
											$registro[$model]['pl_type_id'],
											$registro[$model]['id']
										),
										array(
											'class' => 'btn-floating green darken-1 tooltipped margin-right-4',
											'data-position' => 'bottom',
											'data-delay' => 50,
											'data-tooltip' => "Editar Etapa",
											'escape'=>false
										)
									);

									echo $this->Form->postLink(
										'<i class="material-icons">delete</i>',
										array(
											'controller' => 'Fluxogramas',
											'action' => 'admin_fluxoEtapasDelete',
											$registro[$model]['pl_type_id'],
											$registro[$model]['id'],
											'deleteTipoEtapa'
										),
										array(
											'confirm' => 'Tem certeza que deseja excluir esta Etapa?',
											'class' => 'btn-floating red tooltipped',
											'data-position' => 'bottom',
											'data-delay' => 50,
											'data-tooltip' => "Apagar Etapa",
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
