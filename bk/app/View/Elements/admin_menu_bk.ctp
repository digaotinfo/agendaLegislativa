<?php
	//print_r($this->params);
	//print_r($this->Session);
	// print_r($this->name);

if ($this->Session->read('Auth.User')):

	//echo '['. $userAdmin .']';
	if ($userAdmin < 4):
	//if ($userAdmin == 1):
		?>

		<nav class="top-bar" data-topbar role="navigation">
			<ul class="title-area">
				<li class="name">
					<h1>
						<a href="<?=$this->Html->url(array('controller' => 'index', 'action' => 'index'))?>">
							<?=$this->Html->image('header_logo-abear.png', array('alt' => 'Zóio'));?>
						</a>
					</h1>
				</li>
			<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
				<li class="toggle-topbar menu-icon">
					<a href="#">
						<span></span>
					</a>
				</li>
			</ul>

			<section class="top-bar-section">
				<!-- Right Nav Section -->
				<ul class="right menu-site">
					<li class="<?php if($this->name == 'Index'){ echo 'active';}?>">
						<a href="<?=$this->Html->url(array(
														'controller' => 'index',
														'action' => 'index',
														'admin' => true
													));?>" class="radius button secondary">Home</a>
					</li>
					<li class="<?php if($this->name == 'Arquivos') echo 'active'?>">
						<a href="<?=$this->Html->url(array(
														'controller' => 'arquivos',
														'action' => 'index',
														'admin' => true
													));?>" class="radius button secondary">Outros Arquivos</a>
					</li>
					<li class="has-dropdown maind-menu <?php if($this->name == 'User'){ echo 'active';}?>" data-same-width>
						<a href="#" class="radius button secondary">
							Adminstrativo
						</a>
						<ul class="dropdown" data-same-width-watch>
							<li><?=$this->Html->link('Meus Dados', array('controller' => 'user', 'action' => 'edit', $current_user['id']), array('class' => 'radius button secondary'))?></li>
							<li><?=$this->Html->link('Usuários', array('controller' => 'user', 'action' => 'index'), array('class' => 'radius button secondary'))?></li>
						</ul>
					</li>
					<li><?=$this->Html->link('Sair', array('controller' => 'user', 'action' => 'logout'), array('class' => 'radius button secondary'))?></li>
					<!-- <li class="has-dropdown">
						<a href="#">
							Right Button Dropdown
						</a>
						<ul class="dropdown">
							<li>
								<a href="#">
									First link in dropdown
								</a>
							</li>
							<li class="active">
								<a href="#">
									Active link in dropdown
								</a>
							</li>
						</ul>
					</li> -->
				</ul>


			</section>
		</nav>

		<!-- <div class="medium-6 columns menu-lateral menu right"> -->
			<!-- <nav>
				<ul>
					<li>
						<a href="<?=$this->Html->url(array(
														'controller' => 'index',
														'action' => 'index',
														'admin' => true
													));?>" class="radius button secondary <?php if($this->name == 'Index') echo 'active'?>">Home</a>
					</li>
					<li>
						<a href="<?=$this->Html->url(array(
														'controller' => 'index',
														'action' => 'index',
														'admin' => true
													));?>" class="radius button secondary <?php if($this->name == 'Index') echo 'active'?>">Outros Arquivos</a>
					</li>
					<li>
						<a href="<?=$this->Html->url(array(
														'controller' => 'index',
														'action' => 'index',
														'admin' => true
													));?>" class="radius button secondary <?php if($this->name == 'Index') echo 'active'?>">Administrativo</a>
					</li>
				</ul>

			</nav> -->



		<!-- </div> -->
		<?php
	endif;
endif;
