<?php 
//print_r($manifestacoes[$model]);
//print_r($empresas);
//print_r($empresas);
//print_r($estados);
	
?>
<div class="medium-9 columns">
		<div class="row titulo-grid">
			<div class="small-12 columns">
				<h4>Editar Mapa de Mídia</h4>
			</div>
			<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
		</div>
		<div class='row'>
			<div class='medium-6 columns'>
				<?php
					echo $this->Form->create($model, array('type' => 'file'));
					echo $this->Form->input('id', array('type' => 'hidden', 'value' => $manifestacoes[$model]['id']));
					?>
				
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
					                                                    'multiple' => 'checkbox',
					                                                    'value' => $selecteds
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
											<?php
											echo $this->Form->input('estado_id',  array(
																						'options' => array('' => $estados_all ),
																						'default' => $estados[0]['Estado']['id'],
																						'label' => 'Estado',
																						'id'    => 'local_estate',
																						));
											
														?>

<!--
											<select id='local_estate'>
												<option value='<?=$estados[0]['Estado']['id']?>' selected><?=$estados[0]['Estado']['uf']?></option>
											</select>
-->
														
										</div>
										<div class='medium-8 columns'>
										
											<?php
												echo $this->Form->input('cidade_id', array(
																				'disabled' => true,
																				'id' => 'local_city',
																				'value' => 'name'
																					));?>

										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
											<?=$this->Form->input('local', array(	
																					'label' => 'Local da Manifestação',
																					'id'    => 'local_manifestacao',
																					'value' => $manifestacoes[$model]['local'],
																					'placeholder' => 'Paulista'
																						))?>

										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
										<?=$this->Form->input('ponto_partida', array(	'label' => 'Ponto de partida',
																						'id'    => 'local_partida',
																						'value' => $manifestacoes[$model]['ponto_partida'],
																						'placeholder' => 'Avenida Paulista'
																						))?>

										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
										<?=$this->Form->input('ponto_termino', array(	'label' => 'Ponto de Término',
																						'id'    => 'local_chegada',
																						'value' => $manifestacoes[$model]['ponto_termino'],
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
																				'value' => $manifestacoes[$model]['horario'],
																				'placeholder' => '12h30m'
																						))?>

								</div>
								<div class='medium-6 columns'>
								<?=$this->Form->input('total_manifestantes', array(	'label' => 'Pessoas Confirmadas',
																				'id'    => 'geral_pessoas',
																				'value' => $manifestacoes[$model]['total_manifestantes'],
																				'placeholder' => '1000'
																						))?>

								</div>
							</div>
							<div class='row'>
								<div class='medium-12 columns'>
								<?=$this->Form->input('url_materia', array(	'label' => 'Fonte da Matéria',
																				'id'    => 'geral_fonte',
																				'value' => $manifestacoes[$model]['url_materia'],
																				'placeholder' => 'http://www.site.com.br/noticia.html'
																						))?>

								</div>
							</div>
							<div class='row'>
								<div class='medium-12 columns'>
								<?=$this->Form->input('txt_impacto', array('type'	=> 'textarea',
																			'label' => 'Texto de Impacto',
																			'value' => $manifestacoes[$model]['txt_impacto'],
																			'id'    => 'geral_impacto',
																						
																						))?>

								</div>
							</div>
						</div>
						
						<!-- imagem -->
						<!--
						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-12 columns' align='center'><h6>IMAGENS</h6></div>
							</div>
							<div class='carousel'>
								<ul class='small-block-grid-4'>
									<li><?=$this->Html->image('http://wmh.github.io/jquery-scrollbox/img/normal_3206.png')?></li>
									<li><?=$this->Html->image('copa14/blog6.jpg')?></li>
									<li><?=$this->Html->image('http://wmh.github.io/jquery-scrollbox/img/normal_1459.png')?></li>
									<li><?=$this->Html->image('copa14/blog6.jpg')?></li>
									<li><?=$this->Html->image('http://wmh.github.io/jquery-scrollbox/img/normal_1295.png')?></li>
									<li><?=$this->Html->image('copa14/blog6.jpg')?></li>
									<li><?=$this->Html->image('http://wmh.github.io/jquery-scrollbox/img/normal_725.png')?></li>
									<li><?=$this->Html->image('copa14/blog6.jpg')?></li>
									<li><?=$this->Html->image('http://wmh.github.io/jquery-scrollbox/img/normal_485.png')?></li>
									<li><?=$this->Html->image('copa14/blog6.jpg')?></li>
									<li><?=$this->Html->image('http://wmh.github.io/jquery-scrollbox/img/normal_1590.png')?></li>
									<li><?=$this->Html->image('copa14/blog6.jpg')?></li>
								</ul>
								<div class='carousel_last'><</div>
								<div class='carousel_next'>></div>
							</div>
							<div class='row'>
								<div class='medium-12 columns' align='center'>
									<a href="javascript:void(0)" class="radius button tiny bt-talkinghub thirdary bt_carousel">Upload</a>
								</div>
							</div>
						</div>
						-->
						<!-- end imagem -->
						
						
						
				<div class="small-12 titulo-grid pBot">
					<div class='row'>
						<div class='medium-11 columns' align='center'><h6>MAPA</h6></div>
						<div class='medium-1 columns'>
							<div class='bt_hide _menos' data-toggle data-toggle-id='hide_imagens'></div>
						</div>
					</div>
					<div id='hide_imagens'>
						<ul class='thumb small-block-grid-4'>
							<li>
								<?=$this->Html->image('../'. $manifestacoes[$model]['img_mapa_th_hidden'])?>
							</li>
						</ul>
						<div class='row'>
							<div class='medium-12 columns' align='center'>
								<a href="<?php 
											echo $this->Form->input('img_mapa_file', array(
																							'label' => 'Upload',
																							'type' => 'file',																																					'div' => true,
																						    'class' => 'radius button tiny bt-talkinghub thirdary',
																						)); 																
											?> 
								</a>
							</div>
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
													$attributes = array('legend' => false,'id'=>'save', 'align'=>'center', 'value' => $manifestacoes[$model]['publicar'],);
													
													echo $this->Form->radio('publicar', $options, $attributes);
													?>	
									</div>

							</div>
							<div class='row'>
								<div class='medium-12 columns' align='center'>
								<?= $this->Form->button('Salvar' ,  array(
/* 																							'label' => 'Salvar', */
																							'type' => 'submit', 
																							'div' => true,
																							'class' => 'radius tiny bt-talkinghub',
																							)); ?>
<!-- 									<button type='submit' class='radius tiny bt-talkinghub'>Salvar</button> -->
								</div>
								
						<?=$this->Form->end()?>
							
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


	<div class="medium-2 columns">&nbsp;</div>
	
</div>