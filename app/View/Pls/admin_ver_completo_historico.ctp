<?php
$this->start('script');
	?>
	<script>
	    $(document).ready(function(){
	        $('.datepicker').pickadate({
	            selectMonths: true, // Creates a dropdown to control month
	            selectYears: 15, // Creates a dropdown of 15 years to control year
	            monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
	            monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
	            weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
	            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
	            showMonthsShort: undefined,
	            showWeekdaysFull: undefined,
				today: 'Hoje',
				clear: 'Limpar',
				close: 'Fechar'
	        });

	    });
    </script>

    <?php
$this->end();
?>

    <?php if( !empty($proposicao[0]['PlType']) ): ?>
	<!-- HEADER DA PÁGINA -->
	<div class="row padding-top-20">
		<div class="col s12">
			<h3 class="titulo-pagina">
				<?php
					echo $proposicao[0]['PlType']['tipo']. ' ' .$proposicao[0]['Pl']['numero_da_pl'].'/'.$proposicao[0]['Pl']['ano'];
				?>
				<a href="javascript: void(0);"  onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
			</h3>
		</div>
		<div class="col s12">
			<?php echo $txtExplicativo; ?>
			Os dados abaixo são referente ao dia: <?php echo CakeTime::format($proposicao[0]['Fluxograma']['modified'], '%d/%m/%Y');; ?>
			<?=$this->Form->create('FormScreen', array('type' => 'file', 'class' => 'col s12 formulario formPL'));?>
			<?php
			if( !empty($dataFiltro) ){
				echo $this->Form->input('data', array(
					'class' => 'datepicker',
					'label' => false,
					'value' => $dataFiltro
				));
			}else{
				echo $this->Form->input('data', array(
					'class' => 'datepicker',
					'label' => false,
				));
			}
			?>

			<?php
			echo $this->Form->button('<i class="material-icons left">done</i>Buscar' ,  array(
				'type' => 'submit',
				'div' => true,
				'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
				'value' => $dataFiltro
			));
			?>

			<?php $this->end(); ?>
		</div>
	</div>
	<!-- / HEADER DA PÁGINA -->





	<div class="row padding-top-20">
        <?php
			$disabled = 'disabled';
			?>
			<div class="row">

				<div class="input-field col s12">
                    <?php
					echo $this->Form->input('tipo_id' ,  array(
									'label' => false,
									'div' => false,
									'type' => 'text',
									'class' => 'validate',
									'value' => $proposicao[0]['PlType']['tipo'],
									$disabled
								));
	   				?>
	   				<label for="nossaposicao_texto">Tipo:</label>
	   			</div>
				<?php if( !empty($proposicao[0]['Fluxograma']['etapa']) ){ ?>
					<div class="input-field col s12">
	                    <?php
						echo $this->Form->input('etapa' ,  array(
										'label' => false,
										'div' => false,
										'type' => 'text',
										'class' => 'validate',
										'id'	=> 'etapa',
										'value' => $proposicao[0]['Fluxograma']['etapa'],
										$disabled
									));
		   				?>
		   				<label for="etapa">Etapa:</label>
		   			</div>
				<?php } ?>
				<?php if( !empty($proposicao[0]['Fluxograma']['subetapa']) ){ ?>
					<div class="input-field col s12">
	                    <?php
						echo $this->Form->input('subetapa' ,  array(
										'label' => false,
										'div' => false,
										'type' => 'text',
										'class' => 'validate',
										'id'	=> 'subetapa',
										'value' => $proposicao[0]['Fluxograma']['subetapa'],
										$disabled
									));
		   				?>
		   				<label for="subetapa">Sub-Etapa:</label>
		   			</div>
				<?php } ?>
				<div class="input-field col s12">
					<?php
					   echo $this->Form->input('tema_id' ,  array(
								   'label' => false,
								   'div' => false,
								   'type' => 'text',
								   'class' => 'validate',
								   'id' => 'selectTema',
                                   'value' => $proposicao[0]['Fluxograma']['tema_name'],
								   $disabled
							   ));
					?>
					<label for="nossaposicao_texto">Tema:</label>
				</div>
	   			<div class="input-field col s6">
	   				<?php
	                       echo $this->Form->input('numero_da_pl', array(
	                           'label' => false,
	                           'id'    => 'numero_da_pl',
	                           'class' => 'validate',
	                           'div' => false,
                               'value' => $proposicao[0]['Pl']['numero_da_pl'],
							   $disabled
	                       ));
	                   ?>
	    				<label for="numero_pl">Número</label>
	   			</div>
	   			<div class="input-field col s6">
	   				<?php
	                       echo $this->Form->input('ano', array(
	                           'label' => false,
	                           'id'    => 'ano_pl',
	                           'class' => 'validate',
	                           'div' => false,
                               'value' => $proposicao[0]['Pl']['ano'],
							   $disabled
	                       ));
	                   ?>
	    				<label for="ano_pl">Ano</label>
	   			</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('link_da_pl' ,  array(
								'div' => false,
								'id' => 'link_pl',
								'class' => 'validate',
								'label' => false,
                                'value' => $proposicao[0]['Fluxograma']['link_da_pl'],
								$disabled
							));
					?>
					<label for="link_pl">Link</label>
				</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('apensados_da_pl' ,  array(
								'div' => false,
								'id' => 'apensados_da_pl',
								'class' => 'validate',
								'label' => false,
                                'value' => $proposicao[0]['Fluxograma']['apensados_da_pl'],
								$disabled
							));
					?>
					<label for="apensados_da_pl">Projetos Apensados</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('Autor.nome' ,  array(
								'type' => 'text',
								'div' => false,
								'id' => 'autor_nome',
								'class' => 'validate autocomplete',
                                'value' => $proposicao[0]['Fluxograma']['autor'],
								'label' => false,
								$disabled
							));
					?>
					<label for="autor_nome">Autor(a):</label>
				</div>
				<div class="input-field col s6">
					<?php
						echo $this->Form->input('Relator.nome' ,  array(
								'type' => 'text',
								'div' => false,
								'id' => 'relator_nome',
								'class' => 'validate autocomplete',
                                'value' => $proposicao[0]['Fluxograma']['relator'],
								'label' => false,
								$disabled
							));
					?>
					<label for="relator_nome">Relator(a):</label>
				</div>

				<div class="row">
		            <div class="input-field col s6 select-status">
		                <?php
		                    echo $this->Form->input('status_type_id' ,  array(
		                                'label' => false,
		                                'div' => false,
										'id' => 'status_type_id',
		                                'type' => 'text',
		                                'class' => 'validate',
		                                'value' => $proposicao[0]['Fluxograma']['status_type'],
		                                $disabled
		                            ));

                                    // print_r($proposicao);
		                ?>
		                <label for="nossaposicao_texto">Status:</label>
		            </div>
		            <div class="input-field col s6 right">
		                <div class="row">
		                    <div class="input-field col s6 m6 l6 center">
		                        <div class="">Prioridade</div>
		                    </div>
		                    <div class="input-field col s6 flag-prioridade right">
		                        <div class="switch center-align">
		                            <label>
		                                Não
		                                <?php
		                                    echo $this->Form->input('prioridade', array(
		                                        'type' => 'checkbox',
		                                        'label' => false,
		                                        'div' => false,
                                                'default' => $proposicao[0]['Fluxograma']['prioridade'],
		                                        $disabled
		                                    ));
		                                ?>
		                                <span class="lever"></span>
		                                Sim
		                            </label>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>

				<?php if( $userAdmin == 1 ): ?>
				<div class="row fluxograma">

					<div class="input-field col s12 select-fluxograma">
						<?php
							echo $this->Form->input('etapa_id' ,  array(
										'label' 	=> false,
										'div' 		=> false,
										'id' 		=> 'selectEtapa',
										'type' 		=> 'text',
										'class' 	=> 'validate',
                                        'value'     => $proposicao[0]['Fluxograma']['etapa'],
                                        $disabled
									));
						?>
						<label for="selectEtapa">Etapa atual no Fluxograma:</label>
					</div>

					<div class="input-field col s12 select-fluxogramaSubEtapa">
						<?php
							echo $this->Form->input('subetapa_id' ,  array(
										'label' 	=> false,
										'div' 		=> false,
										'id' 		=> 'selectSubEtapa',
										'type' 		=> 'text',
										'class' 	=> 'validate',
                                        'value'     => $proposicao[0]['Fluxograma']['subetapa'],
                                        $disabled
									));
						?>
						<label for="selectEtapa">Sub-Etapa atual no Fluxograma:</label>
					</div>
				</div>
				<?php endif; ?>


				<div class="row" id="retornoJustificativaTextoDigitado">
					<div class="col s12">
						<h5>
							<span class="black-text">
								Justificativa:
							</span>
						</h5>
						<div class="texto">
						</div>
						<?php
                            if( !empty($proposicao[4]['Justificativa']) ):
    							?>
    							<div class="atualizacao-feita ">
    								<small class="atualizacao-realizada">
    									<span>
    										em <strong id="dataHoraAtualizado"><?php echo CakeTime::format($proposicao[4]['Justificativa'][0]['modified'], '%d/%m/%Y às %H:%m');?></strong>

    									</span>
    								</small>
    								<strong class="dataHoraAtualizado">
    									<p class="text">
    										<?=$proposicao[4]['Justificativa'][0]['texto']?>
    									</p>
    								</strong>

    							</div>
    							<?php
                            endif;
						?>
						<hr>
					</div>
				</div>


				<div class="row">
		            <div class="col s12" id='notas_tecnicas'>
		                Notas Técnicas

							<br>
		                    <?php
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    //>>> UPLOAD
		                    ?>
		                    	<?php
									if(!empty($proposicao[7]['NotasTecnicas'])):
										foreach($proposicao[7]['NotasTecnicas'] as $nota){
											if(!empty($nota['arquivo']) ):
									?>
											<br>

												<div class="arquivoatual">
													<a href="<?php echo $nota['arquivo'];?>" target="_blank">
														<?php
															$arquivo = $nota['arquivo'];
															$arquivoNome = explode(Router::url('/uploads/notas_tecnicas/', true), $arquivo);
															echo $arquivoNome[1];
														?>
													</a>
												</div>
												<hr>
								<?php
											endif;
										}
									endif;
								?>
		                    <?php

			                ?>
		                    <?php
		                    //<<< UPLOAD
		                    //////////////////////////////////////////////////////////////////////
		                    //////////////////////////////////////////////////////////////////////
		                    ?>
		            </div>
		        </div>
			</div>
	</div>

	<div class="divider with-collapsible"></div>


    <div class="section" id="Foco" data-id-registro="">
        <h5>
            <span class="black-text">
                <?php echo 'Foco'; ?>
            </span>
            <?php if(!empty($proposicao[1]['Foco'])): ?>
                <small>| atualizado em <strong id="dataHora"><?php echo CakeTime::format($proposicao[1]['Foco'][0]['modified'], '%d/%m/%Y às %H:%M');?></strong></small>
            <?php endif; ?>
        </h5>
        <?php if(!empty($proposicao[1]['Foco'])): ?>
            <p class="text">
                <?php
                    echo $proposicao[1]['Foco'][0]['titulo'];
                ?>
            </p>
    <?php endif; ?>
    </div>
	<hr>

    <div class="section" id="OQueE" data-id-registro="">
        <h5>
            <span class="black-text">
                <?php echo 'O que é?'; ?>
            </span>
            <?php if(!empty($proposicao[2]['Oque_e'])): ?>
                <small>| atualizado em <strong id="dataHora"><?php echo CakeTime::format($proposicao[2]['Oque_e'][0]['modified'], '%d/%m/%Y às %H:%M');?></strong></small>
            <?php endif; ?>
        </h5>
        <?php if(!empty($proposicao[2]['Oque_e'])): ?>
            <p class="text">
                <?php
                    echo $proposicao[2]['Oque_e'][0]['titulo'];
                ?>
            </p>
    <?php endif; ?>
    </div>
	<hr>

    <div class="section" id="NossaPosicao" data-id-registro="">
        <h5>
            <span class="black-text">
                <?php echo 'Nossa Posição'; ?>
            </span>
            <?php if(!empty($proposicao[3]['NossaPosicao'])): ?>
                <small>| atualizado em <strong id="dataHora"><?php echo CakeTime::format($proposicao[3]['NossaPosicao'][0]['modified'], '%d/%m/%Y às %H:%M');?></strong></small>
            <?php endif; ?>
        </h5>
        <?php if(!empty($proposicao[3]['NossaPosicao'])): ?>
            <p class="text">
                <?php
                    echo $proposicao[3]['NossaPosicao'][0]['titulo'];
                ?>
            </p>
        <?php endif; ?>
    </div>
	<hr>


    <div class="section" id="Situacao" data-id-registro="">
        <h5>
            <span class="black-text">
                <?php echo 'Situação'; ?>
            </span>
            <?php if(!empty($proposicao[5]['Situacao'])): ?>
                <small> atualizado em <strong id="dataHora"><?php echo CakeTime::format($proposicao[5]['Situacao'][0]['modified'], '%d/%m/%Y às %H:%M');?></strong></small>
            <?php endif; ?>
        </h5>

        <?php foreach( $proposicao[5]['Situacao'] as $registro ): ?>
            <div class="texto">
                <div class="atualizacao-feita blockInf">
                    <small class="atualizacao-realizada">
                        <?php
                            ?>
                                <span class="">

                                        <strong id="dataHoraAtualizado">
                                            <?php
                                                echo CakeTime::format($registro['modified'], '%d/%m/%Y às %H:%M');
                                            ?>
                                        </strong>
                                </span>
                                <?php

                        ?>
                    </small>
                </div>
                <p class="text">
                    <?php
                        echo $registro['texto'];
                    ?>
                    <?php if(!empty($registro['arquivo']) && $registro['arquivo'] != Router::url('/', true)): ?>
                        <br>
                        <a href="<?php echo $this->webroot.$registro['arquivo']?>" target="_blank" class="waves-effect waves-light btn green darken-3">
                            <i class="material-icons left">file_download</i>Baixar Arquivo
                        </a>
                    <?php endif;?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
	<hr>



    <div class="section" id="Tarefas" data-id-registro="">
            <h5>
                <span class="black-text">
                    <?php echo 'Ação ABEAR'; ?>
                </span>
                <?php if( !empty($proposicao[6]['Tarefa']) ): ?>
                    <?php if(!empty($proposicao[6]['Tarefa'])): ?>
                        <small> atualizado em <strong id="dataHora"><?php echo CakeTime::format($proposicao[6]['Tarefa'][0]['modified'], '%d/%m/%Y às %H:%M');?></strong></small>
                    <?php endif; ?>
                <?php endif; ?>
            </h5>


        <?php if( !empty($proposicao[6]['Tarefa']) ): ?>
            <div class="row">
                <?php foreach( $proposicao[6]['Tarefa'] as $registro ):  ?>
                    <div class="col s12 m12 l6">

        				<div class="contentTarefaPl tarefa-nao-realizada">
        					<div class="texto tarefa_10" id="ver_Tarefa_10">
        						<div class="atualizacao-feita blockInf">
    								<span>
    									<i class="material-icons no-bold">date_range</i>
    										<strong id="dataHoraAtualizado">
    				                            <?php echo CakeTime::format($registro['entrega'], '%d/%m/%Y');?>
                                            </strong>
                                    </span>
        						</div>
        						<p class="titulo-tarefa">
        							<?php echo $registro['titulo']; ?>
                                </p>
        						<div class="text">
        							<p>
            							<?php echo $registro['texto']; ?>
                                    </p>
                                </div>
        					</div>
        					<hr>
        				</div>

        			</div>
                <?php endforeach;  ?>
            </div>
        <?php endif; ?>

    </div>
	<hr>

