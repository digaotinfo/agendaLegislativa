<?php
$this->start('script');
	///
	?>
	<script charset="utf-8">
		$('#campo_tipo').change(function(){
			var texto_placeholder = 'Digite o número da proposição.';
			if ($(this).val() == 2) {
				texto_placeholder = 'Digite uma palavra chave.';
			}
			$('#campo_search').attr('placeholder', texto_placeholder);
		});

		//
		// $('#campo_search').keydown(function (e){
		// 	if(e.keyCode == 13){
		// 		console.log('teste');
		// 		$('form#<?=$model?>').submit();
		// 	}
		// })
	</script>
	<?php
$this->end();
?>
	<!-- HEADER DA PÁGINA -->
	<div class="row padding-top-20">
		<div class="col s12">
			 <h3 class="titulo-pagina">
				Proposições
				 <?php
	 			if ($userAdmin == 1){
	 				?>

				 	<a href="<?=$this->Html->url(array(
	 											'controller' => 'pls',
	 											'action' => 'add',
	 											'admin' => true
	 										));?>" class="btn-floating right  green darken-3 tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar nova PL"><i class="material-icons">add</i></a>
					<?php
				}
				?>
			 </h3>
		 </div>
	 </div>
	<!-- / HEADER DA PÁGINA -->



	<!--- BUSCA -->
	<div class="row padding-top-20">
		<div class="col s12">

			<?=$this->Form->create($model, array(
				'type' => 'get',
				'id' => $model,
			))?>
				<div class="col s12 m7 l6">
					<?php
					$padrao_campo_tipo = "1";
					if (!empty($this->request->query['tipo'])) {
						$padrao_campo_tipo = $this->request->query['tipo'];
					}
					echo $this->Form->input('tipo' ,  array(
						'label' => false,
						'div' => false,
						'type' => 'select',
						'id' => 'campo_tipo',
						'name' => 'tipo',
						'class' => 'browser-default',
						'options' => array(
							'1' => 'Realizar a buscar por nº da Proposição',
							'2' => 'Realizar a buscar por Texto',
						),
						'selected' => $padrao_campo_tipo,
					));
					?>
				</div>
				<div class="col s12">
					<nav class="grey darken-2">
						<div class="nav-wrapper">
							<div class="input-field">
								<?php
								$padrao_campo_busca = "";
								$placeholder_campo_busca = "Digite o número da proposição.";
								if (!empty($this->request->query['search'])) {
									$padrao_campo_busca = $this->request->query['search'];
								}
								if (!empty($this->request->query['tipo'])) {
									if ($this->request->query['tipo'] == 2) {
										$placeholder_campo_busca = "Digite uma palavra chave.";
									}
								}

							   	echo $this->Form->input('novabusca' ,  array(
										   'label' => false,
										   'div' => false,
										   'type' => 'hidden',
										   'default' => '1',
									   ));
							   	echo $this->Form->input('search' ,  array(
										   'label' => false,
										   'div' => false,
										   'type' => 'search',
										   'id' => 'campo_search',
										   'placeholder' => $placeholder_campo_busca,
										   'default' => $padrao_campo_busca,
									   ));
								?>
								<label for="search"><i class="material-icons">search</i></label>
							</div>
						</div>
					</nav>
				</div>
			<?=$this->Form->end();?>
		</div>
	</div>
	<!--- / BUSCA -->




	<!-- MIOLO -->
	<div class="row padding-top-20">
		<div class="col s12">


			<?php
			if (!empty($pls)) {
				?>

				<ul class="collapsible popout" data-collapsible="accordion">
					<?php foreach ($pls as $pl) :
						// print_r( count($pl['AtualizacaoExternaPl']) );
						// die();
						?>
						<li>
							<div class="collapsible-header  grey lighten-2">
								<i class="material-icons">turned_in</i>
								<span class="black-text">
									<?php
										if($pl['PlType']['tipo']){
											echo $pl['PlType']['tipo'].' ';
										}
										if($pl[$model]['numero_da_pl']){
											echo $pl[$model]['numero_da_pl'];
										}
										if($pl[$model]['ano']){
											echo '/'.$pl[$model]['ano'];
										}

										// print_r($pl );
										if( !empty($pl['AtualizacaoExternaPl']) ){?>
											<a href="<?php echo $this->Html->url(array(
												'controller' => 'pls',
												'action' => 'ver_completo',
												'admin' => true,
												$pl[$model]['id']
											)) ?>" class="btn-floating red right"><i class="material-icons">insert_chart</i></a>

											<?php
											// <a class="btn-floating red"><i class="material-icons">insert_chart</i></a>
										}

									?>
								</span>
								<span class="ultima-atualizacao hide-on-small-only">
									<small class="grey-text text-darken-1">| última atualização em <strong><?php echo CakeTime::format($pl[$model]['modified'], '%d/%m/%Y');?></strong></small>
								</span>
							</div>
							<div class="collapsible-body">
								<table class="table-valign-top">
									<tr>
										<td valign="top" width="40%" class="pl">
											<p>
												<a href="<?php echo $pl[$model]['link_da_pl']; ?>" class="grey-text" target="_blank">
													<i class="material-icons left">launch</i>
													Ver no site do Congresso
													<!-- Ver no site da Câmara -->
												</a>
											</p>
											<p>
												<strong class="black-text">Autor(a): </strong>
													<?php echo $pl['Autor']['nome'] ?>
												<br>
												<strong class="black-text">Relator(a): </strong>
													<?php echo $pl['Relator']['nome'] ?>
												<br>
											</p>
											<?php if( !empty($pl[$model]['apensados_da_pl']) ): ?>
												<p>
													<a href="<?php echo $pl[$model]['apensados_da_pl']; ?>" class="grey-text" target="_blank">
														<i class="material-icons left">launch</i>
														Ver Projeto Apensado
													</a>
												</p>
											<?php endif; ?>

											<?php if( !empty($pl['Pl']['etapa_id']) ): ?>
											<p>
												<?php echo $this->Html->link(
												    '<i class="material-icons left">insert_chart</i>Fluxograma',
												    array(
														'controller' => 'fluxogramas',
														'action' => 'index',
														'admin' => true,
														$pl[$model]['id']
												),
												    array('escape' => false, 'class' => 'green-text text-darken-3') // This line will parse rather then output HTML
												); ?>

											</p>
										<?php endif; ?>



											<p class="hide-on-large-only txt">
												<?php
													$a_models_relacionadas = array("Foco", "OqueE", "Situacao", "NossaPosicao");
													$a_models_relacionadas_titulos = array("Foco", "O que é?", "Situação", "Nossa posição");
													foreach($a_models_relacionadas as $key => $a_model_rel):
														if(!empty($pl[$a_model_rel][0]['txt'])){
												?>
														<strong class="black-text"><?php echo $a_models_relacionadas_titulos[$key]?>:</strong><br>
														<?php
															echo $this->Text->truncate(
																	strip_tags($pl[$a_model_rel][0]['txt']),
																	100,
																	array(
																		'ellipsis' => '...',
																		'exact' => false
																	)
																	);
														?>
														<br><br>
												<?php
														}
													endforeach;
												?>
											</p>

											<p class="hide-on-large-only center-align">
												<a href="<?php echo $this->Html->url(array(
													'controller' => 'pls',
													'action' => 'ver_completo',
													'admin' => true,
													$pl[$model]['id']
												)) ?>" class="waves-effect waves-light btn green darken-3">
													<i class="material-icons"></i>Ver Completo
												</a>
											</p>
										</td>
										<td class="hide-on-med-and-down txt-pl">
											<p>
												<?php
													$a_models_relacionadas = array("Foco", "OqueE", "Situacao", "NossaPosicao");
													$a_models_relacionadas_titulos = array("Foco", "O que é?", "Situação", "Nossa posição");

													foreach($a_models_relacionadas as $key => $a_model_rel):
														if(!empty($pl[$a_model_rel][0]['txt'])){
												?>

													<strong class="black-text"><?php echo $a_models_relacionadas_titulos[$key]?>:</strong><br>
													<?php
														echo $this->Text->truncate(
																strip_tags($pl[$a_model_rel][0]['txt']),
																100,
																array(
																	'ellipsis' => '...',
																	'exact' => false
																)
																);
													?>

													<br><br>

												<?php
														}
													endforeach;
												?>
											</p>
											<p>
												<a href="<?php echo $this->Html->url(array(
													'controller' => 'pls',
													'action' => 'ver_completo',
													'admin' => true,
													$pl[$model]['id']
												)) ?>" class="waves-effect waves-light btn right green darken-3">
													<i class="material-icons left"></i>Ver Completo
												</a>
											</p>
										</td>
									</tr>
								</table>

							</div>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php
			} else {

				if (!empty($busca)) {
					?>
					<h4 class="busca-nao-encontrada hide-on-med-and-down">
						Não foi encontrado nenhuma PL com a busca por <u><?=$busca?></u>
					</h4>
					<h5 class="busca-nao-encontrada hide-on-large-only">
						Não foi encontrado nenhuma PL com a busca por <u><?=$busca?></u>
					</h5>


					<?
				} else {
					?>
					<div class="col s12 m6 offset-m3">
						<div class="card blue-grey darken-1">
							<div class="card-content white-text">
								<span class="card-title">Olá!</span>
								<p>
									Ainda não temos nenhuma PL cadastrada.<br>
									Vamos cadastrar a primeira?
								</p>
							</div>
							<div class="card-action">
								<a href="<?=$this->Html->url(array(
			    											'controller' => 'pls',
			    											'action' => 'add',
			    											'admin' => true
			    										));?>" data-position="bottom" data-delay="50" data-tooltip="Adicionar nova PL">
														Começar agora!
								</a>

							</div>
						</div>
					</div>
					<?
				}
			}
			?>


		</div>
	</div>
	<!-- /MIOLO -->







	<!-- >>> PAGINATOR -->

