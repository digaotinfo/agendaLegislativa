<?php
//print_r($schemaTable);
$this->start('script');
	//echo $this->Html->script('ajaxupload.3.5.js');
	/*
?>
	<script>
	$(document).ready(function(){
		$('#formlogin').on('invalid', function () {
				var invalid_fields = $(this).find('[data-invalid]');
				console.log(invalid_fields);
				//alert(invalid_fields);
			})
			.on('valid', function () {
				console.log('valid!');
			});
	});
	</script>
	<?php
*/
$this->end();
?>
		<?=$this->Html->css(array(	'foundation.css',
									'dashboard.css'
									))?>

<?=$this->Html->script(array('vendor/modernizr.js'))?>
	<div class="small-7 large-5 small-centered columns center">
		<div class="small-12 columns">
			<h1>Copa-14</h1>
		</div>
		<div class="small-12 columns">
			 <?php echo $this->Form->create('User', array('data-abide' => '', 'id' => 'formlogin'));?>
				
				<?= $this->Form->input('username' ,  array(
														'label' => 'Login', 
														'placeholder' => 'login' , 
														'div' => true,
														'id' => 'UserLogin',
													)); ?>
													
				<?= $this->Form->input('password' ,  array(
														'type' => 'password',
														'pattern' => '[a-zA-Z]+',
														'label' => 'Senha',
														'placeholder' => 'senha' , 
														'div' => true,
														'id' => 'UserSenha',
													)); ?>
				
			<?=$this->Form->input('Acessar', $options = array(
															'type' => 'submit',
															'label' => false,
															'div' => false, 
															'id' => 'bt_submit',
															'class' => 'radius button right small-12 medium-5',
														));?>
				
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	
	<div class="small-7 small-centered columns center">
		<p></p>
	</div>