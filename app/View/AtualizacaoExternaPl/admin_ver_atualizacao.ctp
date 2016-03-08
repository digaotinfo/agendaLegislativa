<!-- HEADER DA PÁGINA -->
<div class="row padding-top-20">
    <div class="col s12">
        <h3 class="titulo-pagina">
            Atualização
            <a href="<?php echo $this->Html->url( array('controller' => 'AtualizacaoExternaPls', 'action' => 'index', 'admin' => true) ); ?>" class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar">
                <i class="material-icons">arrow_back</i>
            </a>
        </h3>
    </div>
</div>
<!-- / HEADER DA PÁGINA -->


<div class="row padding-top-20 arquivos">
    <div class="col s12">
        <?php echo $registro[$model]['corpo']; ?>
    </div>
</div>
