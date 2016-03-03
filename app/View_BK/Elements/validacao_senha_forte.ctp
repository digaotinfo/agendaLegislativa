<?php
	//echo $this->Html->script('jquery.complexify.js');
	//echo $this->Html->script('password_strength_plugin.js');
	
	///////////////////////////
	///// CAMPOS PADRÕES
	/// IDs: #senha_1 e #senha_2
	
	//print_r($this->request->params['action']);
	
$this->start('script');
	?>
	<script>
			
		$(document).ready(function(){
			<?php
			if ($this->request->params['action'] != 'admin_edit') {
				?>
				//$("form input[type='submit']").prop('disabled', true);
				passwordStrength($('#senha_1').val());
				passwordVerify($('#senha_2').val());
				<?php
			}
			?>
			
			$('form').submit(function(){
				<?php
				if ($this->request->params['action'] != 'admin_edit') {
					?>
					if ($('#senha_2').val() == ''){
						alert('As senhas digitadas não conferem.');
						$('#senha_2').attr('style', 'border: solid 1px red;').focus();
						
						return false;
					}
					<?php
				} else {
					?>
					if ($('#senha_2').val() == '' && $('#senha_1').val() != ''){
						alert('As senhas digitadas não conferem.');
						$('#senha_2').attr('style', 'border: solid 1px red;').focus();
						
						return false;
					}
					<?php
				}
				?>
				//debugger
				
			});
		});
	
		function passwordStrength(password) {
			var desc = new Array();
			desc[0] = "Não aceita";
			desc[1] = "Muito Fraca";
			desc[2] = "Fraca";
			desc[3] = "Boa";
			desc[4] = "Forte";
			desc[5] = "Extreme";
		
			var score   = 0;
		
			//if password bigger than 6 give 1 point
			if (password.length > 7) score++;
		
			//if password has both lower and uppercase characters give 1 point	
			if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
		
			//if password has at least one number give 1 point
			if (password.match(/\d+/)) score++;
		
			//if password has at least one special caracther give 1 point
			if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
		
			//if password bigger than 12 give another 1 point
			if (password.length > 12) score++;
			
			
			if (password.length < 8 && score == 3) score=2;
		
			 document.getElementById("passwordDescription").innerHTML = desc[score];
			 document.getElementById("passwordStrength").className = "strength" + score;
			 
			 //console.log(score);
			 
			 //var total = (score * 100)/6;
			 //
			 //console.log(total);
			 //
			 //$('#mtSenha').val(total);
			 
			 if (score >= 3) {
			 	if ($('#login').val() == password) {
				 	score = 0;
				 	$('#senha_1').attr('style', 'border: solid 1px red;');
				 	document.getElementById("passwordDescription").innerHTML = '<span style="color:red;"><strong>A senha não pode ser igual ao usuário</strong></span>';
				 	document.getElementById("passwordStrength").className = "strength" + score;
			 	} else {
				 	$('#senha_1').attr('style', '');
				 	$("form input[type='submit']").prop('disabled', false);
			 	}
				
			 } else {
				 $('#senha_1').attr('style', '');
				 //$("form input[type='submit']").prop('disabled', true);
			 }
			 
		}
		
		function passwordVerify(campo_2) {
			var campo_1 = $('#senha_1').val();
			var tamanho_campo_1 = campo_1.length;
			//console.log(tamanho_password);
			
			//if (tamanho_campo_1 >= 8) {
				if (campo_2.length > 0) {
					if (campo_1 != campo_2) {
						$("form input[type='submit']").prop('disabled', true);
						$('#senha_2').attr('style', 'border: solid 1px red;');
						
						alert('As senhas digitadas não conferem.');
						//return false;
					} else {
						$("form input[type='submit']").prop('disabled', false);
						$('#senha_2').attr('style', '');
					}
				} else {
					$("form input[type='submit']").prop('disabled', true);
					$('#senha_2').attr('style', 'border: solid 1px red;');
				}
			//}
		}
	</script>
	<?php
$this->end();
?>
<style>
#passwordStrength
{
	height:10px;
	display:block;
	float:left;
}

#passwordDescription {
	float: left;
	margin-right: 10px;
	min-width: 100px;
	clear: none;
}

.strength0
{
	width:250px;
	background:#cccccc;
}

.strength1
{
	width:50px;
	background:#ff0000;
}

.strength2
{
	width:100px;	
	background:#ff5f5f;
}

.strength3
{
	width:150px;
	background:#56e500;
}

.strength4
{
	background:#4dcd00;
	width:200px;
}

.strength5
{
	background:#399800;
	width:250px;
}
.holder-meter {
	/* width: 265px; */
	/* height: 25px; */
	display: block;
	float: left;
	/* clear: none; */
	/* margin-right: 10px; */
	background: #cccccc;
	padding: 0;
	margin: 0;
	margin-right: 10px;
}

.alinhamento-div-verificacao {
	margin-top: 10px;
	margin-bottom: 10px;
}

</style>