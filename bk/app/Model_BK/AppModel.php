<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	//var $actsAs = array('Brownie.Panel');
	public $useDbConfig = 'default';

	public $validationDomain = 'validation';

	function __construct($id = false, $table = null, $ds = null) {
		if ($_SERVER['HTTP_HOST'] == 'server.local' || $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '10.0.1.7' || $_SERVER['HTTP_HOST'] == '10.10.0.220') {
			$this->useDbConfig = 'test';
		}
		parent::__construct($id, $table, $ds);
	}




	public function beforeSave() {
		parent::beforeSave();

		App::import('Controller', 'App');
		$appController = new AppController;

		///===> String To Slug
		/// A variável transformUrl deve ser colocada na Model
		if (!empty($this->transformUrl)) {
			foreach ($this->transformUrl as $key => $value) {
				//echo $key ." => ". $value ."<br>";

				$url_amigavel = $appController->stringToSlug($this->data[$this->alias][$value]);


				$this->data[$this->alias][$key] = $url_amigavel;
			}
		}



		///===> Salvando Imagens, caso existam
		if (!empty($this->type_files)) {
			foreach ($this->type_files as $key => $value) {
				//echo $campo ." => ". $parametros ."<br>";

				if (!empty($this->data[$this->alias][$key.'_nome_imagem'])) {
					$this->data[$this->alias][$key] = $this->data[$this->alias][$key.'_nome_imagem'];
					$this->data[$this->alias][$key.'_th_hidden'] = $appController->thumbPath($this->data[$this->alias][$key.'_nome_imagem']);
				}

			}
		}

		return true;
	}



	public function beforeDelete() {
		parent::beforeDelete();


		///===> Excluindo as Imagens, caso existam
		if (!empty($this->type_files)) {
			$nome_da_model 			= $this->alias;
			$id_que_sera_apagado 	= $this->id;
			$campos_de_input_file 	= array();

			foreach ($this->type_files as $key => $value) {
				array_push($campos_de_input_file, $key);
			}

			$registro = $this->find('first', array(
												'fields' => $campos_de_input_file,
												'conditions' => array(
													'id' => $id_que_sera_apagado
												),
												'recursive' => -1,
											));
			if (!empty($registro)) {

				App::import('Controller', 'App');
				$appController = new AppController;

				$webroot = APP .'webroot'. DS;

				foreach ($campos_de_input_file as $key => $value) {
					if (!empty($registro[$nome_da_model][$value])) {

						if (file_exists($webroot . $registro[$nome_da_model][$value])) {
							unlink($webroot . $registro[$nome_da_model][$value]);

							$thumbnail = $appController->thumbPath($registro[$nome_da_model][$value]);

							if (file_exists($webroot . $thumbnail)) {
								unlink($webroot . $thumbnail);
							}
						}
					}
				}
			}
		}

		/*
		echo "<pre>";
		print_r($registro);
		echo "</pre>";
		die();
		*/
	}
}
