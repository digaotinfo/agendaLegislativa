<?php

/*
Parâmetros:
	$model
	$medidas_imagem
	$acao
	$coluna_banco
	$label
*/

if (empty($acao)){
	$acao = 'add';
}

$required_input = false;
if (empty($required)){
	$required_input = false;
}

///===============================================================
///	Edição de imagem - Requerimentos:
///	1) campo de nova imagem
///	2) campo hidden do nome da imagem atual para gravar no banco, caso não tenha alteração
///	3) preview da imagem atual
///	4) JS para eliminar imagem atual
///	5) campo hidden do nome da imagem atual para apagar
///===============================================================

	///==> dimensoes (inclusas no meio do input
	//echo 'largura: '. $medidas_imagens[$coluna_banco]['size']['w'] .' px ';
	//echo ', altura: '. $medidas_imagens[$coluna_banco]['size']['h'] .' px ';
	
	
	$max_width 	= '';
	$max_height = '';
	$size		= '';
	$th			= '';
	
	if (!empty($medidas_imagens[$coluna_banco]['size'])){
		$max_width 	= $medidas_imagens[$coluna_banco]['size']['w'];
		$max_height = $medidas_imagens[$coluna_banco]['size']['h'];
		$size		= $medidas_imagens[$coluna_banco]['size'];
		$src_img_temp = 'http://placehold.it/'. $max_width .'x'. $max_height;
		
	} else {
		$src_img_temp = 'http://placehold.it/100&text=livre';
		
	}
	
	$diretorio	= $medidas_imagens[$coluna_banco]['dir'];
	
	if (!empty($medidas_imagens[$coluna_banco]['th'])){
		$th			= $medidas_imagens[$coluna_banco]['th'];
	}
	
	$ext		= $medidas_imagens[$coluna_banco]['ext'];

	$nome_imagem_banco = '';
	
	$src_img = $src_img_temp;
	//if ($acao == 'edit') {
	//if (!empty($this->data)) {
		///==> nome da imagem que está no banco de dados
		if (!empty($this->data[$model][$coluna_banco])) {
			$src_img = $this->webroot.$this->data[$model][$coluna_banco];
			$nome_imagem_banco = $this->data[$model][$coluna_banco];
		}
	//}
	
	$ext_string = '';
	foreach($ext as $a):
		$ext_string .= $a .'|';
	endforeach;
	$ext_string = substr($ext_string, 0, -1);
	
	//print_r($this->request);
	//print_r($this->data[$model]);
	//echo '['. $this->data[$model][$coluna_banco] .']';








$this->start('script');
	?>
	<script>
	function readURL<?=$coluna_banco?>(input) {
		//alert(input);
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#<?=$coluna_banco?>_preview').attr('src', e.target.result);
				<?php
				/*
				if ($acao == 'edit'){ 
									?>
									$('#retorno_preview_<?=$coluna_banco?>').html('OBS.: A imagem ser√° alterada ap√≥s o click do bot√£o SALVAR');
									$('#<?=$coluna_banco?>_banco').val($('#<?=$coluna_banco?>_input').val());
									$('#acao_limpar_<?=$coluna_banco?> a').hide();
									<?php
								}*/
				
				?>
			}
			
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	function excluirImagem<?=$coluna_banco?>() {
		//var caminho_imagem = $('#<?=$coluna_banco?>_preview').attr('src');
		var caminho_imagem = $('#<?=$coluna_banco?>_nome_imagem').val();
		
	
		$.ajax({
			type: "POST",
			url: '<?=$this->webroot?>uploads/delete-file.php',
			data: {imagem: caminho_imagem},
			success: function(response){
				//alert(response);
				
				$('#<?=$coluna_banco?>_preview').attr('src', '<?=$src_img_temp?>');
				$('#<?=$coluna_banco?>_nome_imagem').val('');
				
			}
		});
	}
	
	
	$(function(){
		var btnUpload<?=$coluna_banco?>	= $('#<?=$coluna_banco?>_input');
		var status<?=$coluna_banco?>	= $('#<?=$coluna_banco?>_status');
		$('#<?=$coluna_banco?>_status').hide();
		
		new AjaxUpload(btnUpload<?=$coluna_banco?>, {
			action: '<?=$this->webroot?>uploads/upload-file.php',
			name: '<?=$coluna_banco?>',
			data: ['<?=$model?>', '<?=$coluna_banco?>', '<?=$acao?>', '<?=$diretorio?>', '<?=$max_width?>|<?=$max_height?>', '<?=$th["width"]?>|<?=$th["height"]?>', '<?=$ext_string?>'],
			onSubmit: function(file, ext){
				 if (! (ext && /^(<?=implode('|', $medidas_imagens[$coluna_banco]['ext']);?>)$/.test(ext))){ 
                    // extension is not allowed 
					status<?=$coluna_banco?>.text('Formato incorreto!');
					return false;
				}
				
				
				/////**************************/////
				/////**************************/////
				excluirImagem<?=$coluna_banco?>();
				
				$('#<?=$coluna_banco?>_status').slideDown();
				status<?=$coluna_banco?>.text('Uploading...');
				
				$('#bt_submit').hide();
				/////**************************/////
				/////**************************/////
			},
			onComplete: function(file, response){
				//On completion clear the status
				/////**************************/////
				/////**************************/////
				$('#<?=$coluna_banco?>_status').slideUp();
				status<?=$coluna_banco?>.text('');
				
				$('#bt_submit').show();
				/////**************************/////
				/////**************************/////
				
				
				//alert(response);
				
				$('#<?=$coluna_banco?>_preview').attr('src', '<?=$this->webroot?>'+(response));
				$('#<?=$coluna_banco?>_nome_imagem').val(response);
				
			}
		});
		
	});
	</script>
	<?php
