<?php
	function smarty_modifier_todx($str,$xs){
		switch($xs){
			case "lower":
				$str=strtolower($str);
				break;
			case "upper":
				$str=strtoupper($str);
				break;
			case "first";
				$str=ucfirst($str);
				break;
		}
		return $str;
	}


?>