<?php
require_once 'deathbycaptcha.php';
require_once 'funcoes.php';

class CaptchaGoogle{
	
	private $publickey = null;
	private $recaptcha_challenge_field = null;
	private $recaptcha_response_field = null;
	private $captcha = null;
	private $client = null;
	
	public function CaptchaGoogle($publickey){
		$this->publickey = $publickey;
	}
	
	public function ResolveCaptcha(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET,true);
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/challenge?k=$this->publickey" );
		$html = curl_exec($ch);
		$recaptcha_challenge_field = between($html, " challenge : '", "',");
		//Tratando Imagem 
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/image?c='.$recaptcha_challenge_field );
		$html = curl_exec($ch);
		$this->client = new DeathByCaptcha_HttpClient('gerona', 'tajef71b5n');
		try {
			$balance = $this->client->get_balance();
			$captcha = $this->client->decode('base64:'.base64_encode($html), 60);
			$image = imagecreatefromstring($html);
			imagejpeg($image,'imagem_captcha_resolving.jpg');
			if ($captcha) {
				$this->recaptcha_challenge_field = $recaptcha_challenge_field;
				$this->recaptcha_response_field = $captcha["text"];
				$this->captcha = $captcha['captcha'];
			}
		}catch(DeathByCaptcha_AccessDeniedException $e){
			$image = imagecreatefromstring($html);
		 	imagejpeg($image,'imagem_captcha_unresolved.jpg');
			var_dump($e);
		}
	}
	
	public function reportIncorret(){
		//Comunica erro ao resolver captcha;
		try{
			$this->client->report($this->captcha);
		}catch(DeathByCaptcha_AccessDeniedException $e){
			var_dump($e);
		}
	}
	
	public function getChallangeField(){
		return $this->recaptcha_challenge_field;
	}
	
	public function getResponseField(){
		return $this->recaptcha_response_field;
	} 
	
}