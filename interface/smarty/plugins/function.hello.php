<?php
	//自定义函数hello
	function smarty_function_hello($arr,&$smarty){
		$html="";
		for($i=0;$i<$arr['num'];$i++){
			$html.="<font size='{$arr['size']}' color='{$arr['color']}'>{$arr['content']}</font><br>";
		}
		return $html;
	}