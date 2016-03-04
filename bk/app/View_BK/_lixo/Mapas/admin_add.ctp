<?php //print_r($manifestacoes);
	
/*  print_r($cidade);  */

?>
<?=$this->Form->create($model, array('type' => 'file'))?>
<div class="medium-9 columns">
		<div class="row titulo-grid">
			<div class="small-12 columns">
				<h4>Adicionar Mapa de Manifestação</h4>
			</div>
			<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
		</div>
		<div class='row'>
			<div class='medium-6 columns'>
					<div class='row'>
						<div class='medium-12 columns titulo-grid'>
					
							<div class='row'>
								<div class='medium-12 columns' align='center'><h6>EMPRESA</h6></div>
							</div>
							<div class='row'>
																<!--checkbox-->
										<?php 
										            
							              echo $this->Form->select('Empresa', $empresas, array(   
							                                                    'id' => 'empresa',
							                                                    'multiple' => 'checkbox'
							                                                ));
							                                                ?>
									<!--checkbox -->

							</div>
						</div>

						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-12 columns' align='center'><h6>LOCALIZAÇÃO</h6></div>
							</div>
							<div class='row'>
								<div class='medium-12 columns'>
									<div class='row'>
										
										<div class='medium-4 columns'>
											<?=$this->Form->input('estado_id', array(	'label' => 'Estado',
																						'empty' => 'Selecionar',
																						'id'    => 'local_estate',
																						))?>

										</div>
										<div class='medium-8 columns'>
											<?=$this->Form->input('cidade_id', array(
																					'options' => array('Selecionar o Estado'),
																					'disabled' => true,
																					'id' => 'local_city',
 																					'value' => 'name'
 																					));?>										

										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
											<?=$this->Form->input('local', array(	'label' => 'Local da Manifestação',
																					'id'    => 'local_manifestacao',
																					'placeholder' => 'Paulista'
																						))?>

										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
										<?=$this->Form->input('ponto_partida', array(	
																					'label' => 'Ponto de partida',
																					'id'    => 'local_partida',
																					'placeholder' => 'Avenida Paulista'
																						))?>

										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
											<?=$this->Form->input('ponto_termino', array(	
																					'label' => 'Ponto de Término',
																					'id'    => 'local_chegada',
																					'placeholder' => 'Avenida Paulista'
																						))?>

										</div>
									</div>
								</div>
							</div>
						</div>

						<div class='medium-12 columns titulo-grid pBot'>
							<div class='row'>
								<div class='medium-12 columns' align='center'><h6>INFORMAÇÕES GERAIS</h6></div>
							</div>
							<div class='row'>
								<div class='medium-6 columns'>
									<?=$this->Form->input('horario', array(	'label' => 'Horário',
																		'id'    => 'geral_horario',
																		'placeholder' => '12h30m'
																						))?>

								</div>
								<div class='medium-6 columns'>
									<?=$this->Form->input('total_manifestantes', array(	'label' => 'Pessoas Confirmadas',
																					'id'    => 'geral_pessoas',
																					'placeholder' => '1000'
																						))?>

								</div>
							</div>
							<div class='row'>
								<div class='medium-12 columns'>
									<?=$this->Form->input('url_materia', array(	'label' => 'Fonte da Matéria',
																			'id'    => 'geral_fonte',
																			'placeholder' => 'http://www.site.com.br/noticia.html'
																						))?>

								</div>
							</div>
							<div class='row'>
								<div class='medium-12 columns'>
									<?=$this->Form->input('txt_impacto', array('type'	=> 'textarea',
																				'label' => 'Texto de Impacto',
																				'id'    => 'geral_impacto',
																			))?>

								</div>
							</div>
						</div>
					</div>

						

				<div class='row'>
					<div class='medium-11 columns' align='center'><h6>MAPA</h6></div>
					<div class='medium-1 columns'>
						<div class='bt_hide _menos' data-toggle data-toggle-id='hide_imagens'></div>
					</div>
				</div>
				<div id='hide_imagens'>
					<ul class='thumb small-block-grid-4'>
					<?php //foreach($galerias as $fotos): ?>
						<li>
							<?//=$this->Html->image('../'. $fotos['Galeria']['img_file'])?>
						</li>
					<?php //endforeach ?>
					</ul>
					<div class='row'>
						<div class='medium-12 columns' align='center'>
							<?php 
							echo $this->Form->input('img_mapa_file', array(
																		'label' => 'Upload',
																		'type' => 'file',
																		'div' => true,
																	    'class' => 'radius button tiny bt-talkinghub thirdary',
																	)); 																
							?>
							
						</div>
					</div>
				</div>












						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-12 columns' align='center'><h6>SALVAR</h6></div>
							</div>
							<div class='row'>
									<div class'medium-12 columns' align='center'>
										<?php 
											$options = array('0' => 'Rascunho', '1' => 'Publicar');
											$attributes = array('legend' => false,'id'=>'save', 'align'=>'center');
											
											echo $this->Form->radio('publicar', $options, $attributes);
										?>	
									</div>

							</div>
							<div class='row'>
								<div class='medium-12 columns' align='center'>
								<?= $this->Form->button('Salvar' ,  array(
																		'type' => 'submit', 
																		'div' => true,
																		'class' => 'radius tiny bt-talkinghub',
																	)
														); ?>
								</div>	
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class='medium-6 columns viewM simulador-dispositivo'>
				<div>
					<div style='top: 84px;width: 79%;left: 9%;text-align: center;' class='local'>
						<p style='color:#5bb12f;'></p>
					</div>

					<div style='top: 143px;left: 14%;' class='horario'>
						<p style='font-size: 18px;'></p>
					</div>

					<div style='top: 184px;left: 14%;' class='pessoas'>
						<p style='font-size: 18px;'></p>
					</div>

					<div style='top: 227px;left: 14%;' class='partida'>
						<p style='font-size: 18px;'></p>
					</div>

					<div style='top: 262px;left: 14%;' class='chegada'>
						<p style='font-size: 18px;'></p>
					</div>

					<div style='top:345px;width: 94%;left: 2%;' class='text'>
						<p style='font-size: 20px;color: #666;'></p>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<?=$this->Form->end()?>
