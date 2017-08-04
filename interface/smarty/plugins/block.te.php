<?php
	function smarty_block_te($arr,$content,&$smarty){
		$html="";
		for($i=0;$i<$arr['num'];$i++){
			$html.="<font size='{$arr['size']}' color='{$arr['color']}'>{$content}</font><br>";
		}
		return $html;
	}


?>