<div class="columns title-page">
    <p>
        Inserir Novo Arquivo
    </p>
</div>

<!-- >>> INFORMACOES -->
<?=$this->Form->create($model, array('type' => 'file'))?>
    <div class="medium-12 columns labels-info-pl">
            <?php
                echo $this->Form->input('nome', array(
                    'label' => 'Titulo do Arquivo',
                    'id'    => 'nome-arquivo'
                ));
            ?>

            <?php
                echo $this->Form->input('descricao', array(
                    'label' => 'Descrição'
                ));
            ?>
            <div class="small-12 medium-5 columns paddingTop20 file">
                <input type="text" name="file_name" class="file-name-onde-esta">
                <?php
                    echo $this->Form->input('arquivo', array('type' => 'file', 'class' => 'upload onde-esta botao', 'label' => 'Arquivo', 'name' => 'arquivo'));
                    echo $this->Form->input('dir', array('type' => 'hidden'));
                    echo $this->Form->input('mimetype', array('type' => 'hidden'));
                    echo $this->Form->input('filesize', array('type' => 'hidden'));
                ?>
            </div>
            </div>
            <div class="small-12 medium-6 columns text-center paddingTop20 submit">
                <?php
                    echo $this->Form->button('Salvar atualização' ,  array(
                        'type' => 'submit',
                        'div' => true,
                        'class' => 'radius tiny button botao right marginTop10',
                    ));
                ?>
            </div>
    </div>
    <!-- <<< INFORMACOES -->
<?=$this->Form->end()?>
