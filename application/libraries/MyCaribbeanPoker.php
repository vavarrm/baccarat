<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once(APPPATH."libraries/MyPoker.php");
	require_once(APPPATH."libraries/poker_Interface/CaribbeanPokerInterface.php");
	class MyCaribbeanPoker extends MyPoker implements CaribbeanPokerInterface
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->zeor_number =1000000000;
			$this->version =1;
			// $CI =& get_instance();
			// $CI->load->model('caribbeanPoker_Model');
			// $this->ProbabilityTable = $CI->caribbeanPoker_Model->getProbabilityTable();
		}
		
		public function start($type=1)
		{
			$this->initCard($this->cardNums);
			
			// echo $type;
			switch($type)
			{
				case 1:
				$player_card = $this->getRandStyle();
				$banker_card = $this->getRandStyle();
				$output['player'] =$this->makeCard($player_card);
				$output['banker'] = $this->makeCard($banker_card);
				break;
				case 2:
					$this->basicShuffle();
					$output['player']  = $this->makeAKcard();
					for($i=0;$i<5;$i++)
					{
						$output['banker'][] = array_shift($this->card);
					}
				break;
			}
			
					
			return $output;
		}
		
		public function makeAKcard()
		{
			$output = array();
			$suit_index = array_rand($this->suit, 1);
			$suit = $this->suit[$suit_index];
			$card =$suit.'_1';
			$output[] =$card;
			$del_index = array_keys($this->card,  $card);
			unset($this->card[$del_index[0]]);
			
			$suit_index = array_rand($this->suit, 1);
			$suit = $this->suit[$suit_index];
			$card =$suit.'_13';
			$output[] =$card;
			$del_index = array_keys($this->card,  $card);
			unset($this->card[$del_index[0]]);

			
			$output[] = array_shift($this->card);
			$output[] = array_shift($this->card);
			$output[] = array_shift($this->card);
				
			return $output;
			// echo $suit;
		}
		
		public function makeCard($style)
		{
			
			switch($style)
			{
				case 'hc':
					while($stop == false)
					{	
						$output = array();
						$rand_keys = array_rand($this->card, 5);
						for($i=0 ;$i<=4 ;$i++)
						{
							$output[$rand_keys[$i]] =$this->card[$rand_keys[$i]];
							unset($this->card[$rand_keys[$i]]);
						}
						if(count($output) == 5 )
						{	
							$card_info = $this->getCardPoint($output);
							if($card_info['type'] =="High card")
							{
								$stop = true;
							}else{
								foreach($output as $key =>$value)
								{
									$this->card[$key] = $value;
								}
							}
						}
					}
				break;
				case 'op':
					while($stop == false)
					{	
						$output = array();
						$rand_keys = array_rand($this->card, 5);
						for($i=0 ;$i<=4 ;$i++)
						{
							$output[$rand_keys[$i]] =$this->card[$rand_keys[$i]];
							unset($this->card[$rand_keys[$i]]);
						}
						if(count($output) == 5 )
						{	
							$card_info = $this->getCardPoint($output);
						
							if($card_info['type'] =="Pairs")
							{
								
								$stop = true;
							}else{
								foreach($output as $key =>$value)
								{
				
									$this->card[$key] = $value;
								}
								$output = array();
							}
						}
					}
				break;
				case 'tp':
					$output = array();
					$addPointAry =$this->addPointAry;
					$two_pairs_value = array_rand($addPointAry , 2);
					$temp_value  = array();
					foreach($two_pairs_value as $key => $value)
					{	
						$temp_pool = array();
						$temp  = $this->suit;
						$rand_color_index1 = array_rand($temp  , 1);
						$color1 =  $this->suit[$rand_color_index1];
						unset($temp[$rand_color_index1]);
						
						$rand_color_index2 = array_rand($temp  , 1);
						$color2 =  $this->suit[$rand_color_index2];
						unset($temp[$rand_color_index2]);
						
						$temp_pool[] =$color1.'_'.$value;
						$temp_pool[] =$color2.'_'.$value;
						
						$unset1 = array_keys($this->card, $temp_pool[0]);
						$unset2 = array_keys($this->card, $temp_pool[1]);
						unset($this->card[$unset1[0]]);
						unset($this->card[$unset2[0]]);
						
						$output[] =$temp_pool[0];
						$output[] =$temp_pool[1];
						unset($addPointAry[$value]);
					}

			
					$two_pairs_tickt = array_rand($addPointAry  , 1);
					$two_pairs_tickt_color_index = array_rand($this->suit  , 1);
					$two_pairs_tickt_color =  $this->suit[$two_pairs_tickt_color_index];
					$output[] = $two_pairs_tickt_color.'_'.$two_pairs_tickt;
					$unset_index = array_keys($this->card, $two_pairs_tickt_color.'_'.$two_pairs_tickt);
					unset($this->card[$unset_index[0]]);
					// echo 
				break;
				case 'tk':
					$output = array();
					$addPointAry =$this->addPointAry;
					$suit = $this->suit;
					$three_set_value = array_rand($addPointAry , 1);
					unset($addPointAry[$three_set_value]);
					$rand_three_color = array_rand($suit  , 3);
					foreach($rand_three_color as $value)
					{
						
						$card =$this->suit[$value].'_'.$three_set_value;
					
						$output[]=$card;
						$unset_index = array_keys($this->card, $card);
						unset($this->card[$unset_index[0]]);
					}
					
					$kick_ary  = array_rand($addPointAry , 2);
					foreach($kick_ary  as $value)
					{
						$rand_three_kick_color = array_rand($suit  , 1);
						$card =$this->suit[$rand_three_kick_color].'_'.$value;
						$output[]=$card;
						$unset_index = array_keys($this->card, $card);
						unset($this->card[$unset_index[0]]);
					}
				break;
				case 'st':
					$output = array();
					$suit =array();
					$suit = array_merge($suit, $this->suit);
					$suit = array_merge($suit, $this->suit);
					$suit = array_merge($suit, $this->suit);
					$suit = array_merge($suit, $this->suit);
					$straight_color_ary = array_rand($suit , 5);
					$mid = rand(1,13);
					$mid = rand(1,13);

					$mid_start = $mid ;
			
					if($mid_start== 1)
					{
						$updown = rand(1,2);
					}elseif ( $mid_start >1 && $mid_start <5){
						$updown  =1;
					}elseif ( $mid_start >=5 && $mid_start<=10){
						$updown = rand(1,2);
					}else{
						$updown  =2;
					}
						
				
					foreach( $straight_color_ary as $value)
					{
						$color = $suit[$value];
	
						if($updown == 1)
						{
							if($mid >13)
							{
								$card_value = 1;
							}else{
								$card_value = $mid;
							}
							
							$mid++;
						}else
						{
							if($mid <=0)
							{
								$card_value = 13 +$mid;
							}else
							{
								$card_value = $mid;
							}
							$mid--;
						}
						
						$card = $color."_".$card_value;
						$output[] =$card;
						$unset_index = array_keys($this->card, $card);
						unset($this->card[$unset_index[0]]);
					}
				break;
				case 'fl':
					$output = array();
					$suit = $this->suit;
					$straight_color_key = array_rand($suit , 1);
					$color = $suit[$straight_color_key];
					
					while($stop == false)
					{	
						$output = array();
						$rand_keys = array_rand($this->card, 5);
						for($i=0 ;$i<=4 ;$i++)
						{
							$output[$rand_keys[$i]] =$this->card[$rand_keys[$i]];
							
						}
						if(count($output) == 5 )
						{	
							$card_info = $this->getCardPoint($output);
							if($card_info['type'] =="High card")
							{
								$stop = true;
								$temp = array();
								foreach($output as $key =>$value)
								{
									$explode = explode('_',$value);
									// echo $explode[1];
									$card =$color.'_'.$explode[1];
									// echo $card ;
									$temp[] = $card ;
									$unset_index = array_keys($this->card, $card);
									unset($this->card[$unset_index[0]]);
								}
								$output = $temp;
							}else{
								foreach($output as $key =>$value)
								{
									// echo $value;
									$this->card[$key] = $value;
								
								}
								$output =array();
							}
						}
					}
				break;
				case 'fh':
					$output = array();
					$addPointAry =$this->addPointAry;
					$fullhouse_three_value = array_rand($addPointAry , 1);
					unset($addPointAry[$fullhouse_three_value]);
					$temp_value  = array();
					$suit  = $this->suit;
					$rand_color_ary = array_rand($suit  , 3);
					// var_dump($rand_color_ary);
					
					$temp_pool = array();
						
					$color1 =  $this->suit[$rand_color_ary[0]];
					$color2 =  $this->suit[$rand_color_ary[1]];
					$color3 =  $this->suit[$rand_color_ary[2]];
					
					// echo $color1;
					// echo $color2;
					// echo $color3;
					
					$temp_pool[] =$color1.'_'.$fullhouse_three_value;
					$temp_pool[] =$color2.'_'.$fullhouse_three_value;
					$temp_pool[] =$color3.'_'.$fullhouse_three_value;
					
					$unset1 = array_keys($this->card, $temp_pool[0]);
					$unset2 = array_keys($this->card, $temp_pool[1]);
					$unset3 = array_keys($this->card, $temp_pool[2]);
					unset($this->card[$unset1[0]]);
					unset($this->card[$unset2[0]]);
					unset($this->card[$unset3[0]]);
					
					$output[] =$temp_pool[0];
					$output[] =$temp_pool[1];
					$output[] =$temp_pool[2];
						
				
					
			
					$fullhouse_pairs = array_rand($addPointAry  , 1);
					$fullhouse_pairs_color = array_rand($this->suit  , 2);
					
					$card4 = $suit[$fullhouse_pairs_color[0]].'_'.$fullhouse_pairs;
					$card5 = $suit[$fullhouse_pairs_color[1]].'_'.$fullhouse_pairs;
					$output[]=$card4;
					$output[]=$card5;
					$unset_index = array_keys($this->card, $card4);
					unset($this->card[$unset_index[0]]);
					
					$unset_index = array_keys($this->card, $card4);
					unset($this->card[$unset_index[0]]);
				break;
				case 'fk':
					$output = array();
					$addPointAry =$this->addPointAry;
					$four_king_value = array_rand($addPointAry , 1);
					unset($addPointAry[$four_king_value]);
					$suit  = $this->suit;
				
					shuffle($suit );
					// var_dump($suit);
					foreach($suit as $value)
					{
						$card = $value.'_'.$four_king_value;
						$output[]=$card;
						$unset_index = array_keys($this->card, $card);
						unset($this->card[$unset_index[0]]);
					}
					
					$four_king_kick_index = array_rand($this->card , 1);
					$card = $this->card [$four_king_kick_index ];
					$output[]=$card;
					
				break;
				case 'sf':
					$output = array();
					$suit =$this->suit;
					$straight_color_key = array_rand($suit , 1);
					$color = $suit[$straight_color_key];

					$mid = rand(1,13);

					$mid_start = $mid ;
			
					if($mid_start== 1)
					{
						$updown = rand(1,2);
					}elseif ( $mid_start >1 && $mid_start <5){
						$updown  =1;
					}elseif ( $mid_start >=5 && $mid_start<=10){
						$updown = rand(1,2);
					}else{
						$updown  =2;
					}
						
				
					for( $i =0 ;$i<=4 ; $i++)
					{

	
						if($updown == 1)
						{
							if($mid >13)
							{
								$card_value = 1;
							}else{
								$card_value = $mid;
							}
							
							$mid++;
						}else
						{
							if($mid <=0)
							{
								$card_value = 13 +$mid;
							}else
							{
								$card_value = $mid;
							}
							$mid--;
						}
						
						$card = $color."_".$card_value;
						$output[] =$card;
						$unset_index = array_keys($this->card, $card);
						unset($this->card[$unset_index[0]]);
					}
					// var_dump($output);
				break;
			}
			$temp = $output;
			$output =array();
			foreach($temp as $value)
			{
				$output[] = $value;
			}
			return $output;
		}
		
		public function getRandStyle()
		{
			$CI =& get_instance();
			$CI->load->model('caribbeanPoker_Model');
			$row = $CI->caribbeanPoker_Model->getRandStyle();
			$card_style = $row['card_style'];
			return $card_style;
		}
		
		public function getOdds($point)
		{
			$odds = 1;
			if($point >= 9*$this->zeor_number)
			{
				$odds  =100;//皇家同花順
			}elseif($point>=8*$this->zeor_number && $point<9*$this->zeor_number){
				$odds  =50;//同花順
			}elseif($point>=7*$this->zeor_number && $point<8*$this->zeor_number){
				$odds  =20;//四條
			}elseif($point>=6*$this->zeor_number && $point<7*$this->zeor_number){
				$odds  =7;//葫蘆
			}elseif($point>=5*$this->zeor_number && $point<6*$this->zeor_number){
				$odds  =5;//同花
			}elseif($point>=4*$this->zeor_number && $point<5*$this->zeor_number){
				$odds  =4;//順子
			}elseif($point>=3*$this->zeor_number && $point<4*$this->zeor_number){
				$odds  =3;//三條
			}elseif($point>=2*$this->zeor_number&& $point<3*$this->zeor_number){
				$odds  =2;//兩對
			}
			
			return $odds ;
			
		}
		
		public function getCardPoint($ary)
		{
			$flush = false;
			$straight =false; 
			$point = 0;
			$pokerOutput='';
			$AK=0;
			// $m
			
			$cardAry = $this->cardAry;
			
			$addPointAry = $this->addPointAry;
			
			if(count($ary) != 5)
			{
				return false ;
			}
			
			$number = array();
			$pair_ary = array();
			foreach($ary as $value)
			{
				$temp = explode('_', $value);
				$number[] = $temp[1];
				$color[$temp[0]] = $color[$temp[0]]+1;
				$pair_ary[$temp[1]] = $pair_ary[$temp[1]]+1;
			}
			$number_max =max($number);
			$number_min =min($number);
			//判斷是否為同花
			if(count($color) == 1)
			{
				$flush = true;
			}
		
			//判斷是否為順子
			$straightStr ="A23456789TJQKATJQK";
			$straightTemp = '';
			sort($number);
			// var_dump($number);
			foreach($number as $value)
			{
				$straightTemp.= $cardAry[$value];
			}
			
			// echo $straightTemp ;
			// echo "<br>";
			
			if (strstr($straightStr,$straightTemp)) 
			{
			  	$straight = true;
			} 
			 
			//判斷是否同花順，同花打不打的過葫蘆house
			if($flush ==true && $straight ==true)
			{
				
				$point = 8*$this->zeor_number;
				// echo $straightTemp;
				// echo "<br>";
				if($straightTemp=="ATJQK")
				{
					// echo "D";
					$type ="Royal Straight Flush";
					$pokerOutput ='Royal Straight Flush';					
					$point +=$this->zeor_number;
				}else{
					$flush_straight_max =$number_max;
					$point+=$flush_straight_max;
					$type ="Straight Flush"; 
					$pokerOutput ='Straight Flush';
				}
				$output['point'] = $point;
				$output['type'] = $type;
				$output['pokerOutput'] = 	$pokerOutput;
				return $output;
			}
			
			//判斷是否為鐵支
			$same_count = max($pair_ary);
			$same_max = array_keys($pair_ary, max($pair_ary));
			if( $same_count  == 4)
			{
				$point = 7*$this->zeor_number;
				$add = $addPointAry[$same_max[0]];
				$point+=$add;
				$four_of = $cardAry[$same_max[0]];
				$pokerOutput ='Four of a Kind of '.$four_of;
				$output['point'] = $point;
				$output['pokerOutput'] = 	$pokerOutput;
				$output['type'] = 'Four of a Kind';
				// var_dump($output);
				return $output;
			}
			
			//判斷葫蘆
			if( $same_count  == 3 && count($pair_ary) == 2)
			{
				$point = 6*$this->zeor_number;
				$add = $addPointAry[$same_max[0]];
				$point+=$add;
				$full_house_pair_point = array_keys($pair_ary, '2');
				$point+=$full_house_pair_point[0];
				$full_house_set = $cardAry[$same_max[0]];
				$full_house_pair = $cardAry[$full_house_pair_point[0]];
				$output['point'] = $point;
				$output['pokerOutput'] = 	$full_house_set.'-'.$full_house_pair.' Full house';
				$output['type'] = 'Full house';
				return $output;
			}
			
			//同花
			if($flush ==true)
			{
				$point = 5*$this->zeor_number;
				
				
				if($number[0] =='1')
				{
					array_shift($number);
					rsort($number);
					array_unshift($number, '1');
				}else{
					rsort($number);
				}
				
				// var_dump($number);
				$odds =1000000000;
				foreach($number as $key =>$value)
				{
					
					
					// echo $key;
					if($key ==4)
					{
						$odds*=0.1;
					}else
					{
					$odds*=0.01;
					}
					$add = $addPointAry[$value]*$odds;
					$point+=$add;
					
				}
				
				$output['point'] = $point;
				$output['pokerOutput'] = $flush_max.' flush';
				$output['type'] = 'Flush';
				return $output;
			}
			
			
			//順子
			if($straight ==true)
			{
				$point = 4*$this->zeor_number;
				
				if($straightTemp=="ATJQK")
				{
					$add =14;
					$straigh_max_min ='A-T';
				}else{
					$add = $addPointAry[$number_max];
					$straigh_max_min =$cardAry[$number_max].'-'.$cardAry[$number_min];
				}
				$point+=$add;
				$output['point'] = $point;
				$output['pokerOutput'] = $straigh_max_min.' straight';
				$output['type'] = 'straight';
				return $output;
			}
			
			//三條
			if( $same_count  == 3)
			{
				$point = 3*$this->zeor_number;
				$add = $addPointAry[$same_max[0]];
				$output['point'] = $point+$add;
				$set = $cardAry[$same_max[0]];
				$output['pokerOutput'] = $set.' set';
				$output['type'] = 'set';
				return $output;	
			}

			//兩對
			if( $same_count  == 2 && count($pair_ary) == 3)
			{
				
				$point = 2*$this->zeor_number;
				$two_pair_ary =array();
				// var_dump();
				foreach($pair_ary as $key =>$value)
				{
					if($value ==2)
					{
						$two_pair_ary[$cardAry[$key]] =  $addPointAry[$key];
						$two_pair_point[]= $addPointAry[$key];
					}else{
						$kicked = $addPointAry[$key];
					}
				}
				rsort($two_pair_point);
				krsort($two_pair_ary);
				// var_dump($two_pair_point);

				$two_pair_ary_str = join('-', array_keys($two_pair_ary));
				$point +=array_shift($two_pair_point)*10000000;
				$point +=array_shift($two_pair_point)*100000;
				$point +=$kicked*1000 ;
				$output['point'] = $point;
				$output['pokerOutput'] = 	$two_pair_ary_str .' Two Pairs';
				$output['type'] = 'Two Pairs';
				return $output;	
			}
			
			//1對
			$pair_high = array();
			if( $same_count  == 2 && count($pair_ary) == 4)
			{
				$point = 1*$this->zeor_number;
				foreach($pair_ary as $key =>$value)
				{
					if($value ==2)
					{
						$one_pair_ary_str =  $cardAry[$key];
						$add = $addPointAry[$key]*1000000;
						$point+=$add;
					}else{
						$pair_high[] = $addPointAry[$key];
					}

					// echo "<hr>";
				}
				rsort($pair_high);
				$point+=$pair_high[0]*10000+$pair_high[1]*100+$pair_high[2]*1;
				$output['point'] = $point;
				$output['pokerOutput'] = 	$one_pair_ary_str .'  Pairs';
				$output['type'] = 'Pairs';
				return $output;	
			}
			
			//高牌
			
			$point = 0;
			$output['point'] = $point;
			$odds = 1000000000;
			// $odds = 000000000;
			$AK =0;
			// var_dump($number);
			if($number[0] =='1')
			{
				array_shift($number);
				rsort($number);
				array_unshift($number, '1');
			}else{
				rsort($number);
			}
			// var_dump($number);
			foreach($number as $key =>$value)
			{
				// echo $key;
				if($value == 1 || $value ==13)
				{
					$AK++;
				}
				if($key ==4)
				{
					$odds=1;
				}else
				{
					$odds*=0.01;
				}
				$add = $addPointAry[$value]*$odds;
				$point+=$add;
				
				
			}
			$output['point'] = $point;
			$output['pokerOutput'] = 	'High card';
			$output['type'] = 'High card';
			$output['AK']=$AK;
			return $output;	
		}
	}
?>