<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('ConnectionManager', 'Model'); 

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class ConstructController extends AppController {
	var $name = "Construct";
	public $helpers = array('Html', 'Session', 'Form');
	var $scaffold = 'admin';
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(
							'criartabelas'
						);
	}

	function criartabelas($login, $senha) {
		$this->layout = 'ajax';
		$this->autoRender = false;

		if (!empty($login) && !empty($senha)) {
			if ($login != 'zoiodev' || $senha != 'Zoio.2010') {
				echo "Acesso negado";
				die();

				
			} else {

				$SQL = "
					-- DROP TABLE IF EXISTS `roles`;
					/*!40101 SET @saved_cs_client     = @@character_set_client */;
					/*!40101 SET character_set_client = utf8 */;
					CREATE TABLE `roles` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					  `alias` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
					  `created` datetime DEFAULT NULL,
					  `updated` datetime DEFAULT NULL,
					  PRIMARY KEY (`id`),
					  UNIQUE KEY `role_alias` (`alias`)
					) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
					/*!40101 SET character_set_client = @saved_cs_client */;

					--
					-- Dumping data for table `roles`
					--

					LOCK TABLES `roles` WRITE;
					/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
					INSERT INTO `roles` VALUES (1,'Admin','admin','2015-01-16 00:50:35','2015-01-15 00:10:34'),(2,'User','user','2014-09-03 00:00:00','2014-09-03 00:00:00');
					/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
					UNLOCK TABLES;

					--
					-- Table structure for table `tb_categorias`
					--

					-- DROP TABLE IF EXISTS `tb_categorias`;
					/*!40101 SET @saved_cs_client     = @@character_set_client */;
					/*!40101 SET character_set_client = utf8 */;
					CREATE TABLE `tb_categorias` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `nome` varchar(50) NOT NULL,
					  `created` datetime DEFAULT NULL,
					  `modified` datetime DEFAULT NULL,
					  `ativo` tinyint(1) DEFAULT '1',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
					/*!40101 SET character_set_client = @saved_cs_client */;

					--
					-- Dumping data for table `tb_categorias`
					--

					LOCK TABLES `tb_categorias` WRITE;
					/*!40000 ALTER TABLE `tb_categorias` DISABLE KEYS */;
					INSERT INTO `tb_categorias` VALUES (1,'Nome da cartegoria','2014-11-04 19:58:53','2014-11-04 19:58:53',1),(2,'Outra categoria','2014-11-04 19:59:02','2014-11-04 19:59:02',1);
					/*!40000 ALTER TABLE `tb_categorias` ENABLE KEYS */;
					UNLOCK TABLES;

					--
					-- Table structure for table `tb_configuracao`
					--

					-- DROP TABLE IF EXISTS `tb_configuracao`;
					/*!40101 SET @saved_cs_client     = @@character_set_client */;
					/*!40101 SET character_set_client = utf8 */;
					CREATE TABLE `tb_configuracao` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `tag_title` varchar(300) DEFAULT NULL,
					  `tag_keywords` varchar(400) DEFAULT NULL,
					  `tag_description` varchar(300) DEFAULT NULL,
					  `google_analytics` varchar(200) DEFAULT NULL,
					  `facebook_logo` varchar(300) DEFAULT NULL,
					  `facebook_logo_th_hidden` varchar(300) DEFAULT NULL,
					  `email_destinatario` varchar(300) DEFAULT NULL,
					  `email_remetente_host` varchar(300) DEFAULT NULL,
					  `email_remetente` varchar(300) DEFAULT NULL,
					  `email_remetente_senha` varchar(300) DEFAULT NULL,
					  `email_cc` varchar(300) DEFAULT NULL,
					  `url_facebook` varchar(300) DEFAULT NULL,
					  `url_instagram` varchar(300) DEFAULT NULL,
					  `url_twitter` varchar(300) DEFAULT NULL,
					  `telefone` varchar(45) DEFAULT NULL,
					  `email_contato` varchar(100) DEFAULT NULL,
					  `endereco_linha_1` varchar(300) DEFAULT NULL,
					  `endereco_linha_2` varchar(300) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
					/*!40101 SET character_set_client = @saved_cs_client */;

					--
					-- Dumping data for table `tb_configuracao`
					--

					LOCK TABLES `tb_configuracao` WRITE;
					/*!40000 ALTER TABLE `tb_configuracao` DISABLE KEYS */;
					INSERT INTO `tb_configuracao` VALUES (1,'','','',NULL,'uploads/400x400gif','uploads/thumbs/th_400x400.gif','digaot.info@gmail.com','smtp.site1389181442.hospedagemdesites.ws','nao-responda@site1389181442.hospedagemdesites.ws','zPass*32','digaot.info@gmail.com','','','','','','','');
					/*!40000 ALTER TABLE `tb_configuracao` ENABLE KEYS */;
					UNLOCK TABLES;

					--
					-- Table structure for table `tb_noticias`
					--

					-- DROP TABLE IF EXISTS `tb_noticias`;
					/*!40101 SET @saved_cs_client     = @@character_set_client */;
					/*!40101 SET character_set_client = utf8 */;
					CREATE TABLE `tb_noticias` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `categoria_id` int(11) DEFAULT NULL,
					  `titulo` varchar(100) DEFAULT NULL,
					  `url_amigavel` varchar(100) DEFAULT NULL,
					  `chamada` varchar(150) DEFAULT NULL,
					  `texto` text,
					  `imagem` varchar(300) DEFAULT NULL,
					  `ativo` tinyint(1) NOT NULL DEFAULT '1',
					  `created` datetime DEFAULT NULL,
					  `modified` datetime DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
					/*!40101 SET character_set_client = @saved_cs_client */;

					--
					-- Dumping data for table `tb_noticias`
					--

					LOCK TABLES `tb_noticias` WRITE;
					/*!40000 ALTER TABLE `tb_noticias` DISABLE KEYS */;
					/*!40000 ALTER TABLE `tb_noticias` ENABLE KEYS */;
					UNLOCK TABLES;

					--
					-- Table structure for table `usuarios`
					--

					-- DROP TABLE IF EXISTS `usuarios`;
					/*!40101 SET @saved_cs_client     = @@character_set_client */;
					/*!40101 SET character_set_client = utf8 */;
					CREATE TABLE `usuarios` (
					  `id` int(20) NOT NULL AUTO_INCREMENT,
					  `role_id` int(11) NOT NULL DEFAULT '0',
					  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					  `website` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
					  `activation_key` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
					  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
					  `bio` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
					  `timezone` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
					  `status` tinyint(1) NOT NULL DEFAULT '0',
					  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
					/*!40101 SET character_set_client = @saved_cs_client */;

					--
					-- Dumping data for table `usuarios`
					--

					LOCK TABLES `usuarios` WRITE;
					/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
					INSERT INTO `usuarios` VALUES (1,1,'zoio','c4157d5858ce997451d6e71b86e3b0ca2d2cb2b6','Zoio','zoiodev@zoio.net.br',NULL,'',NULL,NULL,'0',0,'2015-01-16 00:40:15','2015-01-16 00:41:52');
					/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
					UNLOCK TABLES;
					/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

					/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
					/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
					/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
					/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
					/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
					/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
					/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

				";


				$db = ConnectionManager::getDataSource('test');
				if (!$db->isConnected()) {
					$this->Session->setFlash(__('Could not connect to database.'), 'default', array('class' => 'error'));
				} else {
					$db->query($SQL);
					echo 'Concluido';
				}
			}
		}

	}

}

