<?php
	//print_r($empresas)
	//print_r($selecteds);
	//print_r($conteudo[$model]);
	//print_r($categorias);
	//print_r($model);

//print_r($this->request->data);
//die();

echo $this->Form->create($model);
?>
<div class="medium-9 columns">
		<div class="row titulo-grid">
			<div class="small-12 columns">
				<h4>Editar Conteúdo</h4>
			</div>
			<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
		</div>
		<div class='row'>
			<div class='medium-6 columns'>
				<?php
				echo $this->Form->input('id', array('type' => 'hidden'));
				?>
					<div class='row'>

						<!--CATEGORIAS -->
						<div class='medium-12 columns titulo-grid'>

							<div class='row'>
								<div class='medium-11 columns' align='center'><h6>CATEGORIA</h6></div>
								<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_categ'></div></div>
							</div>

							<div class='row' id='hide_categ'>
								<div class='small-12 columns end'>
								<?=$this->Form->input('categoria_id', array(
																		'options' => array('' => $categorias),
																		//'default' => array($categoria['Categoria']['id']),
																		'label' => false,
																		'id'    => 'categorias',
																	));
									?>
								</div>
							</div>
						</div>
						<!-- END CATEGORIAS -->

						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-11 columns' align='center'><h6>SETOR</h6></div>
								<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='checkboxes'></div></div>
							</div>
							<div class='row' id='checkboxes'>
							<!--checkbox-->
								<?php
								echo '<p style="color: #616161;">Selecione o(s) Setor(es): </p>';
								echo $this->Form->input('todos', array(   
						                                                'id' => 'empresa',
						                                                'type' => 'checkbox',
						                                                'class' => 'empresas',
						                                                'onChange' => 'todos(this)'
						                                            ));
						        echo '<p></p>';
					              echo $this->Form->select('Setor', $setores, array(
					                                                    'id' => 'setor',
					                                                    'multiple' => 'checkbox',
					                                                    //'value' => $selecteds
					                                                ));
					                                                ?>
							<!--checkbox -->
							</div>
						</div>

						
						
						<script>
							function copiarParaCampoFrasePush() {
								$('#push_frase').val($('#news_titulo').val());
							}
						</script>
						<?php
						$this->start('script');
							?>
							<script>
							$('document').ready(function(){
								copiarParaCampoFrasePush();
							});
							</script>
							<?php
						$this->end();
						?>
						
						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-11 columns' align='center'><h6>NOTÍCIA</h6></div>
								<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_noticia'></div></div>
							</div>
							<div class='row pBot' id='hide_noticia'>
								<div class='medium-12 columns'>
									<div class='row'>
										<div class='medium-12 columns'>
											<?=$this->Form->input('titulo', array(	'label' => 'Titulo',
																					'id'    => 'news_titulo',
																					'maxlength' => '100',
																					//'value' => $conteudo[$model]['titulo'],
																					'onKeyUp' => 'copiarParaCampoFrasePush()',
																				))?>
										</div>
									</div>
									<div class='row'>
										<div class='medium-12 columns'>
											<?=$this->Form->input('texto', array('type'	=> 'textarea',
																					'label' => 'Texto',
																					'id'    => 'news_text',
																					//'value' => $conteudo[$model]['texto']
																				))?>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						
						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-11 columns' align='center'><h6>PUSH NOTIFICATION</h6></div>
								<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_push'></div></div>
							</div>
							<div id='hide_push'>
								<div class='row'>
									<div class='medium-12 columns'>
										<?php
										$attributes = array(
															'legend' => 'Enviar Push Notification',
															'type' => 'checkbox',
															'id'=>'pushnotification', 
															'data-toggle data-toggle-id' => 'hide_push_frase'
													);

										echo $this->Form->input('enviarpush', $attributes);
										?>
									</div>
								</div>
								<div class='row'>
									<div class='medium-12 columns hide' id="hide_push_frase">
										<?=$this->Form->input('push_frase' ,  array(
																					'label' => 'Frase do Push Notification',
																					'id' => 'push_frase',
																				)); ?>
									</div>
								</div>
							</div>
						</div>

						<div class='medium-12 columns titulo-grid'>
							<div class='row'>
								<div class='medium-11 columns' align='center'><h6>SALVAR</h6></div>
								<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_save'></div></div>
							</div>
							<div id='hide_save'>
								<div class='row'>
									<?php
										$options = array('0' => 'Rascunho', '1' => 'Publicar');
										//$attributes = array('legend' => false,'id'=>'save', 'align'=>'center', 'value' => $conteudo[$model]['publicar']);
										$attributes = array('legend' => false,'id'=>'save', 'align'=>'center');

										echo $this->Form->radio('publicar', $options, $attributes);
										?>
								</div>
								<div class='row'>
									<div class='medium-12 columns' align='center'>
										<?php
										echo $this->Form->button('Salvar',  array('label' => 'salvar',
																				 'type' => 'submit',
																				 'div' => true,
																				 'class' => 'radius tiny bt-talkinghub',
																			));
										?>
									</div>
								</div>
							</div>
						</div>
					</div>

			</div>



			<div class='medium-6 columns view simulador-dispositivo'>
				<div>
					<div class="categoria">
						<p><?=$this->request->data['Categoria']['categoria']?></p>
					</div>

					<div class="data">
						<?php
						$this_time = $this->Time->format('l d F', $this->request->data[$model]['created']);
						$this_time = explode(" ", $this_time);
						$this_time = "{$dia_semana[$this_time[0]]} | {$this_time[1]} de {$meses[$this_time[2]]}";
						?>
						<p><?= $this_time; ?></p>
					</div>
					
					<div class="conteudo-geral">
						<div class='title'>
							<p><?=$this->request->data[$model]['titulo']?></p>
						</div>
						
						<div class='text'>
							<p><?=$this->request->data[$model]['texto']?></p>
						</div>
					</div>
				</div>
			</div>



		</div>
	</div>
</div>

<?php
echo $this->Form->end()
?>
