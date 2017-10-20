<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mysmarty
{
    public function __construct()
    {
		require_once(APPPATH."third_party/smarty/libs/Smarty.class.php");
		$this->smarty = new Smarty;
		$this->smarty->caching = false;
		$this->smarty->setTemplateDir(BASEPATH.'../application/views/');
		$this->smarty->setCompileDir(BASEPATH.'../application/views/templates_c');
		$this->smarty->left_delimiter ="<{";
		$this->smarty->right_delimiter = "}>";
		$template_dir = $this->smarty->getTemplateDir();
		return $this->smarty;
    }
	
	public function display($tpl)
	{
		$this->smarty->clearAllCache();
		$this->smarty->display($tpl);
	}
	
	public function displayFrame($tpl)
	{
		$this->assign(array(
			'content_tpl'	=>'front_end/block/'.$tpl
		));
		$this->smarty->display('front_end/frame.tpl');
	}
	
	public function assign($var)
	{
		$this->smarty->assign($var);
	}
	public function fetch($tpl)
	{
		return $this->smarty->fetch($tpl);
	}
}