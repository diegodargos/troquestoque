<?php
set_time_limit(90);
require_once 'dao.class.php';
require_once 'phpQuery-onefile.php';
require_once 'deathbycaptcha.php';
require_once 'funcoes.php';


Class WorkFlow{
	
	private $fluxo = null;
	private $dao = null;
	private $etapa = null;
	private $param = null;
	private $debug = false;
	private $cookiefile = null;
	private $wasCaptcha = false;
	private $context;
	private $variaveis;
	private $read;
	private $write;
	
	public function WorkFlow($Convenio){
		$this->dao = new DAO();
		//Buscando o convenio para localizar o fluxo a utilizar
		$query = "SELECT FK_Fluxo FROM tbl_convenio WHERE PK_Convenio = '{$Convenio}'";
		$fluxo = $this->dao->loadByQuery($query, new stdClass());
		if(!$fluxo) die("Erro na seleção do convenio");
		
		//Buscando dados de Login baseado em tabela de convenio;
		$query = "SELECT * FROM tbl_convenio_usuario WHERE FK_Convenio = '{$Convenio}' LIMIT 1";
		$usuario = $this->dao->loadByQuery($query, new stdClass());
		self::__set("LOGIN", $usuario->Usuario);
		self::__set("PASSWORD", $usuario->Senha);
		
		$this->fluxo = $fluxo->FK_Fluxo;
		$this->cookiefile = uniqid('cookiefile_').".txt";
	}
	
	public function setDebug(){
		$this->debug = true;
	}
	
	private function setHeaders(){
		
	}
	
	private function setParams(){
		$query = "SELECT * FROM tbl_parametro WHERE FK_Etapa ='{$this->etapa->PK_Etapa}' AND Method = 'POST'";
		$_params = $this->dao->listaFromQuery($query, new stdClass());
		$_values = array();
		//Variaveis a serem lidas;
		foreach($_params as $param){
			if($param->Type == "string"){
				$_values[$param->Varname] = $param->Attribute;
				$this->write[$param->Varname] = $param->Attribute;
			}elseif($param->Type == "eval"){
				if( substr($param->Varname, 0,1) == "$" && substr($param->Attribute, 0,1) == "$" ){
					$_values[self::__get(str_replace("$", "", $param->Varname))] = self::__get(str_replace("$", "", $param->Attribute));
					$this->write[self::__get(str_replace("$", "", $param->Varname))] = self::__get(str_replace("$", "", $param->Attribute));
				}elseif( substr($param->Varname, 0,1) != "$" && substr($param->Attribute, 0,1) == "$" ){
					$_values[$param->Varname] = self::__get(str_replace("$", "", $param->Attribute));
					$this->write[$param->Varname] = self::__get(str_replace("$", "", $param->Attribute));
				}else{
					$_values[self::__get(str_replace("$", "", $param->Varname))] = $param->Attribute;
					$this->write[self::__get(str_replace("$", "", $param->Varname))] = $param->Attribute;
				}
			}else{
				$_values[$param->Varname] = self::__get($param->Varname);
				$this->write[$param->Varname] = $_values[$param->Varname];
			}
		}
		
		return $_values;
	}
	
	private function setParamsConvenio(){
		$query = "SELECT * FROM tbl_convenio_parametro WHERE FK_Etapa ='{$this->etapa->PK_Etapa}' AND Method = 'POST'";
		$_params = $this->dao->listaFromQuery($query, new stdClass());
		$_values = array();
		//Variaveis a serem lidas;
		foreach($_params as $param){
			if($param->Type == "string"){
				$_values[$param->Varname] = $param->Attribute;
			}elseif($param->Type == "eval"){
				if( substr($param->Varname, 0,1) == "$" && substr($param->Attribute, 0,1) == "$" ){
					$_values[self::__get(str_replace("$", "", $param->Varname))] = self::__get(str_replace("$", "", $param->Attribute));
				}elseif( substr($param->Varname, 0,1) != "$" && substr($param->Attribute, 0,1) == "$" ){
					$_values[$param->Varname] = self::__get(str_replace("$", "", $param->Attribute));
				}
			}else{
				$_values[$param->Varname] = self::__get($param->Varname);
			}
			$this->write[$param->Varname] = $_values[$param->Varname];
		}
		return $_values;
	}
	
	private function setParamFilter(){
		$query = "SELECT * FROM tbl_filtro_parametro a LEFT JOIN tbl_parametro b ON b.PK_Parametro = a.FK_Parametro
		WHERE FK_Parametro ='{$this->param->PK_Parametro}' ORDER BY Sequencia ";
		
		$_filters = $this->dao->listaFromQuery($query, new stdClass());
		foreach($_filters as $filter){
			$var = self::__get($filter->Varname);
			if(substr($filter->Condicao,0,6) == "Array[" ){
				$posicao = (int) between($filter->Condicao, '[', ']');
				$var = $var[$posicao];
			}else{
				$var = eval( "return ".str_replace('$var', $var, $filter->Condicao).";" );
			}
			self::__set($filter->Varname, $var);
			
			$this->read[$filter->Varname] = $var;
		}
	}
	
	private function getParams(){
		$query = "SELECT * FROM tbl_parametro WHERE FK_Etapa ='{$this->etapa->PK_Etapa}' AND Method = 'GET'";
		$_params = $this->dao->listaFromQuery($query, new stdClass());
		//Variaveis a serem lidas;
		foreach($_params as $param){
			$dom = phpQuery::newDocument($this->context);
			foreach(pq($param->CssSelector) as $elemento){
				if($param->Type == "array"){
					$_array[] = pq($elemento)->attr($param->Attribute);
					self::__set($param->Varname, $_array);
				}elseif($param->Type == "eval"){
					if( substr($param->Attribute,0,1) == "$" ){
						self::__set($param->Varname, self::__get(str_replace("$", "", $param->Attribute)) );
					}else{
						echo "<h1>Condição Eval não prevista</h1>";
					}
				}else{
					self::__set($param->Varname, pq($elemento)->attr($param->Attribute) );
				}
			}
			
			$this->read[$param->Varname] = self::__get($param->Varname);
			$this->param = $param;
			//Vendo Filtros aplicados ao parametro.
			self::setParamFilter();
		}
	}
	
	private function getParamsConvenio(){
		$query = "SELECT * FROM tbl_convenio_parametro WHERE FK_Etapa ='{$this->etapa->PK_Etapa}' AND Method = 'GET'";
		$_params = $this->dao->listaFromQuery($query, new stdClass());
		//Variaveis a serem lidas;
		foreach($_params as $param){
			$dom = phpQuery::newDocument($this->context);
			foreach(pq($param->CssSelector) as $elemento){
				if($param->Type == "array"){
					$_array[] = pq($elemento)->attr($param->Attribute);
					self::__set($param->Varname, $_array);
				}elseif($param->Type == "eval"){
						
				}else{
					self::__set($param->Varname, pq($elemento)->attr($param->Attribute) );
				}
			}
			$this->read[$param->Varname] = self::__get($param->Varname);
			$this->param = $param;
			//Vendo Filtros aplicados ao parametro.
		}
	}
	
	private function doCurl(){
		$this->read = array();
		$this->write = array();
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->etapa->Url); //Endereço a ser utilizado
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna HTML da execção.
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Permite conexão HTTPS
		curl_setopt($ch, CURLOPT_COOKIE, true);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookiefile);
		
		if($this->etapa->Cookie) curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiefile);
		
		if($this->etapa->Method == "CAPTCHA"){
			self::resolveCaptcha();
			return;
		}
		
		//Posta Parametros Globais
		if($this->etapa->Method == "POST"){
			$vars = self::setParams();
			$vars2 = self::setParamsConvenio();

			$post = http_build_query($vars);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		
		$this->context = curl_exec($ch);
		//Busca Parametros Globais;
		self::getParams();
		self::getParamsConvenio();
		
		if($this->debug){
			echo "<h2>Etapa: {$this->etapa->Sequencia} na URL: {$this->etapa->Url}</h2>";
			echo "<h3>Operação: {$this->etapa->Descricao}</h3>";
			echo "<h3>POST</h3>";
			foreach($this->write as $input => $valor){
				echo "<br>[PostParam] $input=>$valor";
			}
			echo "<h3>HTML</h3>";
			echo $this->context;
			echo "<h3>GET</h3>";
			foreach($this->read as $input => $valor){
				echo "<br>[GetParam] $input=>$valor";
			}
		}
		curl_close($ch);
	}
	
	public function execute(){
		$query = "SELECT * FROM tbl_etapa WHERE FK_Fluxo ='{$this->fluxo}' ORDER BY Sequencia";
		$_etapas = $this->dao->listaFromQuery($query, new stdClass());
		foreach($_etapas as $etapa){
			$this->etapa = $etapa;
			self::doCurl();
		}
	}
	
	public function __get($varName){
		if (!array_key_exists($varName,$this->variaveis)){
			echo "<h3>Nao foi possivel recuperar: $varName</h3>";
			//throw new Exception("Var: $varName not found");
		}
		else return $this->variaveis[$varName];
	}
	
	public function __set($varName,$value){
		$this->variaveis[$varName] = $value;
	}
	
	private function resolveCaptcha(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET,true);
		curl_setopt($ch, CURLOPT_URL, self::__get('CaptchaSite') );
		$html = curl_exec($ch);
		$recaptcha_challenge_field = between($html, " challenge : '", "',");
		
		
		//Tratando Imagem Maldita
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/image?c='.$recaptcha_challenge_field );
		$html = curl_exec($ch);
		$client = new DeathByCaptcha_HttpClient('gerona', 'tajef71b5n');
		try {
			$balance = $client->get_balance();
			$captcha = $client->decode('base64:'.base64_encode($html), 60);
			if ($captcha) {
				$recaptcha_response_field = $captcha["text"];
				self::__set('recaptcha_challenge_field', $recaptcha_challenge_field);
				self::__set('recaptcha_response_field', $recaptcha_response_field);
				//echo "CAPTCHA {$captcha["captcha"]} solved: {$captcha["text"]}";
			}
		}catch(DeathByCaptcha_AccessDeniedException $e){
			var_dump($e);
		}
	}
	
}
?>