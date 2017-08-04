<?php 
require('sqlClass.class.php');
class desClass extends sqlClass{ 
	
	//3DES密钥
	private $key='HF3SU5AF843GHH3GH4UG45G4H';
	
	//3DES向量
	private $iv='ac_lj';
	
	function __construct($key=false,$iv=false){
		if(!extension_loaded('mcrypt')){
			echo '请安装并加载mcrypt扩展!';
			exit;
		}
		parent::__construct();
	}
	
	public function endes3($data,$ucode=false){
		if(!$data || $data=='') return null;
		$data=str_replace(PHP_EOL,'',$data);
		$data=base64_encode($this->encode($data));//加密
		if($ucode) $data=$this->urlencoding($data);  
		return $data;  
	}
	
	public function dedes3($data,$ucode=false){
		if(!$data || $data=='') return null;
		if($ucode) $data=$this->urldecoding($data);
		return $this->decode(base64_decode($data));//解密        
	}
	
	//url编码
	private function urlencoding($str){
		if(!trim($str)) return '';
		return rawurlencode($str);
	}
	
	//url解码
	private function urldecoding($str){
		if(!trim($str)) return '';
		return rawurldecode($str);
	}
	
	private function encode($text){
		return $this->encrypt($this->key, $this->iv, $text);
	}
	
	private function decode($text){
		return $this->decrypt($this->key, $this->iv, $text);
	}
	
	private function encrypt($key, $iv, $text){
		$key_add = 24 - strlen($key);
		$key .= substr($key, 0, $key_add);
		$text =$this->pad($text);
		$td = mcrypt_module_open (MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
		mcrypt_generic_init ($td, $key, $iv);
		$encrypt_text = mcrypt_generic ($td, $text);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $encrypt_text;
	} 
	
	private function decrypt($key, $iv, $text){
		$key_add = 24 - strlen($key);
		$key .= substr($key, 0, $key_add);
		$td = mcrypt_module_open (MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
		mcrypt_generic_init ($td, $key, $iv);
		$text = mdecrypt_generic ($td, $text);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $this->unpad($text);
	} 
	
	private function pad($text){
		$text_add = strlen($text) % 8;
		for($i = $text_add; $i < 8; $i++){
			$text .= chr(8 - $text_add);
		}			
		return $text;
	} 
	
	private function unpad($text){
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)){
			return false;
		} 
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad){
			return false;
		}			
		return substr($text, 0, -1 * $pad);
	} 

}