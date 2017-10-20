<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once(APPPATH."libraries/MyPoker.php");
	class MyBaccaratPoker extends MyPoker 
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->ci =&get_instance();
			$this->initCard(8);
			$this->basicShuffle();
			$this->basicShuffle();
			$this->basicShuffle();
			$this->endCards= rand(0.75*count($this->card), 0.80*count($this->card));
			$this->cardsPool = array();
			
		}
		
		
		public function burncard(&$card ,$num=1)
		{
			for($i=0 ; $i<=$num; $i++)
			{
				$this->shiftCards($ary, $card) ;
			}
		}
		
		public function start()
		{
			
		}
		
		public function getCard(&$card)
		{
			$tmpcard = array();
			$this->shiftCards($tmpcard, $card) ;
			return $tmpcard;
		}
		
		public function run(&$player, &$banker, &$card)
		{
			$banker_point = $this->getPoint($banker);		
			$player_point = $this->getPoint($player);
			
			if($player_point <=7 && $banker_point <=7)
			{
				if($player_point <=5)
				{
					$this->shiftCards($player, $card) ;
					$player_point = $this->getPoint($player);
					$player_third_card_point = $player_point ;
				}
				
				if($banker_point <=2)
				{
					$this->shiftCards($banker, $card) ;
					$banker_point = $this->getPoint($banker);
				}elseif($banker_point <=6)
				{
					if($banker_point == 3 && $player_third_card_point != 8)
					{
						$this->shiftCards($banker, $card) ;
						$banker_point = $this->getPoint($banker);
					}elseif(
						$banker_point == 4 && 
						$player_third_card_point >= 2 &&
						$player_third_card_point <=7
					)
					{
						$this->shiftCards($banker, $card) ;
						$banker_point = $this->getPoint($banker);
					}elseif(
						$banker_point == 5 &&
						$player_third_card_point >= 4 &&
						$player_third_card_point <=7 
					){
						$this->shiftCards($banker, $card) ;
						$banker_point = $this->getPoint($banker);
					}elseif(
						$banker_point == 6 &&
						$player_third_card_point >= 6 &&
						$player_third_card_point <=7 
					){
						$this->shiftCards($banker, $card) ;
						$banker_point = $this->getPoint($banker);
					}
				}
			}
			$winner ="";
			if($banker_point > $player_point)
			{
				$winner="banker";
			}elseif($banker_point < $player_point){
				$winner="player";
			}else{
				$winner ="tie";
			}
			
			$info = array(
				'winner' =>$winner,
				'banker_point' =>$banker_point,
				'player_point' =>$player_point,
			);
			
			return $info;
		}
		
		public function licensing(&$player, &$banker, &$card)
		{
			$this->shiftCards($player, $card) ;
			$this->shiftCards($banker, $card) ;
			$this->shiftCards($player, $card) ;
			$this->shiftCards($banker, $card) ;
		}
		
		public function shiftCards(&$hand_card , &$card)
		{
			$cardtemp = array_shift($card) ;
			$hand_card[] =$cardtemp;
			$this->cardsPool = &$this->ci->session->userdata('card_pool');
			array_push($this->cardsPool, $cardtemp );
			$this->ci->session->set_userdata('card_pool', $this->cardsPool);
		}
		
		
		public function getPoint($card)
		{
			if(!empty($card))
			{
				foreach($card as $value)
				{
					$ary = explode("_", $value);
					if($ary[1] >10)
					{
						$number = 10;
					}else
					{
						$number = intval($ary[1]);
					}
					
					$total+=$number;
				}
				return $total%10;
			}
		}
	}
?>