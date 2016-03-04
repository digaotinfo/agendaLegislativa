    <!-- HEADER DA PÁGINA -->
    <div class="row padding-top-20">
        <div class="col s12">
            <h3 class="titulo-pagina">
                Cadastrando Nota Técnica
                <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
            </h3>
        </div>
     </div>
     <!-- / HEADER DA PÁGINA -->

    <?=$this->Form->create($model, array('type' => 'file', 'class' => 'col s12'))?>

        <div class="row padding-top-20">

            <div class="row">
                <div class="input-field col s12">
                    <?php
                        echo $this->Form->input('pl_id', array(
                            'label' => false,
                            'id'    => 'pl_id',
                            'class' => 'validate',
                            'div'   => false,
                            'options' => $proposicao,
                            'empty' => ' -- Selecione -- ',
                            'selected' => $pl_id
                        ));
                    ?>
                    <label for="titulo">Proposição</label>
                </div>
             </div>

            <div class="row">
                <div class="input-field col s12">
                    <?php
                        echo $this->Form->input('nome', array(
                            'label' => false,
                            'id'    => 'titulo',
                            'class' => 'validate',
                            'div'   => false,
                        ));
                    ?>
                    <label for="titulo">Título da Nota Técnica</label>
                </div>
             </div>

             <div class="row">
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
                            'label' => 'Salvar',
                            'type' => 'submit',
                            'div' => true,
                            'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                        ));
                    ?>

                    <a href="javascript:void(0)" onclick='window.history.back();' class="waves-effect waves-light btn right red darken-3">
                        <i class="material-icons left">close</i>Cancelar
                    </a>
                </div>
            </div>




        </div>

    <?=$this->Form->end();?>
