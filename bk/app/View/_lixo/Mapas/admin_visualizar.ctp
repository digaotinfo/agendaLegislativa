<?php 
//print_r($manifestacoes) 
?>
<div class="medium-9 columns">
	<div id='conteudoG'>
		<div class='open_div'>
			<div class="row titulo-grid">
				<div class="small-12 columns">
					<h4>Visualizar</h4>
				</div>
				
				<div class='bt_voltar' onclick='window.history.back();'>
					<div class='img'></div>
					<p>VOLTAR</p>
				</div>
			</div>
	
	
			<div class='row'>
				<div class='small-12 medium-centered columns viewM'>
					<div>
						<div style='top: 84px;width: 79%;left: 9%;text-align: center;' class='local'>
							<p style='color:#5bb12f;'><?=$manifestacoes[$model]['local']?></p>
						</div>
			
						<div style='top: 143px;left: 14%;' class='horario'>
							<p style='font-size: 18px;'><?=$manifestacoes[$model]['horario']?></p>
						</div>
			
						<div style='top: 184px;left: 14%;' class='pessoas'>
							<p style='font-size: 18px;'><?=$manifestacoes[$model]['total_manifestantes']?></p>
						</div>
			
						<div style='top: 227px;left: 14%;' class='partida'>
							<p style='font-size: 18px;'><?=$manifestacoes[$model]['ponto_partida']?></p>
						</div>
			
						<div style='top: 262px;left: 14%;' class='chegada'>
							<p style='font-size: 18px;'><?=$manifestacoes[$model]['ponto_termino']?></p>
						</div>
			
						<div style='top:345px;width: 94%;left: 2%;' class='text'>
							<p style='font-size: 20px;color: #666;'><?=$manifestacoes[$model]['txt_impacto']?></p>
						</div>
			
					</div>
				</div>
			</div>
			
			<?php 
			if(!empty($manifestacoes)) { 
				?>
				<div class='row'>
					<div class="small-6 view_center titulo-grid">
		
						<div class='row'>
							<div class='small-11 columns' align='center'><h6>Mapa</h6></div>
							<div class='small-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_imagens'></div></div>
						</div>
						<div class="row" id='hide_imagens'>
							<?php
							if (!empty($manifestacoes[$model]['img_mapa_file'])) {
								?>
								<ul class='thumb small-block-grid-4'>
									<li>
										<?=$this->Html->image('../'. $manifestacoes[$model]['img_mapa_file'])?>
									</li>
								</ul>
								<?php
							}
							?>
							<div class='row'>
								<div class='medium-12 columns' align='center'>
									<a href="<?php echo $this->Html->url(array(
																		    "controller" => "mapas",
																		    "action" => "edit",
																		    $manifestacoes[$model]['id']
																		)); ?>" class="radius button tiny bt-talkinghub thirdary">Editar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php 
			} 
			?>
		</div>
		<!-- </div> -->
	</div>
</div>