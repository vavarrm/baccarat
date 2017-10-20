<?php
	class caribbeanPoker_Model extends CI_Model 
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
			
		}
		
		public function savebatch($ary)
		{
			$this->db->insert_batch('caribbean_poker_income', $ary); 
		}
		
		public function getProbabilityTable()
		{
			$sql="SELECT `card_style` FROM `probability_table` ORDER BY `card_style` LIMIT 1";
			$query = $this->db->query($sql);
			$row = $query->row();
			$query->free_result();
			return $row;
		}		
		
		public function getRandStyle()
		{
			
			$sql ="SELECT COUNT(*) total FROM `probability_table`";
			$query = $this->db->query($sql);
			$row = $query->row_array();
			$max= $row['total'] -1;
			srand((double)microtime()*1000000); 
			$index = rand(0,$max);
			$sql="SELECT `card_style` FROM `probability_table`  LIMIT  ?, 1";
			// $sql="SELECT `card_style` FROM `probability_table` ORDER BY RAND()  LIMIT  1";
			$bind = array(
				$index 
			);
			
			$query = $this->db->query($sql, $bind);
			$row = $query->row_array();
			$query->free_result();
			return $row;
		}
		
		public function addProbabilityTable($ary)
		{
			$this->db->insert_batch('probability_table', $ary); 
			// $sql ="INSERT INTO probability_table (`card_style`) VALUES(?)";
			// $bind = array($key);
			// $this->db->query($sql, $bind);
		}
		
		public function delProbabilityTable()
		{
			$sql="TRUNCATE TABLE `probability_table`";
			$this->db->query($sql, $bind);
		}
		
		public  function save($ary)
		{
			$sql ="INSERT INTO caribbean_poker_income (
					`banker_hand_card`, 
					`banker_card_style`, 
					`banker_card_point`, 
					`player_hand_card`, 
					`player_card_style`, 
					`player_card_point`, 
					`winner`,
					`odds`,
					`bet`,
					`double`,
					`winlose`,
					`play_point`
				)VALUES(
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
					?
				)";
			$bind = array(
				$ary['banker']['hand_card'],
				$ary['banker']['card_style'],
				$ary['banker']['card_point'],
				$ary['player']['hand_card'],
				$ary['player']['card_style'],
				$ary['player']['card_point'],
				$ary['winner'],
				$ary['odds'],
				$ary['bet'],
				$ary['double'],
				$ary['winlose'],
				$ary['playPoint'],
			);
			// $this->db->query($sql, $bind);
		}

	}
?>