<?php

?>
<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
	<div class="col s12">
		 <h3 class="titulo-pagina">
			Importar Nomes de Autor e Relator
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
 			<div class="col s12">
 				<p class="center">
 				    Para importar os Nomes de Autores e Relatores, você deve gerar um arquivo
                    <a href="<?=Router::url('/uploads/modelo_import/autor_relator.xlsx', true)?>" target="_blank">
                        <strong>.XLSX</strong>
                    </a>
                    com apenas 1(uma) coluna.<br>
                    Na <strong>Celula A1</strong>, será mantido o nome da coluna (NOME) apenas para identificação e a partir da <strong>celula A2</strong>, colocque todos os nomes.
 				</p>
  			</div>
            <div class="file-field input-field col s12">
                <input class="file-path validate" type="text"/>
                <div class="btn">
                    <span >Anexar arquivo</span>
                    <?php
                        echo $this->Form->input('arquivo', array('type' => 'file',  'label' => false));
                        echo $this->Form->input('dir', array('type' => 'hidden'));
                        echo $this->Form->input('mimetype', array('type' => 'hidden'));
                        echo $this->Form->input('filesize', array('type' => 'hidden'));
                    ?>

                </div>
            </div>
  		</div>

  		<div class="row">
  			<div class="input-field col s12">
				<?php
					echo $this->Form->button('<i class="material-icons left">done</i>Salvar' ,  array(
						'label' => 'Import',
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
