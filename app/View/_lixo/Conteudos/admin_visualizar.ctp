<?php
//print_r($conteudoVisualizar);
//print_r($galerias);
?>

<div class="medium-9 columns">
		<div class="row titulo-grid">
			<div class="small-12 columns">
				<h4>Visualizar</h4>

				<a href="<?=$this->Html->url(array('controller' => 'conteudos', 'action' => 'admin_edit', $conteudoVisualizar[$model]['id']))?>" class="radius button tiny bt-talkinghub">Editar</a>
	
				<?=$this->Form->postLink('Excluir',
						array('controller' => 'conteudos', 'action' => 'delete', $conteudoVisualizar[$model]['id']),
						array('confirm' => 'Tem certeza que deseja excluir este Conteudo?', 'class' => 'radius button tiny action alert bt-talkinghub')
					);
						?>

			</div>
			<div class='bt_voltar' onclick='window.history.back();'><div class='img'></div><p>VOLTAR</p></div>
		</div>
		<div class='row titulo-grid' style="padding-bottom: 20px;">
			<div class='small-6 small-centered columns simulador-dispositivo-view'>
				<div class='row'>
					<div class='medium-11 columns' align='center'><h6>APLICATIVO</h6></div>
					<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_app'></div></div>
				</div>
				<div>
					<div class='small-12 view view_center pBot' id='hide_app'>
						<div>
							<div style='top: 8px;color: #fff;text-align: center;width: 100%;'>
								<p style='font-size:26px; text-transform: uppercase; margin-left: 37px;'><?=$conteudoVisualizar['Categoria']['categoria']?></p>
							</div>



							<div style='top: 77px;width: 79%;left: 9%;text-align: center;'>
								<?php
								$this_time = $this->Time->format('l d F', $conteudoVisualizar[$model]['created']);
								$this_time = explode(" ", $this_time);
								$this_time = "{$dia_semana[$this_time[0]]} | {$this_time[1]} de {$meses[$this_time[2]]}";
								?>
								<p style='color:#5bb12f;'><?= $this_time;?></p>
							</div>

							<div style='top: 119px;width: 94%;left: 2%;' class='title'>
								<p style='font-size: 24px; text-transform: uppercase;color:#5bb12f;'><?=$conteudoVisualizar[$model]['titulo']?></p>
							</div>

							<div style='top: 200px;width: 96%;left: 2%;height: 400px;overflow: overlay;' class='text'>
								<p style='font-size: 20px;text-align: justify;padding-right: 20px;'> <?=$conteudoVisualizar[$model]['texto']?> </p>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<?php 
		if(!empty($galerias)){ 
			?>
			<div class='row'>
				<div class="small-6 view_center titulo-grid">


					<div class='row'>
						<div class='medium-11 columns' align='center'><h6>IMAGENS</h6></div>
						<div class='medium-1 columns'><div class='bt_hide _menos' data-toggle data-toggle-id='hide_imagens'></div></div>
					</div>
					<div id='hide_imagens'>
						<ul class='thumb small-block-grid-4'>
						<?php foreach($galerias as $fotos): ?>
							<li>
								<?=$this->Html->image('../'. $fotos['Galeria']['img_file'])?>
							</li>
						<?php endforeach ?>
						</ul>
						<div class='row'>
							<div class='medium-12 columns' align='center'>
								<a href="<?php echo $this->Html->url(array(
																	    "controller" => "conteudos",
																	    "action" => "galeria",
																	    $conteudoVisualizar[$model]['id']
																	)); ?>" class="radius button tiny bt-talkinghub thirdary">Upload</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
		} 
		?>
	</div>
