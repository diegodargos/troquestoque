<?php

class LOG{
	private $convenio = null;
	private $pid = null;
	private $filename = "";
	
	public function LOG($convenio){
		$this->convenio = $convenio;
		$this->filename = "../log/".date("Y_m_d")."_convenio_".$convenio.".txt";
	}
	
	public function write($PK_Movimento, $Mensagem){
		$txt = "[Data: ".date("d/m/Y H:i:s")."][PID: ".getmypid()."][Movimento: $PK_Movimento] $Mensagem\r\n";
		if(!is_file($this->filename)){
			file_put_contents($this->filename, $txt);
		}else{
			file_put_contents($this->filename, $txt, FILE_APPEND);
		}
	}
}


?>