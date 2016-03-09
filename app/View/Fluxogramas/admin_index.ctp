<?php
$this->start('css');
    echo $this->Html->css(array(
                                '/assets/js-graph-it/js-graph-it.css',
                                '/assets/js-graph-it/sf-homepage.css',
                            ));
?>
<?php
$this->end();

$this->start('script');

// echo $this->Html->script('printThis.js');
echo $this->Html->script('jquery-print.js');
echo $this->Html->script('montaFluxograma.js');
?>

<?php
    echo $this->Html->script('/assets/js-graph-it/js-graph-it.js');
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.modal-trigger').leanModal();

            //PRINT
        	$('#btn').bind('click', function(p){
                var url = $('#urlSaveHtml').val();
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        table: $('#fluxoMain').html()
                    },
                    accepts: {json: 'application/json'},
                    success: function(data){
                        console.log(data);
                    },
                    error: function(data){
                        console.log('error');
                    }
                });

        	});

        });
    </script>
<?php
$this->end();
?>

    <!-- HEADER DA PÁGINA -->
    <div class="row padding-top-20">
        <div class="col s12 center-align">
            <h3 class="titulo-pagina">
                <?php
                    $proposicaoNome = $proposicao['PlType']['tipo']. ' ' .$proposicao['Pl']['numero_da_pl'].'/'.$proposicao['Pl']['ano'];
                ?>
                Fluxograma <?php echo $proposicaoNome; ?>
                <a href="javascript: void(0);" onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar">
                    <i class="material-icons">arrow_back</i>
                </a>
                <a href="javascript: void(0);" id="btn" class="btn-floating right green darken-3 tooltipped print hide" style="margin: 0 5px;" data-position="left" data-delay="50" data-tooltip="Imprimir">
                    <i class="material-icons">print</i>
                </a>
            </h3>
        </div>
    </div>
    <!-- / HEADER DA PÁGINA -->

    <input type="hidden" name="urlSaveHtml" id="urlSaveHtml" value="<?php echo $this->Html->url(array('controller' => 'Fluxogramas', 'action' => 'admin_fluxohtml')); ?>">
    <input type="hidden" name="componetFluxograma" id="componetFluxograma" value="<?php echo Router::url('/assets/js-graph-it/js-graph-it.js', true); ?>">

    <div class="row" id="fluxoMain">
        <div class="col s11 offset-s1 center-align">
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

                                // echo "<pre>";
                                // print_r($proposicao);
                                // echo "</pre>";
                                // die();
                                foreach( $registros['FluxogramaEtapa'] as $etapaKey => $logFluxograma ):
                                    $nomeTipo = $logFluxograma['PlType']['tipo'];
                                    if( $etapaKey == 0 ):
                                        $tituloTipoID = 'title_tipo_'.$logFluxograma['PlType']['id'];
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
                                        ?>
                                        <div id="<?php echo $classEtapaID; ?>" class="block draggable etapa" style="top: <?php echo $marginTopEtapa; ?>px;">
                                            <a href="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao['Pl']['id'])) ?>">
                                                <span class="posicaoAtualEtapa">
                                                    <?php
                                                        if( $proposicao['Pl']['etapa_id'] == $etapaID ){
                                                            echo '<p>'.$proposicaoNome. '</p>';
                                                        }
                                                    ?>
                                                </span>
                                                <strong>
                                                    <?php echo $etapaTitulo; ?>:
                                                </strong>
                                                <br>
                                                <br>
                                                <small>
                                                    <?php echo $etapaDescricao;?>
                                                </small>
                                            </a>
                                        </div>


                                        <?php
                                            /*
                                            *
                                            * Sub-Etapa >>>
                                            */
                                        ?>
                                        <?php
                                            $subEtapas = $logFluxograma['FluxogramaSubEtapa'];
                                            $classSubEtapaID = '';
                                            if( !empty($subEtapas) ){
                                                foreach( $subEtapas as $subEtapaKey => $subEtapa ):
                                                    $subEtapaID         = $subEtapa['id'];
                                                    $subEtapaTitulo     = $subEtapa['subetapa'];
                                                    $subEtapaDescricao  = $subEtapa['descricao'];
                                                    $classSubEtapaID    = 'block_subEtapa_da_etapaID_'.$subEtapaID;

                                                    if( $subEtapaKey == 0 ){
                                                        $marginTopSubEtapa = $marginTopEtapa;
                                                    }else{
                                                        $marginTopSubEtapa = $marginTopSubEtapa+200;
                                                    }
                                                    ?>
                                                    <div id="<?php echo $classSubEtapaID;?>" class="block draggable subEtapa" style="top: <?php echo round($marginTopSubEtapa); ?>px;">
                                                        <a href="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao['Pl']['id'])) ?>">
                                                            <span class="posicaoAtualSubEtapa">
                                                                <?php
                                                                if( $proposicao['Pl']['subetapa_id'] == $subEtapaID ){
                                                                    echo '<p>'.$proposicaoNome. '</p>';
                                                                }
                                                                ?>
                                                            </span>
                                                            <strong>
                                                                <?php echo $subEtapaTitulo.':';?>
                                                            </strong>
                                                            <br>
                                                            <br>
                                                            <small>
                                                                <?php echo $subEtapaDescricao;?>
                                                            </small>
                                                        </a>
                                                    </div>
                                                    <div class="connector <?php echo $classEtapaID; ?> <?php echo $classSubEtapaID;?>">
                                                        <label class="destination-label">
                                                            <?php
                                                                if( $proposicao['Pl']['subetapa_id'] == $subEtapaID ){
                                                                    echo '<p>'.CakeTime::format('d/m/Y à\s H:i\h\s', $proposicao['Pl']['modified']). '</p>';
                                                                }
                                                            ?>
                                                        </label>
                                                        <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                                    </div>
                                                    <?php
                                                endforeach;
                                            }else{
                                                $marginTopSubEtapa = $marginTopSubEtapa+150;
                                            }
                                        ?>
                                        <?php
                                            /*
                                            *
                                            * <<< Sub-Etapa
                                            */
                                        ?>

                                        <div class="connector <?php echo $tituloTipoID; ?> <?php echo $classEtapaID; ?> <?php echo $classSubEtapaID; ?>">
                                            <label class="destination-label">
                                                <?php
                                                    if( $proposicao['Pl']['etapa_id'] == $etapaID ){
                                                        echo '<p>'.CakeTime::format('d/m/Y à\s H:i\h\s', $proposicao['Pl']['modified']). '</p>';
                                                    }
                                                ?>
                                            </label>
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








                            <?php
                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                // historico >>>
                            ?>
                                <?php

                                    $h_marginTopEtapa     = $marginTopEtapa;
                                    $h_marginTopSubEtapa  = 0;
                                    foreach($historicoRegistros as $registros){
                                        foreach( $registros['FluxogramaEtapa'] as $etapaKey => $logFluxograma ):
                                            $h_nomeTipo = $logFluxograma['PlType']['tipo'];
                                            // echo "<pre>";
                                            // print_r( $logFluxograma );
                                            // echo "</pre>";
                                            // die();
                                            if( $etapaKey == 0 ):
                                                $h_tituloTipoID = 'h_title_tipo_'.$logFluxograma['PlType']['id'];
                                                ?>
                                                <h1 id="<?php echo $h_tituloTipoID;?>" class="block draggable" style="top: <?=$h_marginTopEtapa;?>px !important;">
                                                    <?php echo $h_nomeTipo; ?>
                                                    <small style="    line-height: 100%;font-size: 10px;">
                                                        <?php echo '<br>alterado em: '.CakeTime::format('d/m/Y', $logFluxograma['PlType']['modified']); ?>
                                                    </small>
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
                                                $h_classEtapaID   = 'h_block_etapaID_'.$etapaID;
                                                ?>
                                                <div id="<?php echo $h_classEtapaID; ?>" class="block draggable etapa" style="top: <?php echo $h_marginTopEtapa; ?>px;">
                                                    <a href="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao['Pl']['id'])) ?>">
                                                        <span class="posicaoAtualEtapa">
                                                            <?php
                                                            // foreach( array_unique($logFluxograma['LogAtualizacaoPl']) as $log ){
                                                            //     if(
                                                            //         ( $log['pl_id'] == $proposicao['Pl']['id'] )
                                                            //         // && ( $proposicao['Pl']['etapa_id'] == $log['etapa_id'] )
                                                            //         // && ( $log['fluxo_etapa_delete'] == 0 )
                                                            //         // && ( $log['pl_type_id'] == $proposicao['PlType']['id'] )
                                                            //
                                                            //     ){
                                                            //
                                                            //         echo "<pre>";
                                                            //         print_r( $proposicao );
                                                            //         echo "</pre>";
                                                            //     }
                                                            //
                                                            // }
                                                                // if( $logFluxograma['id'] == $etapaID ){
                                                                //     echo '<p>'.$proposicaoNome. '</p>';
                                                                // }
                                                            ?>
                                                        </span>
                                                        <strong>
                                                            <?php echo $etapaTitulo; ?>:
                                                        </strong>
                                                        <br>
                                                        <br>
                                                        <small>
                                                            <?php echo $etapaDescricao;?>
                                                        </small>
                                                    </a>
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
                                                            $h_classSubEtapaID    = 'block_subEtapa_da_etapaID_'.$subEtapaID;

                                                            if( $subEtapaKey == 0 ){
                                                                $h_marginTopSubEtapa = $h_marginTopEtapa;
                                                            }else{
                                                                $h_marginTopSubEtapa = $h_marginTopSubEtapa+200;
                                                            }
                                                            ?>
                                                            <div id="<?php echo $h_classSubEtapaID;?>" class="block draggable subEtapa" style="top: <?php echo round($h_marginTopSubEtapa); ?>px;">
                                                                <a href="<?php echo $this->Html->url(array('controller' => 'Pls', 'action' => 'ver_completo', 'admin' => true, $proposicao['Pl']['id'])) ?>">
                                                                    <span class="posicaoAtualSubEtapa">
                                                                        <?php
                                                                        // if( $proposicao['Pl']['subetapa_id'] == $subEtapaID ){
                                                                        //     echo '<p>'.$proposicaoNome. '</p>';
                                                                        // }
                                                                        ?>
                                                                    </span>
                                                                    <strong>
                                                                        <?php echo $subEtapaTitulo.':';?>
                                                                    </strong>
                                                                    <br>
                                                                    <br>
                                                                    <small>
                                                                        <?php echo $subEtapaDescricao;?>
                                                                    </small>
                                                                </a>
                                                            </div>
                                                            <div class="connector <?php echo $h_classEtapaID; ?> <?php echo $h_classSubEtapaID;?>">
                                                                <label class="destination-label">
                                                                    <?php
                                                                        if( $proposicao['Pl']['subetapa_id'] == $subEtapaID ){
                                                                            echo '<p>'.CakeTime::format('d/m/Y à\s H:i\h\s', $proposicao['Pl']['modified']). '</p>';
                                                                        }
                                                                    ?>
                                                                </label>
                                                                <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    }
                                                ?>
                                                <?php
                                                    /*
                                                    *
                                                    * <<< Sub-Etapa
                                                    */
                                                ?>


                                                <div class="connector <?php echo $h_tituloTipoID; ?> <?php echo $h_classEtapaID; ?> <?php echo $h_classSubEtapaID; ?>">
                                                    <label class="destination-label">
                                                        <?php
                                                            if( $proposicao['Pl']['etapa_id'] == $etapaID ){
                                                                echo '<p>'.CakeTime::format('d/m/Y à\s H:i\h\s', $proposicao['Pl']['modified']). '</p>';
                                                            }
                                                        ?>
                                                    </label>
                                                    <img class="connector-end" src="<?=$this->webroot?>assets/js-graph-it/arrow.gif">
                                                </div>
                                                <?php
                                                /*
                                                *
                                                * <<< Etapa
                                                */
                                                ?>
                                            <?php
                                            if( $h_marginTopSubEtapa != 0 ){
                                                $h_marginTopEtapa = $h_marginTopSubEtapa+150;
                                            }else{
                                                $h_marginTopEtapa = $h_marginTopEtapa+150;
                                            }
                                        endforeach;
                                    }
                                ?>

                            <?php
                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                //<<< historico
                            ?>
















        				</div>
        			</td>
        		</tr>

        	</table>
        </div>
    </div>
