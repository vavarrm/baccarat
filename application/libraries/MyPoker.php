<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class MyPoker
	{
		
		public function __construct()
		{

			$this->card = array();
			$this->cardNums = 1;
			$this->suit = array(
				's',
				'h',
				'c',
				'd',
			);

			$this->cardAry =array(
				'1'		=>'A',
				'2'		=>'2',
				'3'		=>'3',
				'4'		=>'4',
				'5'		=>'5',
				'6'		=>'6',
				'7'		=>'7',
				'8'		=>'8',
				'9'		=>'9',
				'10'	=>'T',
				'11'	=>'J',
				'12'	=>'Q',
				'13'	=>'K',
			);
			
			$this->addPointAry =array(
				'1'		=>'14',
				'2'		=>'2',
				'3'		=>'3',
				'4'		=>'4',
				'5'		=>'5',
				'6'		=>'6',
				'7'		=>'7',
				'8'		=>'8',
				'9'		=>'9',
				'10'	=>'10',
				'11'	=>'11',
				'12'	=>'12',
				'13'	=>'13',
			);
			
		}
		
		
		
		/*洗牌
		1 =>對插法
		*/
		public function basicShuffle($type = 1)
		{
			$func_ary = array(
				'1' =>'insertEachOtherCard'
			);
			if(!empty($func_ary[$type]) && method_exists($this, $func_ary[$type]))
			{
				$this->$func_ary[$type]();
			}
		}
		
		private function insertEachOtherCard()
		{
			srand((double)microtime()*1000000); 
			rand();
			$card_nums = count($this->card);
			for($i=0;$i<$card_nums ;$i++)
			{
				
				$a = rand(0,$card_nums-1);
				$temp =$this->card[$i];
				$this->card[$i] = $this->card[$a];
				$this->card[$a]= $temp;
			}
		}
		
		
		//牌初始化
		public function  initCard($num = 1)
		{
			$this->card = array();
			for ($i=0 ;$i<$num ;$i++)
			{
				$k = 0;
				for($j=1;$j<=52;$j++)
				{
					$number =  $j-13*$k;
					$suit = $this->suit[$k];
					$this->card[] = $suit.'_'.$number ;
					if($j%13==0)
					{
						$k++;
					}
				}
			}
		}
	}
?>