<ul class="pagination ">
	<?php
	    if($this->params->paging[$model]['pageCount'] > 1):

			/*
			$this->Paginator->options(array(
				// 'search' => $this->request->data[$model]['search']
				'url' => $this->passedArgs
			));
			*/

	        echo $this->Paginator->prev(
	                '<i class="material-icons">chevron_left</i>',
	                array('tag' => 'li', 'escape' => false),
	                '',
	                array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false
	            )
	        );


			if (!empty($this->request->query['search'])) {
		        $numbers = $this->Paginator->numbers(array(
		                                        'separator' => '',
		                                        'currentClass' => 'active',
		                                        'tag' => 'li',
		                                        'options' => array(
																// 'search' => $this->request->data[$model]['search']
																// 'url' => $this->passedArgs
																'query' => $this->request->query['search']
															),
		        								));

			} else {
				$numbers = $this->Paginator->numbers(array(
		                                        'separator' => '',
		                                        'currentClass' => 'active',
		                                        'tag' => 'li',
		        								));
			}
	        $numbers = preg_replace("#\<li class=\"active\"\>([0-9]+)\<\/li\>#", "<li class=\"active\"><a href=''>$1</a></li>",$numbers);
	        echo $numbers;


	        echo $this->Paginator->next(
	            '<i class="material-icons">chevron_right</i>',
	            array('tag' => 'li', 'escape' => false),
	            '',
	            array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false
	        ));
	    endif;
	?>
