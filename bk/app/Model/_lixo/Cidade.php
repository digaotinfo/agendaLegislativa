<?
class Cidade extends AppModel{
	var $useTable = 'tb_cidade';

	public $belongsTo = 'Estado';
}