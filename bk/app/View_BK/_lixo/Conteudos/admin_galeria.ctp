<?php 
// print_r($conteudo); 
//print_r($galeria); 

// foreach($galeria as $imagem){
// 	print_r($imagem[$model]['img_file']);
// }


//print_r($medidas_imagens);

 ?> 
<div class="medium-8 columns">
				<?php 
					echo $this->Form->create($model, array('type'=>'file'));
					echo $this->Form->input('conteudo_id', array('type' => 'hidden', 'value' => $conteudo_id));
							?>
				<div class="row titulo-grid pRelative">
					<div class="small-12 columns">
						<h4>Galeria de "<?=$conteudo['Conteudo']['titulo']?>"</h4>

						<a href="<?=$this->Html->url(array('controller' => 'conteudos', 'action' => 'admin_edit', $conteudo_id))?>" class="radius button tiny bt-talkinghub">Editar Conteúdo</a>
					</div>
					<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
				</div>
				<div class='row'>
					<div class='medium-12 columns titulo-grid pBot'>
						<div class='row'>
							<div class='medium-11 columns' align='center'><h6>IMAGENS</h6></div>
							<div class='medium-11 columns hide-for-large-up text-left' align='center'><h6 class="alert-text">Obs.: não recomentamos alterações ou adicões de novas imagens através de um dispositivo móvel: celular ou tablet.</h6></div>

							<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_imagens'></div></div>
						</div>
						<div class='row' id='hide_imagens'>
							<div class='images_galeria medium-12 columns conteudos'>
								
								<div class='row'>
									<?php 
									$count = 0; 
									foreach($galeria as $imagem){
										$class_end = '';
										if ($count+1 == count($galeria)) {
											$class_end = 'end';
										}

								 		if($count < 4){
											?>
											<div class='medium-3 columns gal_imgs <?=$class_end?>' id='<?=$imagem[$model]['id']?>' >
												<?=$this->Html->image('../'.$imagem[$model]['img_file'])?>
												
													<div class='imgMenu'>
														<div class='img_edit'><a href='<?=$this->Html->url(
																	array(
																		'controller' => 'conteudos',
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
													<div class='medium-3 columns gal_imgs <?=$class_end?>' id='<?=$imagem[$model]['id']?>'>
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
																							'type' => 'file', 
																							//'div' => true,
																							//'class' => 'radius button tiny bt-talkinghub thirdary',
																							)); 
													?>																	
											</div>
											
											<div class="row">
												<div class="small-12 columns">
													<small>
														<?php
														$max_upload = (int)(ini_get('upload_max_filesize'));
														$max_post = (int)(ini_get('post_max_size'));
														$memory_limit = (int)(ini_get('memory_limit'));
														$upload_mb = min($max_upload, $max_post, $memory_limit);
		
		
														echo 'Peso máximo do arquivo: '. $upload_mb .' MB';
														?>
														<br>
														
														Largura máxima: <?=$medidas_imagens['img_file']['size']['w']?>px<br>
														Altura máxima: <?=$medidas_imagens['img_file']['size']['h']?>px
														<br>
														
														Extensões permitidas: <?php
																				$exts = '';
																				foreach($medidas_imagens['img_file']['ext'] as $ext) {
																					$exts .= $ext .', ';
																				}
																				
																				echo rtrim($exts, ', ');
																				?>
													</small>
												</div>
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