<?php else: ?>
    <!-- HEADER DA PÁGINA -->
    <div class="row padding-top-20">
        <div class="col s12">
            <h3 class="titulo-pagina">
				Nenhum registro encontrado nesta data.
				<a href="javascript: void(0);"  onclick='window.history.back();' class="btn-floating right grey darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
            </h3>
        </div>
		<div class="col s12">
			Os dados abaixo mostram a última atualização desta proposição na data de:
			<?=$this->Form->create('FormScreen', array('type' => 'file', 'class' => 'col s12 formulario formPL'));?>
			<?php
			if( !empty($dataFiltro) ){
				echo $this->Form->input('data', array(
					'class' => 'datepicker',
					'label' => false,
					'value' => $dataFiltro
				));
			}else{
				echo $this->Form->input('data', array(
					'class' => 'datepicker',
					'label' => false,
				));
			}
			?>

			<?php
			echo $this->Form->button('<i class="material-icons left">done</i>Buscar' ,  array(
				'type' => 'submit',
				'div' => true,
				'class' => 'btn waves-effect waves-light green darken-3 right margin-left-15',
				'value' => $dataFiltro
			));
			?>

			<?php $this->end(); ?>
		</div>
    </div>
    <!-- / HEADER DA PÁGINA -->

<?php endif; ?>
