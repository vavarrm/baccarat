<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
		
	public function index()
	{
		$this->smarty->display(__CLASS__.'/'.__FUNCTION__.'.tpl');
	}
}
?>