</ul>

		<?php
			// $paginacao = $this->Paginator->params();
			// if ($paginacao['pageCount'] > 1) {
				?>
				<!-- <ul class="pagination ">
					<li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
					<li class="active"><a href="#!">1</a></li>
					<li class="waves-effect"><a href="#!">2</a></li>
					<li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
				</ul> -->
				<?php
				// echo $this->Paginator->prev(
				// 							'ANTERIOR',
				// 							null,
				// 							null,
				// 							array('id' => 'last')
				// 							);
				//
				// echo $this->Paginator->numbers(array(
				// 									 'separator' => '',
				// 									 'currentTag' => 'a',
				// 									 'tag' => 'div',
				// 									 'class' => 'bt'
				//
				// 									));
				//
				//
				// echo $this->Paginator->next(
				// 							'PRÓXIMO',
				// 							null,
				// 							null,
				// 							array('id' => 'next')
				// 							);
			// }
		?>

	<!-- <<< PAGINATOR -->







<?php

	/*
	*
	* printar email da camara para fazer a leitura dos dados necessarios >>>
	* =======================================>>>>
	*/
?>
<div class="" id="emailCamara" style="display: none !important;">
	<input type="hidden" id="atualizacaoCamaraURL" name="atualizacaoCamaraURL" value="<?php echo $this->Html->url(array('controller' => 'AtualizacaoExternaPls', 'action' => 'admin_atualizacaoCamara'))?>">
	<?php

		// echo "<pre>";
		if( !empty($email) ){
			echo "<br>";
			echo $email;
		}
		// echo "</pre>";
		// die();
	?>
</div>
<?php
	/*
	* <<< =======================================
	*
	* <<< printar email da camara para fazer a leitura dos dados necessarios
	*/

?>
