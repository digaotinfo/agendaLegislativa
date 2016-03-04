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
    .propAdicionadas{
        color: #000;
        font-size: 10px;
    }
    .fluxograma .etapa .propAdicionadas strong,
    .fluxograma .subEtapa small.propAdicionadas strong {
        margin-bottom: 0px !important;
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
            $('#selectTipo').change(function(){
				var valor = $('#selectTipo').val();
                var urlRedirectTipo = "<?php echo $this->Html->url(array('controller' => 'Fluxogramas', 'action' => 'admin_fluxoGeralVerGeral'))?>/"+valor;
                window.location.replace(urlRedirectTipo);
                console.log(valor);
            });
        });
    </script>
<?php
$this->end();
?>

    <!-- HEADER DA PÁGINA -->
    <div class="row padding-top-20">
        <div class="col s12 center-align">
            <div class="input-field col s12">
                <?php
                echo $this->Form->input('tipo_id' ,  array(
                    'label' => false,
                    'div' => false,
                    'type' => 'select',
                    'class' => 'browser-default',
                    'id' => 'selectTipo',
                    'options' => $tipos,
                    'empty' => 'Escolha o Tipo',
                    'default'   => $registros['PlType']['id']
                ));
                ?>
                <h3 class="titulo-pagina">
                    Fluxograma <?php echo $registros['PlType']['tipo']; ?>

                    <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar">
                        <i class="material-icons">arrow_back</i>
                    </a>
                </h3>
            </div>
        </div>
    </div>
    <!-- / HEADER DA PÁGINA -->

<div class="row">
    <div class="col s12 center-align">
        <table class="main_table fluxograma" style="height: 100%;" >
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
                            $marginTopEtapa     = 0;
                            $marginTopSubEtapa  = 0;

                            foreach( $registros['FluxogramaEtapa'] as $etapaKey => $logFluxograma ):
                                $nomeTipo = $registros['PlType']['tipo'];
                                if( $etapaKey == 0 ):
                                    $tituloTipoID = 'title_tipo_'.$logFluxograma['PlType']['id'];
                                    // echo "<pre>";
                                    // print_r($logFluxograma['Pl']);
                                    // echo "</pre>";
                                    // die();
                                    ?>
                                    <h1 id="<?php echo $tituloTipoID;?>" class="block draggable">
                                        <?php echo $nomeTipo; ?>
                                    </h1>
                                    <?php
                                endif;
                                ?>

                                <?php
                                    /*
                                    *
                                    * Etapa >>>
                                    */
                                    $etapaID        = $logFluxograma['id'];
                                    $etapaTitulo    = $logFluxograma['etapa'];
                                    $etapaDescricao = $logFluxograma['descricao'];
                                    $classEtapaID   = 'block_etapaID_'.$etapaID;
                                    $classSubEtapaID = '';
                                    ?>
                                    <div id="<?php echo $classEtapaID; ?>" class="block draggable etapa" style="top: <?php echo $marginTopEtapa; ?>px;">
                                        <strong>
                                            <?php echo $etapaTitulo; ?>:
                                        </strong>
                                        <br>
                                        <br>
                                        <small>
                                            <?php echo $etapaDescricao;?>
                                        </small>
                                        <br>
                                        <br>

                                        <small class="propAdicionadas">
                                            <strong>Prop. Existentes: </strong>
                                            <br>
                                            <p>
                                                <?php
                                                foreach( $logFluxograma['Pl'] as $proposicao ){
                                                    if( $proposicao['etapa_id'] == $etapaID):
                                                        ?>
                                                        <a href="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao['id'])); ?>">
                                                            <?php
                                                                echo $nomeTipo. ' ' .$proposicao['numero_da_pl']. '/' .$proposicao['ano']. ' | ';
                                                            ?>
                                                        </a>
                                                        <?php
                                                    endif;
                                                }
                                            ?>
                                            </p>
                                        </small>
                                    </div>


                                    <?php
                                        /*
                                        *
                                        * Sub-Etapa >>>
                                        */
                                    ?>
                                    <?php
                                        $subEtapas = $logFluxograma['FluxogramaSubEtapa'];
                                        if( !empty($subEtapas) ){
                                            foreach( $subEtapas as $subEtapaKey => $subEtapa ):
                                                $subEtapaID         = $subEtapa['id'];
                                                $subEtapaTitulo     = $subEtapa['subetapa'];
                                                $subEtapaDescricao  = $subEtapa['descricao'];
                                                $classSubEtapaID    = 'block_subEtapa_da_etapaID_'.$subEtapaID;

                                                if( $subEtapaKey == 0 ){
                                                    $marginTopSubEtapa = $marginTopEtapa;
                                                }else{
                                                    $marginTopSubEtapa = $marginTopSubEtapa+320;
                                                }
                                                // echo "<pre>";
                                                // print_r($subEtapas);
                                                // echo "</pre>";
                                                // die();
                                                ?>
                                                <div id="<?php echo $classSubEtapaID;?>" class="block draggable subEtapa" style="top: <?php echo round($marginTopSubEtapa); ?>px;">
                                                    <strong>
                                                        <?php echo $subEtapaTitulo.':';?>
                                                    </strong>
                                                    <br>
                                                    <br>
                                                    <small>
                                                        <?php echo $subEtapaDescricao;?>
                                                    </small>
                                                    <br >
                                                    <?php if( count($logFluxograma['Pl']) >= 0 ): ?>
                                                        <small class="propAdicionadas">
                                                            <strong>Prop. Existentes: </strong>
                                                            <br>
                                                            <p>
                                                                <?php
                                                                foreach( $logFluxograma['Pl'] as $proposicao ){
                                                                    if( $proposicao['subetapa_id'] == $subEtapaID):
                                                                        ?>
                                                                        <a href="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao['id'])); ?>">
                                                                            <?php
                                                                                echo ' '.$nomeTipo. ' ' .$proposicao['numero_da_pl']. '/' .$proposicao['ano']. ' ';
                                                                            ?>
                                                                        </a>
                                                                        |
                                                                        <?php
                                                                    endif;
                                                                }
                                                                ?>
                                                            </p>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="connector <?php echo $classEtapaID; ?> <?php echo $classSubEtapaID;?>">
                                                    <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                                </div>
                                                <?php
                                            endforeach;
                                        }else{
                                            $marginTopSubEtapa = $marginTopSubEtapa+180;
                                        }
                                    ?>
                                    <?php
                                        /*
                                        *
                                        * <<< Sub-Etapa
                                        */
                                    ?>

                                    <div class="connector <?php echo $tituloTipoID; ?> <?php echo $classEtapaID; ?> <?php echo $classSubEtapaID; ?>">
                                        <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                    </div>



                                    <?php
                                    /*
                                    *
                                    * <<< Etapa
                                    */
                                    ?>
                                <?php
                                if( $marginTopSubEtapa != 0 ){
                                    $marginTopEtapa = $marginTopSubEtapa+200;
                                }else{
                                    $marginTopEtapa = $marginTopEtapa+150;
                                }
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
    </div>
</div>


<?php //echo $this->element('sql_dump'); ?>
