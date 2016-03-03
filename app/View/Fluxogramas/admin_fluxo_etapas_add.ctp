<?php

?>
<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		<h3 class="titulo-pagina">
			Nova Etapa do tipo - <?php echo $tipo['PlType']['tipo']; ?>
			<a href="javascript: void(0);" onclick='window.history.back();'  class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
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
                            'type' 	=> 'hidden',
							'value'	=> $tipo['PlType']['id']
					));
            ?>
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
						'value' => $lastOrdemEtapa
                    ));

                ?>
                <label for="ordem">Ordem</label>
            </div>
        </div>

		<h3>Sub-Etapa</h3>
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
