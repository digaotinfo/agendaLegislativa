<?php
$this->start('css');
    echo $this->Html->css(array(
                                '/assets/js-graph-it/js-graph-it.css',
                                '/assets/js-graph-it/sf-homepage.css',
                            ));
?>
<style media="screen">
    .link{
        text-decoration: none;
        color: #9a9a9a !important;
    }
    .adicionar-mais-ordem,
    .adicionar-mais-etapas{
        background-color: #2E7D32 !important;
        border: none !important;
        background-color: transparent !important;
    }
        .adicionar-mais-ordem a,
        .adicionar-mais-etapas a{
            /*color: #FFFFFF !important;*/
        }

    .container .main_table .modal p, div{
        font-size: 15px !important;
    }

</style>
<?php
$this->end();

$this->start('script');
?>
    <script>
        <!--
            function onLoad()
            {
                // setMenu();
                resizeCanvas();
                initPageObjects();
            }

            /**
             * Resizes the main canvas to the maximum visible height.
             */
            function resizeCanvas()
            {
                var divElement = document.getElementById("mainCanvas");
                var screenHeight = window.innerHeight || document.body.offsetHeight;
                divElement.style.height = (screenHeight - 16) + "px";
            }

            /**
             * Strips the file extension and everything after from a url
             */
            function stripExtension(url)
            {
                var lastDotPos = url.lastIndexOf('.');
                if(lastDotPos > 0)
                    return url.substring(0, lastDotPos - 1);
                else
                    return url;
            }

            /**
             * this function opens a popup to show samples during explanations.
             */
            function openSample(url)
            {
                var popup = window.open(url, "sampleWindow", "width=400,height=300");
                popup.focus();
                return false;
            }
        //-->
    </script>
<?php
    echo $this->Html->script('/assets/js-graph-it/js-graph-it.js');
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.modal-trigger').leanModal();
        });
    </script>
