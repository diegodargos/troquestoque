<?php

class CURL{
	private $cookie;
	private $html;
	private $basename = "";
	private $header = null;
	private $sleep = true;
	private $info = null;
	private $debug = true;
	private $_headers = array( 
		array (
			//'Host: mt.consignum.com.br',
			'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.132 Safari/537.36',
			'Origin: https://mt.consignum.com.br',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Cache-Control: max-age=0'
		),
		array (
			//'Host: mt.consignum.com.br',
			'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0',
			'Origin: https://mt.consignum.com.br',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Cache-Control: max-age=0'
		),
		array (
			//'Host: mt.consignum.com.br',
			'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
			'Origin: https://mt.consignum.com.br',
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Cache-Control: max-age=0'
		)
	);
	
	public function CURL($cookieName){
		$this->cookie =  $cookieName; 
		$this->header = rand(0,2);
	}
	
	public function setBaseName($var){
		$this->basename = $var;
	}
	
	public function setNoSleep(){
		$this->sleep = false;
	}
	
	
	public function exec($url, $post = null, $cookie = true, $timeout = 30, $extraHeaders = null){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); //URL a ser lida
		
		$HEADER = $this->_headers[$this->header];
		if($extraHeaders){
			$HEADER = array_merge($HEADER,$extraHeaders);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $HEADER);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		if($cookie){
			curl_setopt($ch, CURLOPT_COOKIE, true); //Utiliza Cookie
			curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie); //Salva o Cookie
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Retorna HTML do curl_exec
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Conexão HTTPS
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		if(is_array($post)){
			curl_setopt($ch,CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		}elseif(is_string($post)){
			curl_setopt($ch,CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		$this->html = curl_exec($ch);
		$this->info = curl_getinfo($ch);
		
		if($this->sleep){
			sleep(rand(3,7));
		}
		
		curl_close($ch);
	}
	
	public function getInfo(){
		return $this->info;
	}
	
	
	public function getHTML($filename = null){
		if($this->debug){
			if($filename) file_put_contents("../tmp/".$this->basename."_$filename".date("_Ymd_His").".html", $this->html);
			else file_put_contents("../tmp/".$this->basename."_".date("Ymd_His").".html", $this->html);
		}
		return $this->html;
	}
}

?>