$this->end();







	
	///==> input file
	echo $this->Form->input($coluna_banco.'_nome_imagem', 
											$options = array(
															'label' => false, 
															'div' => false,
															'type'=>'hidden', 
															'id' => $coluna_banco.'_nome_imagem', 
															'default' => $nome_imagem_banco,
															'required' => $required_input,
														)
	);
	?>
	


	<div class="small-12 columns">
		<div class="alert-box success radius" id="<?=$coluna_banco?>_status">
			
		</div>
	</div>
	
	<div class="large-2 medium-3 small-6 columns text-center">
		<div class="row">
			<div class="small-12 columns">
				<img src="<?=$src_img?>" class="th admin-th-form" id="<?=$coluna_banco?>_preview" />
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<!--
				<a href="javascript:<?php
										if ($acao == 'add'){ 
											?>$('#div_<?=$coluna_banco?>_preview').attr('src', '<?=$src_img?>');$('#<?=$coluna_banco?>_input').val('');<?php
										} else {
											?>if(confirm('Tem certeza que deseja apagar esta imagem?')){$('#<?=$coluna_banco?>_banco').val('');$('#div_<?=$coluna_banco?>_preview').attr('src', '<?=$src_img?>');}<?php
										}
										?>" class="radius button secondary small bt-talkinghub " style="margin-top:10px; margin-left:0 !important;">
										excluir
				</a>
				-->
				
				
				<a href="javascript:void(0);" onClick="if(confirm('Tem certeza que deseja apagar esta imagem?')){excluirImagem<?=$coluna_banco?>();}" class="radius button secondary small bt-talkinghub " style="margin-top:10px; margin-left:0 !important;">
					excluir
				</a>
			</div>
		</div>
	</div>
	
	<div id="upload" class="large-10 medium-9 small-6 columns">
		<div class="row">
			<div class="small-12 columns">
				&nbsp;
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<span class="radius button secondary" id="<?=$coluna_banco?>_input">Upload File</span>
			</div>
		</div>
		<?php
		if (!empty($max_width)){
			?>
			<div class="row">
				<div class="small-12 columns">
					<p class="italic between">
						Tamanho máximo de <?=$max_width?>px de largura por <?=$max_height?>px de altura
					</p>
				</div>
			</div>
			<?php
		}
		?>
		<div class="row">
			<div class="small-12 columns">
				<small><?php
				$max_upload = (int)(ini_get('upload_max_filesize'));
				$max_post = (int)(ini_get('post_max_size'));
				$memory_limit = (int)(ini_get('memory_limit'));
				$upload_mb = min($max_upload, $max_post, $memory_limit);


				echo 'Tamanho máximo de arquivo: '. $upload_mb .' MB';
				?></small>
			</div>
		</div>
		<!--
		<div class="row">
			<div class="small-12 columns">
				<small class="error">Este campo é obrigatório</small>
			</div>
		</div>
		-->
	</div>
									