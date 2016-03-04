<?php
	//$cakeDescription = __d('cake_dev', 'Ambev App');
// print_r();
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Dashboard COPA 14</title>

		<?=$this->Html->css(array(	'foundation.css',
									'dashboard.css'
									))?>

		<?=$this->Html->script(array('vendor/modernizr.js'))?>


		<script>
			var webroot = '<?=$this->webroot;?>';
		</script>

	</head>
	<body>


		<!-- Header and Nav -->
		<div class="row talkinghub-header">
			<!-- LOGO -->
			<div class="medium-3 small-5 columns">
				<h1>
				<?=$this->Html->image('zoio.png')?></h1>
			</div>
			<!-- END LOGO -->
		</div>
		<!-- End Header and Nav -->





		<!-- Sub Header -->
		<div class="row talkinghub-sub-header">
			<div class="row sub-header-content">
				<div class="small-12 columns">
					<!-- <div class="row espaco-topo"></div> -->

					<div class="row">
						<!-- Logo do aplicativo -->
						<div class="medium-3 small-6 columns" onClick="_gaq.push(['_trackEvent', 'Logo', 'Click', 'Teste de click']);">
							<?=$this->Html->image('logo.png')?>
						</div>
						<!-- End Logo do Aplicativo -->

						<div class="small-12 show-for-small-only centered columns">
							<!-- http://dashboardcopa14.com.br/ -->
							<a href="itms-services://?action=download-manifest&url=https://dl.dropboxusercontent.com/sh/m45e3xb5q3mwbi5/AABh0sULlEQ6CSm8rrJvXbjza/Copa14.plist" class="radius button expand" onClick="_gaq.push(['_trackEvent', 'Download Update', 'IOS', '']);" style='margin-right:40px;'>Download IOS Homologação</a>
							
							<a href="<?=$this->webroot.'aplicativo/copa14.apk'?>" class="radius button expand btdownloadApp" onClick="_gaq.push(['_trackEvent', 'Download Update', 'Android', '']);" style='margin-right:40px;' id="bt_download_1">Download ANDROID Homologação</a>
						</div>


						<!-- Ações do aplicativo -->
						<div class="medium-5 small-4 hide-for-small columns">
							<div class="row">
								<div class="large-10 medium-12 columns controles">
									<div class="row">
										Aplicativo
									</div>
									<div class="row divisoria-top-bottom">
										<h2>Admin - Zoio</h2>
									</div>
									<!--
									<div class="row">
										<div class="small-12">
											<ul class="button-group hide">
												<li>
													<a href="#" class="radius button third tiny">DDD</a>
												</li>
											</ul>
										</div>
									</div>
									-->


								</div>
							</div>
						</div>
						<!-- End Ações do aplicativo -->

						<!-- Botão criar novo aplicativo -->
						<div class="medium-3 small-12 hide-for-small columns bt-criar">
							<!-- http://dashboardcopa14.com.br/ -->
							<a href="itms-services://?action=download-manifest&url=https://dl.dropboxusercontent.com/sh/m45e3xb5q3mwbi5/AABh0sULlEQ6CSm8rrJvXbjza/Copa14.plist" class="radius button expand" onClick="_gaq.push(['_trackEvent', 'Download Update', 'IOS', '']);" style='margin-right:40px;'>Download IOS Homologação</a>
							
							<a href="<?=$this->webroot.'aplicativo/copa14.apk'?>" class="radius button expand btdownloadApp" onClick="_gaq.push(['_trackEvent', 'Download Update', 'Android', '']);" style='margin-right:40px;' id="bt_download_1">Download ANDROID Homologação</a>
						</div>
						<!-- End Botão criar novo aplicativo -->

						


					</div>

					<!-- Seta para Logo -->
					<div class="row hide-for-small">
						<div class="medium-3 small-4 columns seta-logo-app">
							&nbsp;
						</div>
					</div>
					<!-- End Seta para Logo -->
				</div>
			</div>
		</div>
		<!-- End Sub Header -->

		<div class="row">
			<div class="small-12 columns">&nbsp;</div>
		</div>


		

		<!-- Footer -->
		<div class="row talkinghub-footer">
			<footer>

			</footer>
		</div>
		<!-- End Footer -->

		<?=$this->Html->script(array(	'vendor/jquery.js',
										'vendor/jquery-ui_min.js',
										'foundation.min.js',
										'tinymce/jquery.tinymce.min.js',
										'tinymce/tinymce.min.js',
										'Greensock/TweenMax.js',
										// 'jquery.scrollbox.js',
										'geral.js',
										'default.js'
										))?>

		<script>
			$(document).foundation();
			tinymce.init({
			    selector: "textarea",
			    init_instance_callback : callOnTinyMCE,
    			plugins: "link",
    			language: "pt_BR"
			 });
		</script>
		<script>
			/*
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', 'UA-51528648-1', 'dashboardcopa14.com.br');
			ga('send', 'pageview');
			*/
			
			
			
			 var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-51528648-1']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
			
		</script>
		<?php
		echo $this->fetch('script');
		?>
	</body>
</html>
