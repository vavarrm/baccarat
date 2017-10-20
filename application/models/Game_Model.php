<?php
	class Game_Model extends CI_Model 
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			
		}
		
		public function add($ary)
		{
			// var_dump($ary);
			// echo join(':',$ary['player_hand_card']);
			$sql="	INSERT INTO `game`(
						`winner`,
						`winlose`,
						`bet`,
						`bet_double`,
						`player_point`,
						`banker_point`,
						`player_hand_card`,
						`player_hand_card_name`,
						`banker_hand_card`,
						`banker_hand_card_name`,
						`odds`,
						`player`,
						`game_type`,
						`play_error`,
						`add_time`
					)
					VALUES(
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						NOW()
					)";
			$bind = array(
				$ary['winner'],
				$ary['winlose'],
				$ary['bet'],
				$ary['bet_double'],
				$ary['player_point'],
				$ary['banker_point'],
				join(':',$ary['player_hand_card']),
				$ary['player_hand_card_name'],
				join(':',$ary['banker_hand_card']),
				$ary['banker_hand_card_name'],
				$ary['odds'],
				$ary['player'],
				$ary['game_type'],
				$ary['play_error'],
			);
			
			$query = $this->db->query($sql, $bind);
		}
	}
?>