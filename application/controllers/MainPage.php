<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainPage extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array(
			'MyBaccaratPoker'	=> 'Baccarat'
		));
		
	}
	
	public function burnStartCard()
	{
		$body = array(
			'datalist' =>''
		);
		$title = array(
			'response'	=>'开局烧牌'
		);
		$statu_code  = '000';
		$status = array(
			'code'	=>$statu_code,
			'msg'	=>'',
		);
		
		$input_data = json_decode(trim(file_get_contents('php://input'), 'r'), true);
		$post = $input_data;
		$card = &$this->session->userdata('card');
		try 
		{	
			$result = $this->Baccarat->getCard($card);
			$ary = explode('_', $result[0]);
			$body['datalist'] =$ary[1] ;
			$statu_code ="100";
			$status['code'] = $statu_code;
			$status['msg'] = 'OK';
			
		}
		catch(Exception $e)
		{
			$status['code'] = $statu_code ;
			$status['msg'] = $e->getMessage();
		}
		
		$this->myfunc->outputJson($body, $title, $status);
	}
	
	public function shuffle()
	{
		
		$card = &$this->session->userdata('card');
		$card_pool = &$this->session->userdata('card_pool');
		$temp = array_merge($card,$card_pool);
	}
	
	public function index()
	{
		$this->Baccarat->start();
		$this->session->set_userdata('card', $this->Baccarat->card);
		$this->session->set_userdata('card_pool', array());
		$this->smarty->assign(array(
			'end_cards'	=>$this->Baccarat->endCards
		));
		$this->smarty->display('index.tpl');
		$card = &$this->session->userdata('card');
	}
	
	public function cutCard()
	{
		$body = array(
			'datalist' =>''
		);
		$title = array(
			'response'	=>'切牌'
		);
		$statu_code  = '000';
		$status = array(
			'code'	=>$statu_code,
			'msg'	=>'',
		);
		
		$input_data = json_decode(trim(file_get_contents('php://input'), 'r'), true);
		$post = $input_data;
		
		try 
		{	
			// $body['datalist'] = $this->article->getList($parame);
			$statu_code ="100";
			$status['code'] = $statu_code;
			$status['msg'] = 'OK';
			
		}
		catch(Exception $e)
		{
			$status['code'] = $statu_code ;
			$status['msg'] = $e->getMessage();
		}
		
		$this->myfunc->outputJson($body, $title, $status);
	}
	
	
	
	public function run()
	{
		$card = &$this->session->userdata('card');
		
		$body = array(
			'datalist' =>''
		);
		$title = array(
			'response'	=>'遊戲運行'
		);
		$statu_code  = '000';
		$status = array(
			'code'	=>$statu_code,
			'msg'	=>'',
		);
		
		$input_data = json_decode(trim(file_get_contents('php://input'), 'r'), true);
		$post = $input_data;
		
		try 
		{	
			
			$this->Baccarat->licensing($player, $banker, $card);
			$info = $this->Baccarat->run($player, $banker, $card);
			// var_dump($info);
			$body['datalist']['banker']['hand_card'] = $banker ;
			$body['datalist']['banker']['point'] = 	$info['banker_point'];
			$body['datalist']['player']['hand_card'] = $player ;
			$body['datalist']['player']['point'] = $info['player_point']; 
			$body['datalist']['winner'] = $info['winner'] ;
			$body['datalist']['card'] = $card ;
			$this->session->set_userdata('card', $card);
			
			$statu_code ="100";
			$status['code'] = $statu_code;
			$status['msg'] = 'OK';
			
		}
		catch(Exception $e)
		{
			$status['code'] = $statu_code ;
			$status['msg'] = $e->getMessage();
		}
		
		$this->myfunc->outputJson($body, $title, $status);
	}
	
	
}
