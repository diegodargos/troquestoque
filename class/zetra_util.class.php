<?php
require_once 'phpQuery-onefile.php';
require_once 'funcoes.php';
require_once 'util.class.php';
class ZETRA_UTIL{
	
	//Funções de Apoio de Acesso ao sistemas zetra.
	
	/**
	 * @method checkConexaoAtiva
	 * @param (string) $html
	 * @return (boolean)
	 * Verifica se o retorno da pagina contem a informação
	 * de desativação da página. 
	 */
	public static function checkConexaoAtiva($html){
		$chk = getElemento($html, '.TituloTabela:contains(abaixo para efetuar um novo login)', 'text');
		if(!is_string($chk)) return true;
		return false;
	}
	
	/**
	 * @method checkOrgao
	 * @param (string) $nome
	 * @param (string) $html
	 * @return (boolean)
	 * Verifica se o retorno da pagina contem a informação
	 * do $nome informado no parametro.
	 */
	public static function checkOrgao($nome, $html){
		$chk = getElemento($html, "p:contains($nome)", 'text');
		if(is_string($chk)) return true;
		return false;
	}
	
	/**
	 * @method getImageCaptcha
	 * @param (string) patchCapatcha
	 * @param (string) cookieName
	 * @return (src) #image
	 * Busca informações da imagem utilizada para login e retorna o recurso.
	 */
	public static function getImageCaptcha($patchCaptcha, $cookieName){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET,true);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieName);
		curl_setopt($ch, CURLOPT_URL, $patchCaptcha );
		$html = curl_exec($ch);
		curl_close($ch);
		return imagecreatefromstring($html);
	}
	
	
	public static function RSAEncrypt($plaintext, $modulus, $exponent){
		$pbKey = $modulus;
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		$public_key = array(
			'n' => new Math_BigInteger($pbKey, 16),
			'e' => new Math_BigInteger($exponent, 16) // same value as function that create KEY
		);
		$rsa->loadKey($public_key);
		$ciphertext = $rsa->encrypt($plaintext);
		$ciphertext_hex = bin2hex($ciphertext);
		return self::Hex2b64($ciphertext_hex);
	}
	
	public static function Hex2b64($str){
		$raw = '';
		for ($i=0; $i < strlen($str); $i+=2){
			$raw .= chr(hexdec(substr($str, $i, 2)));
		}
		return base64_encode($raw);
	}
	
	/**
	 * @method protecao
	 * @param (string) $html
	 * @param (string) $cssSelector
	 * @param (string) $texto
	 * @return (boolean)
	 * Verifica se está na pagina correta.
	 */
	public static function protecao($html, $cssSelector, $texto){
		$protege = getElemento($html, $cssSelector.':contains('.$texto.')', 'text');
		if($protege) return true;
		else return false;
	}
	
	/**
	 * @method getDadosServidor
	 * @param string $html
	 * @return array
	 */
	public static function getDadosServidor($html){
		$html = str_replace(array("&nbsp;"), array(""), $html);
		$table = getElemento($html, '.TabelaEntradaDeDados', 'html');
		if(count($table) != 2) return false;
		$tds = getElemento($table[0], 'td', 'text');
		var_dump($tds);
		if(count($tds) == 11){
			//Condição de Aroçoiaba
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[10]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[4])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => '',
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[3]),
					'Margem' => 0
			);
		}else{
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[12]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			
			$chk = getElemento($html, 'td:contains(oiaba da Serra)', 'text');
			if($chk){
				$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[4])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => $tds[10],
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[3]),
					'Margem' => !isset($tds[14]) ? 0 : UTIL::formataValor($tds[14])
				);
			}else{
				$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[4])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => $tds[10],
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[1]),
					'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'Margem' => !isset($tds[14]) ? 0 : UTIL::formataValor($tds[14])
				);
			}
		}
		return $info;
	}
	
	public static function getDadosServidorGovMS($html){
		$html = str_replace(array("&nbsp;"), array(""), $html);
		$table = getElemento($html, '.TabelaEntradaDeDados', 'html');
		if(count($table) != 2) return false;
		$tds = getElemento($table[0], 'td', 'text');
		if(count($tds) == 13){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpCargo = explode(" - ",utf8_decode($tds[10]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[4])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'CPF' => UTIL::RemoveAcentos(utf8_decode($tds[8])),
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[0]),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[1]),
					'Margem' => 0
			);
		}elseif(count($tds) == 15){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpCargo = explode(" - ",utf8_decode($tds[10]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[4])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'CPF' => UTIL::RemoveAcentos(utf8_decode($tds[8])),
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[0]),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[1]),
					'Margem' => UTIL::formataValor(utf8_decode($tds[12])),
			);
		}
		return $info;
	}
	
	public static function getDadosServidor_Piraguara($html){
		$html = str_replace(array("&nbsp;"), array(""), $html);
		$table = getElemento($html, '.TabelaEntradaDeDados', 'html');
		if(count($table) != 2) return false;
		$tds = getElemento($table[0], 'td', 'text');
		if(count($tds) == 15){	
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[12]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$info = array(
				'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[4])),
				'CodOrgao' => trim($tmpOrgao[0]),
				'Matricula' => $tmpMatricula[0],
				'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
				'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
				'CPF' => $tmpNascimento[1],
				'Identidade' => $tds[10],
				'Cargo' => UTIL::RemoveAcentos($tmpCargo[1]),
				'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
				'Vinculo' => UTIL::RemoveAcentos($tmpCargo[2]),
				'Margem' => !isset($tds[14]) ? 0 : UTIL::formataValor($tds[14])
			);
			return $info;
		}elseif(count($tds) == 13){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[12]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[2]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[2])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => UTIL::RemoveAcentos($tmpNascimento[1]),
					'Identidade' => $tds[10],
					'Cargo' => ($tmpCargo[1]),
					'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'Margem' => !isset($tds[14]) ? 0 : UTIL::formataValor($tds[14])
			);
			return $info;
		}
	}
	
	public static function getDadosServidor_Prefeitura_BH($html){
		$html = str_replace(array("&nbsp;"), array(""), $html);
		$table = getElemento($html, '.TabelaEntradaDeDados', 'html');
		if(count($table) != 2) return false;
		$tds = getElemento($table[0], 'td', 'text');
		if(count($tds) == 13){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[10]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[2]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[2])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => '',
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'Margem' => !isset($tds[12]) ? 0 : UTIL::formataValor($tds[12])
			);
		}elseif(count($tds) == 11){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[10]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[2]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tds[2])),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => '',
					'Cargo' => '',
					'DtAdmissao' => date("Y-m-d",strtotime(str_replace("/","-",$tmpCargo[0]))),
					'Vinculo' => UTIL::RemoveAcentos($tmpCargo[2]),
					'Margem' => !isset($tds[12]) ? 0 : UTIL::formataValor($tds[12])
			);
			
		}else{
			var_dump($tds);
			die("Erro na separação de matricula");
		}
		return $info;
	}
	
	public static function getDadosServidor_Aeronautica($html){
		$html = str_replace(array("&nbsp;"), array(""), $html);
		$table = getElemento($html, '.TabelaEntradaDeDados', 'html');
		$margem = getElemento($html, 'font[class=info]', 'html');
		if(empty($margem)){
			$margem = getElemento($html, 'font[class=erro]', 'html');
		}
		if(empty($margem)){
			die($html);
		}
		if($margem == "Militar/Pensionista não pode fazer novas reservas pois foi excluído"){
			$tmpMargem = UTIL::RemoveAcentos($margem);
		}else{
			$margem = explode('<br>', $margem);
			if(strpos($margem[1], "maior")){
				$tmpMargem = ($margem[1] ." e ". $margem[0]);
			}else{
				$tmpMargem = "";
			}
		}
		if(count($table) != 2) return false;
		$tds = getElemento($table[0], 'td', 'text');
		if(count($tds) == 19){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[14]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$tmpVinculo = explode(" - "  , utf8_decode($tds[12]));
			$tmpIdentidade = explode(" - ", $tds[10]);
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos($tds[2]),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => utf8_decode($tmpIdentidade[0]),
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[1]),
					'Vinculo' => UTIL::RemoveAcentos($tmpVinculo[1]),
					'Informacao' => UTIL::RemoveAcentos($tmpMargem)
			);
		}else if(count($tds) == 17){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpVinculo = explode(" - ",utf8_decode($tds[10]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$tmpCargo = explode(" - "  , utf8_decode($tds[12]));
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos($tds[2]),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => "",
					'CPF' => $tmpNascimento[0],
					'Identidade' => $tmpNascimento[1],
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[1]),
					'Vinculo' => UTIL::RemoveAcentos($tmpVinculo[1]),
					'Informacao' => UTIL::RemoveAcentos($tmpMargem)
			);
		}else if(count($tds) == 21){
			$tmpMatricula = explode(" - ",utf8_decode($tds[6]));
			$tmpNascimento = explode(" - ",utf8_decode($tds[8]));
			$tmpCargo = explode(" - ",utf8_decode($tds[14]));
			$tmpOrgao = explode(" - ",utf8_decode($tds[4]));
			$tmpVinculo = explode(" - "  , utf8_decode($tds[12]));
			$tmpIdentidade = explode(" - ", $tds[10]);
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos($tds[2]),
					'CodOrgao' => trim($tmpOrgao[0]),
					'Matricula' => $tmpMatricula[0],
					'Nome' => UTIL::RemoveAcentos($tmpMatricula[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmpNascimento[0]))),
					'CPF' => $tmpNascimento[1],
					'Identidade' => utf8_decode($tmpIdentidade[0]),
					'Cargo' => UTIL::RemoveAcentos($tmpCargo[1]),
					'Vinculo' => UTIL::RemoveAcentos($tmpVinculo[1]),
					'Informacao' => UTIL::RemoveAcentos($tmpMargem)
			);
		}else{
			var_dump($tds);
			die("Erro na separação de matricula");
		}
		return $info;
	}
	
	
	/**
	 * Retorna lista de informações de dados basicos da matricula.
	 * @method getListaDadosServidor
	 * @param string $html
	 * @return array|boolean
	 */
	public static function getListaDadosGovParana($html){
		$html = str_replace("&nbsp;", "", $html);
		$tabela = getElemento($html, '.TabelaEntradaDeDados', 'html');
		$tds = getElemento($tabela, 'td', 'text');
		if (count($tds) == 33){
			$tmpInstituicao = explode(' - ', utf8_decode($tds[2]));
			$tmpOrgao = explode(' - ', $tds[4]);
			$tmpNome = explode(' - ', $tds[6]);
			$tmCPF = explode(' - ', utf8_decode($tds[8]));
			$tmpMatricula = explode(' - ', UTIL::RemoveAcentos($tds[10]));
			$tmpDtAdmissao = explode(' - ', $tds[14]);
			$tmpMatricula[0] = str_replace("A", "", $tmpMatricula[0]);
			$info = array(
					'Instituicao' => UTIL::RemoveAcentos(utf8_decode($tmpOrgao[1])),
					'CodOrgao' => trim($tmpInstituicao[0]),
					'Matricula' => trim($tmpMatricula[0]),
					'Nome' => UTIL::RemoveAcentos($tmpNome[1]),
					'Nascimento' => date("Y-m-d",strtotime(str_replace("/","-",$tmCPF[0]))),
					'CPF' => $tmCPF[1],
					'Cargo' => UTIL::RemoveAcentos($tmpDtAdmissao[1]),
					'Vinculo' => UTIL::RemoveAcentos($tmpDtAdmissao[2]),
			);
		}
			return $info;
	}
	
	public static function getConfirmaReserva_Parana($html){
		$html = str_replace('&nbsp;', '', $html);
		$trs = getElemento($html, '.TabelaEntradaDeDados > tr', 'html');
		if(count($trs) == 23){
			$tmpOrgao = getElemento(utf8_decode($trs[4]), 'td', 'text');
			$tmpServidor = getElemento(utf8_decode($trs[5]), 'td', 'text');
			$tmpServidor = explode(" - ",$tmpServidor[1]);
			$tmpNascimento = getElemento(utf8_decode($trs[6]), 'td', 'text');
			$tmpNascimento = explode(" - ",$tmpNascimento[1]);
			$tmpAdmissao = getElemento(utf8_decode($trs[9]), 'td', 'text');
			$tmpAdmissao = explode(" - ",$tmpAdmissao[1]);
			$valorSolicitado = getElemento(utf8_decode($trs[12]), 'td', 'text');
			$valorPrestacao  = getElemento(utf8_decode($trs[13]), 'td', 'text');
			$Parcelas  = getElemento(utf8_decode($trs[14]), 'td', 'text');
			$periodoI = getElemento(utf8_decode($trs[15]), 'td', 'text');
			$info = array(
					'Orgao' => UTIL::RemoveAcentos($tmpOrgao[1]),
					'Nome' => UTIL::RemoveAcentos($tmpServidor[1]),
					'Matricula' => UTIL::RemoveAcentos($tmpServidor[0]),
					'Nascimento' => UTIL::formataData(UTIL::RemoveAcentos($tmpNascimento[0])),
					'CPF' => UTIL::RemoveAcentos($tmpNascimento[1]),
					'Admissao' => UTIL::formataData(UTIL::RemoveAcentos($tmpAdmissao[0])),
					'Vinculo' => UTIL::RemoveAcentos($tmpAdmissao[1]),
					'ValorSolicitado' => UTIL::formataValor($valorSolicitado[1]),
					'ValorParcela' => UTIL::formataValor($valorPrestacao[1]),
					'Parcelas' => UTIL::formataValor($Parcelas[1]),
					'PeriodoInicio' => UTIL::formataData(UTIL::RemoveAcentos($periodoI[1]))
			);
			return $info;
		}else{
			return false;
		}
	}
	
	/**
	 * Retorna lista de informações de dados basicos da matricula.
	 * @method getListaDadosServidor
	 * @param string $html
	 * @return array|boolean
	 */
	public static function getListaDadosServidor($html){
		$tabela = getElemento($html, '.TabelaEntradaDeDados', 'html');
		$trs = getElemento($tabela, 'tr', 'html');
		$matriculas = array();
		foreach($trs as $tr){
			$link = getElemento($tr, 'td', 'html');
			$tds = getElemento($tr, 'td', 'text');
			if(is_array($tds) && count($tds) == 7){
				$info = $tds;
				if($info[0] != "Nome"){
					$cod = explode(' - ', $info[4]);
					$link = getElemento($link[6], 'a', 'onclick');
					$link = str_replace("'", "", UTIL::between($link, ", '", "'," ));
					$matriculas[] = array(
							'CPF' => $info[1],
							'Nome' => UTIL::RemoveAcentos(utf8_decode($info[0])),
							'Vinculo' => UTIL::RemoveAcentos(utf8_decode($info[2])),
							'Instituicao' => UTIL::RemoveAcentos(utf8_decode($info[4])),
							'Matricula' => $info[3],
							'CodOrgao' => $cod[1],
							'Link' => $link
					);
				}
			}
		}
		if(empty($matriculas)){
			return false;
		}else{
			return $matriculas;
		}
	}
	
	/**
	 * Retorna lista de informações de dados basicos da matricula - Governo do Mato Grosso do Sul.
	 * @method getListaDadosServidor
	 * @param string $html
	 * @return array|boolean
	 */
	public static function getListaDadosServidorGovMS($html){
		$tabela = getElemento($html, '.TabelaResultado', 'html');
		$trs = getElemento($tabela, 'tr', 'html');
		$matriculas = array();
		foreach($trs as $tr){
			$link = getElemento($tr, 'td', 'html');
			$tds = getElemento($tr, 'td', 'text');
			if(is_array($tds) && count($tds) == 7){
				$info = $tds;
				if($info[0] != "Nome"){
					$cod = explode(' - ', $info[4]);
					$link = getElemento($link[6], 'a', 'onclick');
					$link = str_replace("'", "", UTIL::between($link, ", '", "'," ));
					$matriculas[] = array(
							'CPF' => $info[1],
							'Nome' => UTIL::RemoveAcentos(utf8_decode($info[0])),
							'Vinculo' => UTIL::RemoveAcentos(utf8_decode($info[2])),
							'Instituicao' => UTIL::RemoveAcentos(utf8_decode($info[4])),
							'Matricula' => $info[3],
							'CodOrgao' => $cod[1],
							'Link' => $link
					);
				}
			}
		}
		if(empty($matriculas)){
			return false;
		}else{
			return $matriculas;
		}
	}
	
	/**
	 * Busca Matricula Ativa para continuar em caso de margem - seleção para reservar.
	 * Retorna valores de RSE_CODIGO, SVC_CODIGO e Token.
	 * @method getMatriculaAtivaReservar
	 * @param string $html
	 * @return boolean|array 
	 */
	public static function getMatriculaAtivaReservar($html){
		$tabela = getElemento($html, '.TabelaResultado', 'html');
		$tr = getElemento($tabela, 'tr:contains(Ativo)', 'html');
		$aJS = getElemento($tr, 'a', 'onclick');
		if(is_array($aJS)) return false;
		$link = str_replace("'", "", UTIL::between($aJS, ", '", "',"));
		$js = getElemento($html, 'script:contains(doIt)', 'text');
		$SVC_CODIGO = UTIL::between($js, 'SVC_CODIGO=', '&');
		$token = getElemento($html, 'p', 'html');
		$token = UTIL::between($token, "eConsig.page.token=", "'");
		return array('RSE_CODIGO' => $link, 'SVC_CODIGO' => $SVC_CODIGO, 'Token' => $token);
	}
	
	/**
	 * Transforma em lista para armazenar os ranking no momento de realizar a reserva.
	 * @param string $html
	 * @return array
	 */
	public static function getRankings($html){
		$lista = getElemento($html, '.li', 'text');
		$lista2 = getElemento($html, '.lp', 'text');
		$lista = array_merge($lista,$lista2);
		$ranking = array();
		$banco = 0;
		$c = 0;
		while($c <count($lista)){
			$limpar = array("º","Â", " ");
			$tmp = isset($lista[$c+0]) ? str_replace($limpar, "", $lista[$c+0]) : "";
			if(is_numeric($tmp)){
				$ranking[$banco]['Posicao'] = $tmp;
				$tmp = isset($lista[$c+1]) ?  str_replace($limpar, "", $lista[$c+1]) : "";
				$ranking[$banco]['Nome'] = $tmp;
				$tmp = isset($lista[$c+2]) ?  floatval(str_replace(",",".",$lista[$c+2])) : "";
				$ranking[$banco]['ValorLiberado'] = $tmp;
				$tmp = isset($lista[$c+3]) ?  floatval(str_replace(",",".",$lista[$c+3])) : "";
				$ranking[$banco]['Taxa'] = $tmp;
				$tmp = isset($lista[$c+3]) ?  floatval(str_replace(",",".",$lista[$c+4])) : "";
				$ranking[$banco]['TaxaAnual'] = $tmp;
			}
			$c = $c+5;
			$banco++;
		}
		return $ranking;
	}
	
	/**
	 * Cria vetor com os dados informados no boleto para gravação em banco de dados.
	 * @method getDadosBoleto
	 * @param string $html
	 * @return array
	 */
	public static function getDadosGovParana($html){
		$itens = getElemento($html, '.FonteReduzida', 'html');
		$Nome = trim(between($itens[0], '<br>', 'Â'));
		$CPF = trim(between($itens[1], '<br>', 'Â'));
		$dtNascimento = trim(between($itens[3], '<br>', 'Â'));
		$estadoCivil = trim(between($itens[4], '<br>', 'Â'));
		$Matricula = trim(between($itens[5], '<br>', 'Â'));
		$Categoria = trim(between($itens[7], '<br>', 'Â'));
		$dtAdmissao = trim(between($itens[8], '<br>', 'Â'));
		$Orgao = trim(between($itens[9], '<br>', 'Â'));
		$Responsavel = trim(between($itens[11], '<br>', 'Â'));
		$Ranking = trim(between($itens[16], '<br>', 'Â'));
		$Operacao = trim(between($itens[13], '<br>', 'Â'));
		$dtOperacao = trim(between($itens[14], '<br>', 'Â'));
		$Ade = trim(between($itens[31], 'ADE: ', 'Â'));
		$ValorPrestacao = trim(between($itens[18], '<br>', 'Â'));
		$Prazo = trim(between($itens[19], '<br>', 'Â'));
		$dtInicio = trim(between($itens[20], '<br>', 'Â'));
		$dtFinal = trim(between($itens[21], '<br>', 'Â'));
		$ValorTotal = trim(between($itens[26], '<br>', 'Â'));
		return array(
				'Nome' => $Nome,
				'CPF' =>  $CPF,
				'dtNascimento' => UTIL::formataData($dtNascimento),
				'estadoCivil' => $estadoCivil,
				'Matricula' => $Matricula,
				'dtAdmissao' => UTIL::formataData($dtAdmissao),
				'dtOperacao' => UTIL::formataData($dtOperacao),
				'ADE' => $Ade,
				'ValorPrestacao' => UTIL::formataValor($ValorPrestacao),
				'Prazo' => intval($Prazo),
				'dtInicio' => substr(UTIL::formataData($dtInicio),0,7),
				'dtFinal' => UTIL::formataData($dtFinal),
				'ValorTotal' => UTIL::formataValor($ValorTotal),
		);
	}
	
	/**
	 * Cria vetor com os dados informados no boleto para gravação em banco de dados.
	 * @method getDadosBoleto
	 * @param string $html
	 * @return array
	 */
	public static function getDadosBoleto($html){
		$itens = getElemento($html, '.FonteReduzida', 'html');
		$Nome = trim(between($itens[0], '<br>', 'Â'));
		$CPF = trim(between($itens[1], '<br>', 'Â'));
		$dtNascimento = trim(between($itens[2], '<br>', 'Â'));
		$estadoCivil = trim(between($itens[3], '<br>', 'Â'));
		$RG = trim(between($itens[4], '<br>', 'Â'));
		$xLogr = trim(between($itens[5], '<br>', 'Â'));
		$xNum = trim(between($itens[6], '<br>', 'Â'));
		$xCompl = trim(between($itens[7], '<br>', 'Â'));
		$Bairro = trim(between($itens[8], '<br>', 'Â'));
		$Matricula = trim(between($itens[9], '<br>', 'Â'));
		$Categoria = trim(between($itens[10], '<br>', 'Â'));
		$dtAdmissao = trim(between($itens[11], '<br>', 'Â'));
		$Orgao = trim(between($itens[12], '<br>', 'Â'));
		$Responsavel = trim(between($itens[14], '<br>', 'Â'));
		$Ranking = trim(between($itens[15], '<br>', 'Â'));
		$Operacao = trim(between($itens[16], '<br>', 'Â'));
		$dtOperacao = trim(between($itens[17], '<br>', 'Â'));
		$Ade = trim(between($itens[21], '<br>', 'Â'));
		$ValorPrestacao = trim(between($itens[22], '<br>', 'Â'));
		$Prazo = trim(between($itens[23], '<br>', 'Â'));
		$dtInicio = trim(between($itens[24], '<br>', 'Â'));
		$dtFinal = trim(between($itens[25], '<br>', 'Â'));
		$ValorTotal = trim(between($itens[29], '<br>', 'Â'));
		return array(
			'Nome' => $Nome,
			'CPF' =>  $CPF,
			'dtNascimento' => UTIL::formataData($dtNascimento),
			'estadoCivil' => $estadoCivil,
			'RG' => $RG,
			'Matricula' => $Matricula,
			'dtAdmissao' => UTIL::formataData($dtAdmissao),
			'dtOperacao' => UTIL::formataData($dtOperacao),
			'ADE' => $Ade,
			'ValorPrestacao' => UTIL::formataValor($ValorPrestacao),
			'Prazo' => intval($Prazo),
			'dtInicio' => substr(UTIL::formataData($dtInicio),0,7),
			'dtFinal' => UTIL::formataData($dtFinal),
			'ValorTotal' => UTIL::formataValor($ValorTotal),
		);
	}
	
	public static function getDadosBoletoGovParana($html){
		$html = str_replace("&nbsp;", "", $html);
		$itens = getElemento(UTIL::RemoveAcentos($html), '.FonteReduzida', 'html');
		
		$Nome = UTIL::getTextAfterString("<br>", $itens[0]);
		$CPF = UTIL::getTextAfterString("<br>", $itens[1]);
		$dtNascimento = UTIL::getTextAfterString("<br>", $itens[3]);
		$estadoCivil = UTIL::getTextAfterString("<br>", $itens[4]);
		$Identidade = UTIL::getTextAfterString("<br>", $itens[5]);
		$Matricula = UTIL::getTextAfterString("<br>", $itens[6]);
		$Vinculo = UTIL::getTextAfterString("<br>", $itens[7]);
		$dtAdmissao = UTIL::getTextAfterString("<br>", $itens[8]);
		$Orgao = UTIL::getTextAfterString("<br>", $itens[9]);
		$dtOperacao = UTIL::getTextAfterString("<br>", $itens[14]);
		$ValorSolicitado = UTIL::getTextAfterString("<br>", $itens[17]);
		$ValorParcela = UTIL::getTextAfterString("<br>", $itens[18]);
		$Prazo = UTIL::getTextAfterString("<br>", $itens[19]);
		$dtInicio = UTIL::getTextAfterString("<br>", $itens[20]);
		$dtFinal = UTIL::getTextAfterString("<br>", $itens[21]);
		$Ade = getElemento($html, 'td:contains(ADE:)', 'text');
		$Ade = UTIL::getTextAfterString("ADE: ", $Ade[1] );
		return array(
				'Nome' => $Nome,
				'CPF' =>  $CPF,
				'dtNascimento' => UTIL::formataData($dtNascimento),
				'estadoCivil' => $estadoCivil,
				'Identidade' => $Identidade,
				'Matricula' => $Matricula,
				'Vinculo' => $Vinculo,
				'dtAdmissao' => UTIL::formataData($dtAdmissao),
				'dtOperacao' => UTIL::formataData($dtOperacao),
				'Orgao' => $Orgao,
				'ADE' => $Ade,
				'ValorParcela' => UTIL::formataValor($ValorParcela),
				'Prazo' => intval($Prazo),
				'dtInicio' => substr(UTIL::formataData($dtInicio),0,7),
				'dtFinal' => UTIL::formataData($dtFinal),
				'ValorSolicitado' => UTIL::formataValor($ValorSolicitado),
		);
	}
	
	public static function getDadosBoletoMatinhos($html){
		$itens = getElemento($html, '.FonteReduzida', 'html');
		$Nome = trim(between(utf8_encode($itens[0]), '<br>', 'Â'));
		$CPF = trim(between(utf8_encode($itens[1]), '<br>', 'Â'));
		$dtNascimento = trim(between(utf8_encode($itens[2]), '<br>', 'Â'));
		$estadoCivil = trim(between(utf8_encode($itens[3]), '<br>', 'Â'));
		$RG = trim(between(utf8_encode($itens[4]), '<br>', 'Â'));
		$xLogr = trim(between(utf8_encode($itens[5]), '<br>', 'Â'));
		$xNum = trim(between(utf8_encode($itens[6]), '<br>', 'Â'));
		$xCompl = trim(between($itens[7], '<br>', 'Â'));
		$Bairro = trim(between($itens[8], '<br>', 'Â'));
		$Matricula = trim(between(utf8_encode($itens[9]), '<br>', 'Â'));
		$Categoria = trim(between(utf8_encode($itens[10]), '<br>', 'Â'));
		$dtAdmissao = trim(between(utf8_encode($itens[11]), '<br>', 'Â'));
		$Orgao = trim(between(utf8_encode($itens[12]), '<br>', 'Â'));
		$Responsavel = trim(between(utf8_encode($itens[14]), '<br>', 'Â'));
		$Ranking = trim(between(utf8_encode($itens[15]), '<br>', 'Â'));
		$Operacao = trim(between(utf8_encode($itens[16]), '<br>', 'Â'));
		$dtOperacao = trim(between(utf8_encode($itens[17]), '<br>', 'Â'));
		$Ade = trim(between(utf8_encode($itens[20]), '<br>', 'Â'));
		$ValorPrestacao = trim(between(utf8_encode($itens[21]), '<br>', 'Â'));
		$Prazo = trim(between(utf8_encode($itens[22]), '<br>', 'Â'));
		$dtInicio = trim(between(utf8_encode($itens[23]), '<br>', 'Â'));
		$dtFinal = trim(between(utf8_encode($itens[24]), '<br>', 'Â'));
		$ValorTotal = trim(between(utf8_encode($itens[28]), '<br>', 'Â'));
		return array(
				'Nome' => $Nome,
				'CPF' =>  $CPF,
				'dtNascimento' => UTIL::formataData($dtNascimento),
				'estadoCivil' => $estadoCivil,
				'RG' => $RG,
				'Matricula' => $Matricula,
				'dtAdmissao' => UTIL::formataData($dtAdmissao),
				'dtOperacao' => UTIL::formataData($dtOperacao),
				'ADE' => $Ade,
				'ValorPrestacao' => UTIL::formataValor($ValorPrestacao),
				'Prazo' => intval($Prazo),
				'dtInicio' => substr(UTIL::formataData($dtInicio),0,7),
				'dtFinal' => UTIL::formataData($dtFinal),
				'ValorTotal' => UTIL::formataValor($ValorTotal),
		);
	}
	
	/**
	 * Verifica se existe lista de Mensagens a serem confirmadas.
	 * Se existir retorna array com valores a serem passados para confirmação.
	 * Se não, retorna false
	 * @method chkMensagens
	 * @param string $html
	 * @return array|boolean
	 */
	public static function chkMensagens($html){
		$Mensagens = getElemento($html, '.aviso:contains(Deve-se fazer a leitura das mensagens para continuar no sistema.)', 'text');
		$post = false;
		if($Mensagens){
			$chk = getElemento($html, 'input[type=checkbox]', 'name');
			$post = array();
			foreach($chk as $item){
				$post[$item] = 'S';
			}
		}
		return $post;
	}

	public static function getSVC_CODIGObyText($html, $text){
		$option = getElemento($html, "option:contains($text)", 'value');
		if(is_string($option)){
			return $option;
		}else{
			return false;
		}
	}

	
	public static function getConfirmaReserva_BeloHorizonte($html){
		$html = str_replace('&nbsp;', '', $html);
		$trs = getElemento($html, '.TabelaEntradaDeDados > tr', 'html');
		if(count($trs) == 18){
			$tmpOrgao = getElemento(utf8_decode($trs[2]), 'td', 'text');
			$tmpServidor = getElemento(utf8_decode($trs[4]), 'td', 'text');
			$tmpServidor = explode(" - ",$tmpServidor[1]);
			$tmpNascimento = getElemento(utf8_decode($trs[5]), 'td', 'text');
			$tmpNascimento = explode(" - ",$tmpNascimento[1]);
			$tmpAdmissao = getElemento(utf8_decode($trs[6]), 'td', 'text');
			$tmpAdmissao = explode(" - ",$tmpAdmissao[1]);
			$valorSolicitado = getElemento(utf8_decode($trs[8]), 'td', 'text');
			$valorPrestacao  = getElemento(utf8_decode($trs[9]), 'td', 'text');
			$Parcelas  = getElemento(utf8_decode($trs[10]), 'td', 'text');
			$periodoI = getElemento(utf8_decode($trs[11]), 'td', 'text');
			$info = array(
					'Orgao' => UTIL::RemoveAcentos($tmpOrgao[1]),
					'Nome' => UTIL::RemoveAcentos($tmpServidor[1]),
					'Matricula' => UTIL::RemoveAcentos($tmpServidor[0]),
					'Nascimento' => UTIL::formataData(UTIL::RemoveAcentos($tmpNascimento[0])),
					'CPF' => UTIL::RemoveAcentos($tmpNascimento[1]),
					'Admissao' => UTIL::formataData(UTIL::RemoveAcentos($tmpAdmissao[0])),
					'Vinculo' => UTIL::RemoveAcentos($tmpAdmissao[1]),
					'ValorSolicitado' => UTIL::formataValor($valorSolicitado[1]),
					'ValorParcela' => UTIL::formataValor($valorPrestacao[1]),
					'Parcelas' => UTIL::formataValor($Parcelas[1]),
					'PeriodoInicio' => UTIL::formataData(UTIL::RemoveAcentos($periodoI[1]))
			);
			return $info;
		}else{
			return false;
		}
	}
	
	public static function getBoleto_BeloHorizonte($html){
		$html = str_replace('&nbsp;', '', $html);
		$nome = getElemento($html, 'td > campo:contains(NOME)', 'html');
		$nome = UTIL::getTextAfterString("<br>", $nome[0]);
		$cpf = getElemento($html, 'td > campo:contains(CPF)', 'html');
		$cpf = UTIL::getTextAfterString("<br>", $cpf[0]);
		$valores = getElemento($html, 'td', 'html');
		if(count($valores) == 85){
			$info = array(
					'Nome' => $nome,
					'CPF' => $cpf,
					'ValorSolicitado' => UTIL::formataValor(str_replace(array('<campo>','</campo>'), '', $valores[31])),
					'Prazo' => UTIL::formataValor(str_replace(array('<campo>','</campo>'), '', $valores[34])),
					'ValorParcela' => UTIL::formataValor(str_replace(array('<campo>','</campo>'), '', $valores[35])),
					'PeriodoInicio' => UTIL::formataData(str_replace(array('<campo>','</campo>'), '', $valores[36])),
					'PeriodoFinal' => UTIL::formataData(str_replace(array('<campo>','</campo>'), '', $valores[37]))
			);
		}
		
		return $info;
	}
	
	
	public static function getAdeNumberBeloHorizonte($html, $adeCode){
		$table = getElemento(str_replace("&nbsp;", "", $html), 'table.TabelaResultado > tbody', 'html');
		$trs = getElemento($table, 'tr', 'html');
		foreach($trs as $tr){
			if(strpos($tr, $adeCode) !== false){
				$tmp = getElemento($tr, 'td', 'text');
				return $tmp[1];
			}			
		}
		return false;
	}
	
	/**
	 * 
	 * @param unknown_type $html
	 * @return multitype:mixed multitype:Ambigous <>
	 */
	public static function getURIAfterSegundaSenha($html){
		$dados = getElemento($html, 'script:contains(postData)', 'html');
		$dados = UTIL::between($dados,"URI('", "')");
		$params = explode("&", UTIL::getTextAfterString("?", $dados) );
		$url = explode("?",$dados);
		$url = str_replace("../", "", $url[0]);
	
		$post = array();
		foreach($params as $param){
			$tmp = explode("=",$param);
			$post[$tmp[0]] = $tmp[1];
		}
	
		return array('Link'=>$url,'POST' => $post);
	
	}
}