<?php
$this->end();
?>

    <!-- HEADER DA PÁGINA -->
    <div class="row padding-top-20">
        <div class="col s12">
            <h3 class="titulo-pagina">
                <?php
                    $countFluxograma = count($proposicao['Fluxograma']);
                    $proposicaoNome = '';
                    if( $countFluxograma == 1 ){
                        $proposicaoNome = $proposicao['PlType']['tipo']. ' ' .$proposicao['Pl']['numero_da_pl'].'/'.$proposicao['Pl']['ano'];
                    }else if( $countFluxograma >= 1 ){
                        $lastItemArray = $countFluxograma-1;
                        $proposicaoNome = $proposicao['PlType']['tipo']. ' ' .$proposicao['Pl']['numero_da_pl'].'/'.$proposicao['Pl']['ano'];
                    }
                ?>
                Fluxograma <?php echo $proposicaoNome; ?>
                <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar">
                    <i class="material-icons">arrow_back</i>
                </a>
            </h3>
        </div>
    </div>
    <!-- / HEADER DA PÁGINA -->


    <table class="main_table" style="height: 100%;" >
		<tr>
			<td style="vertical-align: top; padding: 0px;">
				<div id="mainCanvas" class="canvas" style="width: 100%; height: 500px;">

                <?php
                    /*
                    *
                    * caso a proposicao tenha sido apenas criada >>>
                    */
                ?>
                    <?php
                        $contFluxo = 0;
                        $marginTopEtapa = 0;
                        $marginTopEtapaADD  = 0;
                        $marginTopSubEtapa = 0;
                        $marginTopSubEtapaADD  = 0;
                        $stelenghtTotalEtapa = 0;
                        $stelenghtTotalSubEtapa = 0;
                        $totalMedidaSubEtapas = 0;

                        // echo "<pre>";
                        // print_r($proposicao['Fluxograma'][0]);
                        // echo "</pre>";
                        // die();

                        foreach( $proposicao['Fluxograma'] as $index => $logFluxograma ):
                            $contFluxo++;
                            $novoNomeProposicao = $logFluxograma['PlType']['tipo'] .' '. $logFluxograma['numero_da_pl'] .'/'. $logFluxograma['ano'];
                            if( $index == 0 ){
                                /*
                                *
                                * Nome da Proposição >>>
                                */
                                ?>
                                <h1 id="title_<?php echo $logFluxograma['id']?>" class="block draggable" style="left: 30px;">
                                    <?php echo $novoNomeProposicao; ?>
                                </h1>
                                <?php
                            }else{
                                $marginTopEtapa = $marginTopEtapaADD+300;
                                $marginTopEtapaADD = $marginTopEtapaADD+300;
                                if( $marginTopSubEtapaADD > 0 ){
                                    $marginTopEtapa = $marginTopSubEtapaADD+300;
                                    $marginTopEtapaADD = $marginTopSubEtapaADD+300;
                                }else{
                                    $marginTopEtapa = $marginTopEtapaADD+300;
                                    $marginTopEtapaADD = $marginTopEtapaADD+300;
                                }
                                ?>
                                <h1 id="title_<?php echo $logFluxograma['id'];?>" class="block draggable" style="left: 30px;top: <?php echo $marginTopEtapa;?>px">
                                    <?php echo $novoNomeProposicao; ?>
                                </h1>

                                <div class="connector <?php echo 'title_'.$proposicao['Fluxograma'][$index-1]['id']; ?> <?php echo 'title_'.$logFluxograma['id']; ?>">
                                    <label class="destination-label">
                                        <?php echo $this->Time->format('d/m/y', $logFluxograma['created']); ?>
                                    </label>
                                    <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                </div>
                                <?php
                            }
                            /*
                            *
                            * <<< Nome da Proposição
                            */



                            /*
                            *
                            * Etapa >>>
                            */
                            $a_etapa = $logFluxograma['FluxogramaEtapaLogFluxo'];
                            if( !empty($a_etapa) ):
                                foreach( $a_etapa as $etapaIndex => $etapa ){
                                    // echo "<pre>";
                                    // print_r( $etapa );
                                    // echo "</pre>";
                                    // die();

                                    if( $etapaIndex > 0 ){
                                        $stelenghtTotalEtapa = (strlen($a_etapa[$etapaIndex-1]['etapa'])+strlen($a_etapa[$etapaIndex-1]['descricao']));
                                        if(!empty($marginTopSubEtapaADD)){
                                            $marginTopEtapa = $marginTopSubEtapaADD+250;
                                        }
                                        $marginTopEtapa = $marginTopEtapa+200;
                                    }else{
                                        $marginTopEtapa = $marginTopEtapa;
                                    }
                                    $marginTopEtapaADD = $marginTopEtapa;

                                    if( !empty($etapa) ){
                                        // Etapa >>>
                                        ?>
                                        <div id="block_etapa_<?php echo $etapa['id']?>" class="block draggable" style="left: 280px; top: <?php echo $marginTopEtapa; ?>px; padding-left: 10px; padding-right: 10px; width: 250px;">
                                            <?php
                                                echo $this->Form->postLink('x',
                                                                            array('controller' => 'Fluxogramas', 'action' => 'admin_desvincularEtapa', $etapa['TbFluxoLogOrigemPlTbFluxoEtapa']['id'], $pl_id),
                                                                            array('confirm' => 'Tem certeza que deseja excluir esta Etapa deste Fluxograma?', 'class' => "right")
                                                                        );
                                            ?>
                                            <?php if( $userAdmin == 1 ){ ?>
                                                <a href="#modalEtapaAlterar<?php echo $etapa['id']?>" class="tooltipped link modal-trigger" data-position="top" data-delay="50" data-tooltip="Click para alterar a Etapa.">
                                                    <strong>
                                                        <?php echo $etapa['etapa']; ?>:
                                                    </strong>
                                                    <br>
                                                    <small>
                                                        <?php echo $etapa['descricao'];?>
                                                    </small>
                                                </a>
                                            <?php }else{ ?>
                                                <strong>
                                                    <?php echo $etapa['etapa']; ?>:
                                                </strong>
                                                <br>
                                                <small>
                                                    <?php echo $etapa['descricao'];?>
                                                </small>
                                            <?php } ?>
                                        </div>

                                        <?php // modalEtapaAlterar >>> ?>
                                        <?php if( $userAdmin == 1 ){ ?>
                                            <div id="modalEtapaAlterar<?php echo $etapa['id']?>" class="modal">
                                                <div class="modal-content">
                                                    <h4>Editar Etapa</h4>
                                                    <br>
                                                    <br>
                                                    <p>
                                                        Caso altere esta Etapa, você excluirá o fluxograma atual.
                                                    </p>
                                                    <br>
                                                    <br>
                                                    <?=$this->Form->create('FluxogramaEtapaAlterar', array('class' => 'formFluxogramaEtapaAlterar'));?>
                                                        <div class="row">
                                                            <div class="input-field col s12">
                                                                <?php
                                                                    echo $this->Form->input('fluxo_etapa_id' ,  array(
                                                                                'label' => false,
                                                                                'div' => false,
                                                                                'type' => 'select',
                                                                                'class' => 'validate',
                                                                                'options' => $etapas,
                                                                                'empty' => ' -- Selecione a Etapa -- ',
                                                                                'default' => $etapa['id']
                                                                            ));
                                                                ?>
                                                                <label>Etapa</label>
                                                            </div>

                                                            <div class="col l6 m12 s12 center">
                                                                <a class="waves-effect waves-light btn right red darken-3 modal-close" href="javascript:void(0)">
                                                                    <i class="material-icons left">close</i>
                                                                    Cancelar
                                                                </a>
                                                            </div>
                                                            <div class="col l6 m12 s12 center">
                                                                <?php
                                                                    echo $this->Form->button('<i class="material-icons left">add</i>Adicionar' ,  array(
                                                                        'label' => 'Salvar',
                                                                        'type' => 'submit',
                                                                        'div' => true,
                                                                        'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                                                                    ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    <?php echo $this->Form->end();?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php //<<< modalEtapaAlterar ?>

                                        <?php
                                        // <<< Etapa

                                        // SUB-Etapas >>>
                                        // echo "<pre>";
                                        // print_r($etapa);
                                        // echo "</pre>";
                                        // die();
                                        $subE = $etapa['FluxogramaEtapaSubEtapaLog'];
                                        if( !empty($subE) ):
                                            foreach( $subE as $indexSubEtapa => $subEtapa):
                                                if( !empty($subEtapa) ){
                                                    if( $indexSubEtapa > 0 ){
                                                        $stelenghtTotalSubEtapa = (strlen($subE[$indexSubEtapa-1]['subetapa'])+strlen($subE[$indexSubEtapa-1]['descricao']));
                                                        if( $stelenghtTotalSubEtapa > 75){
                                                            $marginTopSubEtapa = $marginTopSubEtapa+200;
                                                        }else{
                                                            $marginTopSubEtapa = $marginTopSubEtapa+80;
                                                        }
                                                    }else{
                                                        $marginTopSubEtapa = $marginTopEtapa+50;
                                                    }
                                                    $marginTopSubEtapaADD = $marginTopSubEtapa;
                                                    $totalMedidaSubEtapas = $totalMedidaSubEtapas+$marginTopSubEtapaADD;
                                                    ?>
                                                    <div id="block_subEtapa_<?php echo $subEtapa['id']?>" class="block draggable" style="left: 600px; top: <?php echo round($marginTopSubEtapa); ?>px; padding-left: 10px; padding-right: 10px; width: 280px;">
                                                        <?php
                                                            if( $userAdmin == 1 ){
                                                                echo $this->Form->postLink('x',
                                                                                            array('controller' => 'Fluxogramas', 'action' => 'admin_deleteEtapa', $subEtapa['id'], $pl_id),
                                                                                            array('confirm' => 'Tem certeza que deseja excluir esta Etapa?', 'class' => "right")
                                                                                        );
                                                            }
                                                        ?>
                                                        <?php if( $userAdmin == 1 ){ ?>
                                                            <a href="#modalSubEtapaAlterar_<?php echo $subEtapa['id']?>" class="tooltipped link modal-trigger" data-position="top" data-delay="50" data-tooltip="Click para alterar a Etapa.">
                                                            <strong>
                                                                <?php echo $subEtapa['subetapa'].':<br>';?>
                                                            </strong>
                                                            <small>
                                                                <?php echo $subEtapa['descricao'];?>
                                                            </small>
                                                            </a>
                                                        <?php }else{ ?>
                                                            <strong>
                                                                <?php echo $subEtapa['subetapa'].':<br>';?>
                                                            </strong>
                                                            <small>
                                                                <?php echo $subEtapa['descricao'];?>
                                                            </small>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="connector block_etapa_<?php echo $etapa['id']?> block_subEtapa_<?php echo $subEtapa['id']?>">
                                                        <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                                    </div>


                                                    <?php // modalSubEtapaAlterar >>> ?>
                                                    <?php if( $userAdmin == 1 ){ ?>
                                                        <div id="modalSubEtapaAlterar_<?php echo $subEtapa['id']?>" class="modal">
                                                            <div class="modal-content">
                                                                <h4>Editar Sub-Etapa</h4>
                                                                <br>
                                                                <br>
                                                                <p>
                                                                    Alterar Sub-Etapa.
                                                                </p>
                                                                <br>
                                                                <br>
                                                                <?=$this->Form->create('FluxogramaSubEtapaAlterar', array('class' => 'formFluxogramaSubEtapaAlterar'));?>
                                                                    <div class="row">
                                                                        <div class="input-field col s12">
                                                                            <?php
                                                                               echo $this->Form->input('subetapa' ,  array(
                                                                                           'label' => false,
                                                                                           'div' => false,
                                                                                           'type' => 'text',
                                                                                           'class' => 'validate',
                                                                                           'id' => 'tituloSubEtapa',
                                                                                           'value'  => $subEtapa['subetapa'],
                                                                                           'length' => "100",
                                                                                           'maxlength' => "100",
                                                                                       ));
                                                                            ?>
                                                                            <label>Título da Sub-Etapa:</label>
                                                                        </div>
                                                                        <div class="input-field col s12">
                                                                            <?php
                                                                               echo $this->Form->input('descricao' ,  array(
                                                                                           'label' => false,
                                                                                           'div' => false,
                                                                                           'type' => 'text',
                                                                                           'class' => 'validate',
                                                                                           'id' => 'descricaoOrdem',
                                                                                           'value'  => $subEtapa['descricao'],
                                                                                           'length' => "150",
                                                                                           'maxlength' => "150",
                                                                                       ));
                                                                            ?>
                                                                            <label>Descrição da Ordem:</label>
                                                                        </div>
                                                                        <?php
                                                                            echo $this->Form->input('fluxo_etapa_id' ,  array(
                                                                                        'label' => false,
                                                                                        'div' => false,
                                                                                        'type' => 'hidden',
                                                                                        'id' => 'fluxo_log_id',
                                                                                        'value' => $etapa['id']
                                                                                    ));
                                                                            echo $this->Form->input('idEtapa' ,  array(
                                                                                        'label' => false,
                                                                                        'div' => false,
                                                                                        'type' => 'hidden',
                                                                                        'id' => 'fluxo_log_id',
                                                                                        'value' => $etapa['id']
                                                                                    ));
                                                                        ?>
                                                                        <div class="col l6 m12 s12 center">
                                                                            <a class="waves-effect waves-light btn right red darken-3 modal-close" href="javascript:void(0)">
                                                                                <i class="material-icons left">close</i>
                                                                                Cancelar
                                                                            </a>
                                                                        </div>
                                                                        <div class="col l6 m12 s12 center">
                                                                            <?php
                                                                                echo $this->Form->button('<i class="material-icons left">add</i>Adicionar' ,  array(
                                                                                    'label' => 'Salvar',
                                                                                    'type' => 'submit',
                                                                                    'div' => true,
                                                                                    'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                                                                                ));
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                <?php echo $this->Form->end();?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php //<<< modalSubEtapaAlterar ?>



                                                    <?php
                                                }
                                            endforeach;
                                            $marginTopEtapa = 0;
                                        elseif( count($subE) == 0 ):
                                            $totalMedidaSubEtapas = 400;
                                            $marginTopSubEtapaADD = $marginTopEtapa;
                                        endif;
                                        // <<< SUB-Etapas
                                        ?>

                                        <?php
                                        /*
                                        *
                                        * MAIS SUB-ETAPAS
                                        * Caso permissão de admin, poder add nova Sub-ETAPA essa Etapa >>>>
                                        */
                                        if( $userAdmin == 1 ){
                                            ?>
                                            <div id="block_etapa_<?php echo $etapa['id']?>_mais" class="block draggable adicionar-mais-etapas" style="left: 600px; top: <?php echo $marginTopSubEtapaADD+160; ?>px; padding-left: 10px; padding-right: 10px; width: 60px;">
                                                <a href="#modalOpcaoSubEtapas_<?php echo $etapa['id']?>" class="btn-floating green darken-3 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar nova Etapa a esta Proposição." data-etapaID="<?php echo $etapa['id']; ?>">
                                                    <i class="material-icons">add</i>
                                                </a>
                                            </div>

                                            <div class="connector block_etapa_<?php echo $etapa['id']?> block_etapa_<?php echo $etapa['id']?>_mais">
                                                <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                            </div>

                                            <div class="connector <?php if( $contFluxo == 1 ){ echo 'title_'.$logFluxograma['id']; } ?> block_etapa_<?php echo $etapa['id']?> block_etapa_<?php echo $etapa['id']?>_mais">
                                                <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                            </div>

                                            <?php // modalOpcaoSubEtapas >>> ?>
                                            <div id="modalOpcaoSubEtapas_<?php echo $etapa['id']?>" class="modal">
                                                <div class="modal-content">
                                                    <h4>Adicionar nova Sub-Etapa</h4>
                                                    <br>
                                                    <br>
                                                    <p>
                                                        Nesta àrea, você poderá adicionar uma Sub-Etapa pré-cadastrada no sistema ou definir uma nova Sub-Etapa.
                                                    </p>
                                                    <br>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col l6 m12 s12 center">
                                                            <a class="waves-effect waves-light btn green darken-3 btn-subEtapaJaExistente" href="javascript:void(0);" data-etapaID="<?php echo $etapa['id']; ?>" data-subEtapasDestaEtapa="<?php echo $this->Html->url(array('controller' => 'Fluxogramas', 'action' => 'subEtapaDestaEtapa', $etapa['id']));?>">
                                                                <i class="material-icons left">playlist_add</i>
                                                                Sub-Etapa Já Existente
                                                            </a>
                                                        </div>
                                                        <div class="col l6 m12 s12 center">
                                                            <a class="waves-effect waves-light btn green darken-3 btn-subEtapaADD" href="javascript:void(0);" data-etapaID="<?php echo $etapa['id']; ?>">
                                                                <i class="material-icons left">add</i>Nova Sub-Etapa
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php // <<< modalOpcaoSubEtapas ?>


                                            <?php // modalSubEtapaDaEtapaID >>> ?>
                                            <div id="modalSubEtapaDaEtapaID_<?php echo $etapa['id']; ?>" class="modal">
                                                <div class="modal-content">
                                                    <h4>Adicionar Sub-Etapa</h4>
                                                    <br>
                                                    <br>
                                                    <p>
                                                        Escolha qual a Sub-etapa deja vincular a está Estapa.
                                                    </p>
                                                    <br>
                                                    <br>
                                                    <?=$this->Form->create('FluxogramaSubEtapa', array('class' => 'formFluxogramaSubEtapa'));?>
                                                        <div class="row selecionarSubEtapa">
                                                            <div class="input-field col s12">
                                                                <?php
                                                                   echo $this->Form->input('subetapa_id' ,  array(
                                                                               'label' => false,
                                                                               'div' => false,
                                                                               'type' => 'select',
                                                                               'class' => 'validate',
                                                                               'id' => 'selectSubEtapaList',
                                                                           ));
                                                                ?>
                                                                <label>Sub-Etapas Pré-definidas:</label>
                                                            </div>
                                                            <?php
                                                                echo $this->Form->input('etapa_id' ,  array(
                                                                            'label' => false,
                                                                            'div' => false,
                                                                            'type' => 'hidden',
                                                                            'id' => 'fluxo_log_origem_id',
                                                                            'value' => $etapa['id']
                                                                        ));
                                                            ?>
                                                            <div class="col l6 m12 s12 center">
                                                                <a class="waves-effect waves-light btn right red darken-3" href="javascript:void(0)">
                                                                    <i class="material-icons left">close</i>
                                                                    Cancelar
                                                                </a>
                                                            </div>
                                                            <div class="col l6 m12 s12 center">
                                                                <?php
                                                                    echo $this->Form->button('<i class="material-icons left">add</i>Adicionar' ,  array(
                                                                        'label' => 'Salvar',
                                                                        'type' => 'submit',
                                                                        'div' => true,
                                                                        'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                                                                    ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    <?php echo $this->Form->end();?>
                                                </div>
                                            </div>

                                            <?php // <<<modalSubEtapaDaEtapaID  ?>


                                            <?php // modalNovaEtapa >>> ?>
                                            <div id="modalNovaEtapa_<?php echo $etapa['id']?>" class="modal">
                                                <div class="modal-content">
                                                    <h4>Adicionar nova Sub-Etapa</h4>
                                                    <br>
                                                    <br>
                                                    <p>
                                                        Escolha qual a sub-etapa deja vincular a Etapa: <strong><?php echo $etapa['etapa']; ?> - <?php echo $etapa['id']?></strong>

                                                    </p>
                                                    <br>
                                                    <br>
                                                    <?=$this->Form->create('FluxogramaNovaSubEtapa', array('class' => 'formFluxogramaSubEtapa'));?>
                                                        <div class="row">
                                                            <div class="input-field col s12">
                                                                <?php
                                                                   echo $this->Form->input('subetapa' ,  array(
                                                                               'label' => false,
                                                                               'div' => false,
                                                                               'type' => 'text',
                                                                               'class' => 'validate',
                                                                               'id' => 'tituloSubEtapa',
                                                                               'length' => "100",
                                                                               'maxlength' => "100",
                                                                           ));
                                                                ?>
                                                                <label>Título da Sub-Etapa:</label>
                                                            </div>
                                                            <div class="input-field col s12">
                                                                <?php
                                                                   echo $this->Form->input('descricao' ,  array(
                                                                               'label' => false,
                                                                               'div' => false,
                                                                               'type' => 'text',
                                                                               'class' => 'validate',
                                                                               'id' => 'descricaoSubEtapa',
                                                                               'length' => "150",
                                                                               'maxlength' => "150",
                                                                           ));
                                                                ?>
                                                                <label>Descrição da Sub-Etapa:</label>
                                                            </div>
                                                            <?php
                                                                echo $this->Form->input('etapa_id' ,  array(
                                                                            'label' => false,
                                                                            'div' => false,
                                                                            'type' => 'hidden',
                                                                            'id' => 'fluxo_log_etapa_id',
                                                                            'value' => $etapa['id']
                                                                        ));
                                                            ?>
                                                            <div class="col l6 m12 s12 center">
                                                                <a class="waves-effect waves-light btn right red darken-3" href="javascript:void(0)">
                                                                    <i class="material-icons left">close</i>
                                                                    Cancelar
                                                                </a>
                                                            </div>
                                                            <div class="col l6 m12 s12 center">
                                                                <?php
                                                                    echo $this->Form->button('<i class="material-icons left">add</i>Adicionar' ,  array(
                                                                        'label' => 'Salvar',
                                                                        'type' => 'submit',
                                                                        'div' => true,
                                                                        'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                                                                    ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    <?php echo $this->Form->end();?>
                                                </div>
                                            </div>
                                            <?php //<<< modalNovaEtapa ?>

                                            <?php
                                        }else{
                                            ?>
                                            <div class="connector <?php if( $contFluxo == 1 ){ echo 'title_'.$logFluxograma['id']; } ?> block_etapa_<?php echo $etapa['id']?> block_etapa_<?php echo $etapa['id']?>_mais">
                                                <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                            </div>
                                            <?php
                                        }
                                        /*
                                        *
                                        * <<< MAIS SubETAPAS
                                        * Caso permissão de admin, poder add nova SubETAPA essa Etapa
                                        */
                                        ?>
                                        <?php
                                        //<<< SUB-Etapas
                                    }
                                }
                            endif;
                            /*
                            *
                            * <<< Etapa
                            */


                            /*
                            *
                            * MAIS Etapa
                            * Caso permissão de admin, poder add nova etapa essa proposição
                            * enquanto a mesma, continua tendo este nome >>>>
                            */
                            if( $userAdmin == 1 ){
                                ?>
                                <div id="block_etapa_mais_<?php echo $logFluxograma['id']; ?>" class="block draggable adicionar-mais-ordem" style="left: 280px; top: <?php echo $marginTopEtapaADD+200; ?>px; padding-left: 10px; padding-right: 10px; width: 60px;">
                                    <a href="#modalOpcaoEtapas" class="btn-floating green darken-3 modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar nova Etapa a esta Proposição.">
                                        <i class="material-icons">add</i>
                                    </a>
                                </div>
                                <div class="connector <?php echo 'title_'.$logFluxograma['id']; ?> block_etapa_mais_<?php echo $logFluxograma['id']; ?>">
                                    <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                </div>
                                <!-- Modal Structure -->
                                <?php
                                    /*
                                    *
                                    * MODAL OPÇÃO DE ADICIONAR Etapa >>>
                                    */
                                ?>
                                <div id="modalOpcaoEtapas" class="modal">
                                    <div class="modal-content">
                                        <h4>Adicionar nova Etapa</h4>
                                        <br>
                                        <br>
                                        <p>
                                            Nesta àrea, você poderá adicionar uma Etapa, pré-cadastrada no sistema ou definir uma nova Etapa.
                                        </p>
                                        <br>
                                        <br>
                        				<div class="row">
                        					<div class="col l6 m12 s12 center">
                        						<a class="waves-effect waves-light btn green darken-3 btn-etapaJaExistente" href="javascript:void(0);">
                        							<i class="material-icons left">playlist_add</i>
                        							Etapa Já Existente
                        						</a>
                        					</div>
                        					<div class="col l6 m12 s12 center">
                        						<a href="<?php echo $this->Html->url(array('controller' => 'Fluxogramas', 'action' => 'fluxoEtapasAdd', 'admin' => true, $pl_id, $logFluxograma['id'])); ?>" class="waves-effect waves-light btn green darken-3">
                        							<i class="material-icons left">add</i>Nova Etapa
                        						</a>
                        					</div>
                        				</div>
                                    </div>
                                </div>
                                <?php
                                    /*
                                    *
                                    * <<< MODAL OPÇÃO DE ADICIONAR Etapa
                                    */
                                ?>








                                <?php
                                    /*
                                    *
                                    * MODAL TODAS AS ORDENS >>>
                                    */
                                ?>
                                <div id="modalEtapas" class="modal">
                                    <div class="modal-content">
                                        <h4>Adicionar nova Etapa</h4>
                                        <br>
                                        <br>
                                        <p>
                                            Escolha qual a etapa deja vincular a está proposição.
                                        </p>
                                        <br>
                                        <br>
                                        <?=$this->Form->create('FluxogramaEtapa', array('class' => 'formFluxogramaEtapa'));?>
                            				<div class="row">
                                                <div class="input-field col s12">
                                    				<?php
                                    				   echo $this->Form->input('fluxo_etapa_id' ,  array(
                                    							   'label' => false,
                                    							   'div' => false,
                                    							   'type' => 'select',
                                    							   'class' => 'validate',
                                    							   'id' => 'selectTipo',
                                    							   'options' => $etapas,
                                                                   'empty' => ' -- Selecione -- ',
                                    						   ));
                                    				?>
                                    				<label>Etapas Pré-definidas:</label>
                                    			</div>
                                                <?php
                                                    echo $this->Form->input('fluxo_log_origem_id' ,  array(
                                                                'label' => false,
                                                                'div' => false,
                                                                'type' => 'hidden',
                                                                'id' => 'fluxo_log_origem_id',
                                                                'value' => $logFluxograma['id']
                                                            ));
                                                ?>
                            					<div class="col l6 m12 s12 center">
                            						<a class="waves-effect waves-light btn right red darken-3" href="javascript:void(0)">
                            							<i class="material-icons left">close</i>
                            							Cancelar
                            						</a>
                            					</div>
                            					<div class="col l6 m12 s12 center">
                                                    <?php
                                                        echo $this->Form->button('<i class="material-icons left">add</i>Adicionar' ,  array(
                                                            'label' => 'Salvar',
                                                            'type' => 'submit',
                                                            'div' => true,
                                                            'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
                                                        ));
                                                    ?>
                            					</div>
                            				</div>
                                        <?php echo $this->Form->end();?>
                                    </div>
                                </div>
                                <?php
                                    /*
                                    *
                                    * <<< MODAL TODAS AS ORDENS
                                    */
                                ?>

                                <?php
                            }

                            /*
                            *
                            * MAIS Etapas
                            * <<< Caso permissão de admin, poder add nova Etapa essa proposição
                            * enquanto a mesma, continua tendo este nome
                            */
                            $contFluxo = 0;
                        endforeach;
                        ?>
                    <?php
                        /*
                        *
                        * <<< caso a proposicao tenha tenha o fluxograma feito
                        */
                    ?>
				</div>
			</td>
		</tr>
	</table>
<?php echo $this->element('sql_dump'); ?>
