<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>ABEAR - Área Restrita</title>

		<!--Import materialize.css-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<?=$this->Html->css(array(
									'materialize.min.css',
									'zoio.css',
									))?>


		<?php echo $this->fetch('css'); ?>
		<script charset="utf-8">
			var webroot = "<?php echo $this->webroot;?>";
		</script>
	</head>
	<body <?php if( ($this->params->controller == 'fluxogramas') && ($this->params->action == 'admin_index') || ($this->params->action == 'admin_fluxoGeralVerGeral') ){echo 'onload="onLoad();"';}?>>

		<!-- Header and Nav -->
		<header>
			<nav class="top-nav yellow accent-4">
				<a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only margin-left-15 padding-right-20">
					<i class="mdi-navigation-menu"></i>
				</a>
				<div class="container">
					<div class="nav-wrapper">
						<div class="col s12 m6 center-align">
							<a class="page-title black-text">Agenda Legislativa</a>

						</div>
					</div>
				</div>
			</nav>

			<?php echo $this->element('admin_menu'); ?>
		</header>



		<!-- End Header and Nav -->








		<!-- CONTENT -->
		<main>
			<?php echo $this->Session->flash(); ?>
			<?php
				$contain = 'container';
				if( $this->name == 'Fluxogramas' ){
					if($this->action == 'admin_index' || $this->action == 'admin_fluxoGeralVerGeral' ){
						$contain = '';
					}
				}
			?>
            <div class="<?php echo $contain; ?>">
				<?php

					echo $this->fetch('content');
				?>
			</div>
		</main>
		<!-- END CONTENT -->




		<!-- Footer -->
		<footer class="page-footer grey lighten-1">
            <div class="container">
                <div class="row">
                    <div class="col s12">

                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container center-align">
                    LICENSE
                </div>
            </div>
        </footer>
		<!-- End Footer -->


		<?php
		echo $this->Html->script('jquery.js');
		echo $this->Html->script('materialize.min.js');
		echo $this->Html->script('jquery.mask.js');
		echo $this->Html->script('zoio.js');
		// echo $this->Html->script('../assets/tinymce/tinymce.min.js');
		// echo $this->Html->script('ajaxupload.3.5.js');
		?>
		<script>
			$(".button-collapse").sideNav();
			if($('select')){
				$('select').material_select();
			}

		</script>


		<?php
		echo $this->fetch('script');
		// echo $this->element('sql_dump');
		?>
		<?php
			// echo $this->Html->script('/assets/js-graph-it/js-graph-it.js');
		?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-38243772-2', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>
