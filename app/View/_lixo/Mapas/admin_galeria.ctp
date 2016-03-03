<?php 
/* print_r($manifestacao); */
/* print_r($galeriaManifestacao); */
 ?> 
<div class="medium-8 columns">
				<?php 
					echo $this->Form->create($model, array('type'=>'file'));
					echo $this->Form->input('manifestacao_id', array('type' => 'hidden', 'value' => $manifestacao['Mapa']['id']));
							?>
				<div class="row titulo-grid pRelative">
					<div class="small-12 columns">
						<h4>Galeria</h4>
					</div>
					<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
				</div>
				<div class='row'>
					<div class='medium-12 columns titulo-grid pBot'>
						<div class='row'>
							<div class='medium-11 columns' align='center'><h6>IMAGENS</h6></div>
							<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_imagens'></div></div>
						</div>
						<div class='row' id='hide_imagens'>
							<div class='images_galeria medium-12 columns manifestacoes'>
								
								<div class='row'>
								<?php 
									$count = 0; 
									foreach($galeriaManifestacao as $imagem){
									?>

									<?php 
							 		if($count < 4){
									?>
											<div class='medium-3 columns gal_imgs' id='<?=$imagem[$model]['id']?>' >
												<?=$this->Html->image('../'.$imagem[$model]['img_file'])?>
												
													<div class='imgMenu'>
														<div class='img_edit'><a href='<?=$this->Html->url(
																	array(
																		'controller' => 'mapas',
																		'action' => 'edit_legenda',
																		$imagem[$model]['id']
																	));?>' ><div></div></a></div>
														<div class='img_close'><p>x</p></div>
													</div>
													

														<div class='title_hold'>
														
																<p>
																	<?=$imagem[$model]['legenda']?>
																</p>
															
														</div>
												</div>
											
										<?php 
										$count++;

									} else {
									$count = 0;
									?>

								</div>
								<div class='row'>
										<div class='medium-3 columns gal_imgs' id='<?=$imagem[$model]['id']?>'>
											<?=$this->Html->image('../'.$imagem[$model]['img_file'])?>
											<div class='img_close'><p>x</p></div>
											<div class='title_hold'><p><?=$imagem[$model]['legenda']?></p></div>
										</div>


								<?php 
									}
								}
								?>
								</div>
							</div>
						</div>
					</div>

					<div class='medium-12 columns'>
						
					<div class="row titulo-grid pRelative">
						<div class="small-12 columns">
							<h4>Upload de Imagem</h4>
						</div>
					</div>
							<div class='row'>
								<div class='medium-12 columns'>
									<div class='row'>
									<?= $this->Form->input('legenda' ,  array(
																			'label' => 'Legenda',
																			'type' => 'text', 
																			'div' => true,
																					)); ?>	

									<div class='row'>
										<div class='row'>
											<div class='medium-4  columns' align='center'>
												&nbsp;
											</div>
											<div class='medium-4  columns' align='center'>
													<?=$this->Form->input('img_file' ,  array(
																							'label' => 'Upload',
																							'type' => 'file', 																									)); 
													?>																	
											</div>
											<div class='medium-4  columns' align='center'>
												&nbsp;
											</div>
										</div>
										<div class='row'>
											<div class='medium-12 columns' align='center'>
											<?= $this->Form->button('Adicionar' ,  array(
																						'label' => 'Adicionar',
																						'type' => 'submit', 
																						'div' => true,
																						'class' => 'radius button tiny bt-talkinghub thirdary',
																							)); ?>
													
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>


			<div class="medium-2 columns">&nbsp;</div>
			<?= $this->Form->end(); ?>
		</div>