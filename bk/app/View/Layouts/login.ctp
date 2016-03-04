<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'App TalkingHUB');
?><!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>zAdmin</title>


		<meta name="description" content="Documentation and reference library for ZURB Foundation. JavaScript, CSS, components, grid and more." />

		<!--Import materialize.css-->
        <!-- <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/> -->

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


        <!-- <link rel="stylesheet" href="css/zoio.css" media="screen" charset="utf-8"> -->
		<?php
		echo $this->fetch('meta');



		echo $this->Html->css('materialize.min.css');
		echo $this->Html->css('zoio.css');


		// echo $this->Html->script('../assets/js/vendor/modernizr.js');

		echo $this->fetch('css');
		//echo $this->fetch('script');
		?>

	</head>
	<body>

		<header>

        </header>




		<!-- CONTENT -->
		<main class="login">
            <div class="container">
				<?php
				echo $this->Session->flash();

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
            <div class="footer-copyright login">
                <div class="container center-align">
                    LICENSE
                </div>
            </div>
        </footer>
		<!-- End Footer -->

		<script>
		var webroot = '<?=$this->webroot;?>';
		</script>

		<?php
		echo $this->Html->script('jquery.js');
		echo $this->Html->script('materialize.min.js');
		echo $this->fetch('script');
		?>
		<script>
			// $(document).foundation();
		</script>
		<?php //echo $this->element('sql_dump'); ?>
	</body>
</html>
