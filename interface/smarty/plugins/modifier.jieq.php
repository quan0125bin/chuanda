<?php

	function smarty_modifier_jieq($str,$start=0,$num=30,$hz='...'){
		return substr($str,$start,$num).$hz;
	}

?>