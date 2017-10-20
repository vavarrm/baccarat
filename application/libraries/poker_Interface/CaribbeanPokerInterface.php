<?php
interface CaribbeanPokerInterface
{
	//開始
	public function start();
	//判斷牌型取得權重
	public function getCardPoint($ary);
	
}
?>