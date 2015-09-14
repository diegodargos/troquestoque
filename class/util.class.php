<?php

class UTIL{
	
	/**
	 * Remove caracteres acentuados do texto baseado em regra de exclusão.
	 * Utilizado na captura de dados do Comtex RJ.
	 * @method RemoveAcentos
	 * @param string $texto
	 * @return string
	 */
	
	public static function RemoveAcentos($texto){
		$de = array("Á","É","Í","Ã","Õ","Ç","ç","Ú","À","Â","Ê","Ô","Ó","ê","é", "ª", "º", "'", "à" , "ã" , "á","í","&nbsp;" , "õ");
		$para = array("A","E","I","A","O","C","c","U","A","A","E","O","O","E","e"," ", " ","", "a", "a" , "a","i","" , "o");
		//return trim(str_replace($de, $para, strtoupper($texto)));
		return trim(str_replace($de, $para, $texto));
	}
	
	/**
	 * Gera string SQL para buscar movimentos baseado em regra do convenio cadastrada.
	 * @method doSQLListaMovimentos
	 * @param integer $idConvenio
	 * @param integer $qtMinimo
	 * @param integer $qtMaximo
	 * @return string
	 */
	
	public static function doSQLListaMovimentos($idConvenio, $qtMinimo = 1, $qtMaximo = 1, $pk_movimento = null){
		$qtd = rand($qtMinimo,$qtMaximo);
		$query = "SELECT * FROM tbl_movimento WHERE FK_Convenio = '$idConvenio' AND ValorInadimplenteAtual > 0.99 AND 
		(Status <> 'Invalido' AND Status <> 'Baixa' AND Status <> 'Encerrado') "; 
		if($pk_movimento) $query.= " AND PK_Movimento = '$pk_movimento' ";
		$query.= " ORDER BY DateTimeUpdate LIMIT $qtd";
		error_log('Lista de Movimentos Selecionados do Convenio: '.$idConvenio. ' => '.$qtd);
		return $query;
	}
	
	/**
	 * Calcula a parcela restante para a manutencao do contrato.
	 *
	 * @method ParcelaAverbacao
	 * @param float $ValorSolicitado
	 * @param float $ValorParcela
	 * @param integer $Prazo
	 * @param float $MargemDisponivel
	 * @return array
	 */
	public static function ParcelaAverbacao($ValorSolicitado, $ValorParcela, $Prazo, $MargemDisponivel){
		if($ValorParcela <= $MargemDisponivel) {
			$ValorIdeal = $ValorParcela;
			$ValorParcelaPendente = $ValorParcela - $ValorIdeal;
			$ValorSolicitadoPendente = round(($ValorIdeal*$Prazo) - $ValorSolicitado , 2);
			return array('ValorIdeal' => $ValorIdeal , 'ValorParcelaPendente' => $ValorParcelaPendente, 'ValorSolicitadoPendente' => $ValorSolicitadoPendente, 'Prazo' => $Prazo );
		}
		if($ValorParcela > $MargemDisponivel){
			$ValorParcelaPendente = $ValorParcela - $MargemDisponivel;
			$ValorSolicitadoPendente =  round($ValorSolicitado - ($MargemDisponivel*$Prazo) , 2);
			$ValorIdeal = $MargemDisponivel;
			return array('ValorIdeal' => $ValorIdeal , 'ValorParcelaPendente' => $ValorParcelaPendente, 'ValorSolicitadoPendente' => $ValorSolicitadoPendente, 'Prazo' => $Prazo );
		}
		if($MargemDisponivel <= 0) return false;
	}
	
	/**
	 * Calcula o valor para averbar cartao de credito
	 *
	 * @method CalculaCartao
	 * @param float $ValorSolicitado
	 * @param float $MargemDisponivel
	 * @return float
	 */
	public static function CalculaCartao($ValorSolicitado, $MargemDisponivel){
		if($ValorSolicitado <= $MargemDisponivel) {
			return $ValorSolicitado;
		}elseif($ValorSolicitado > $MargemDisponivel){
			$MargemDisponivel;
			return $MargemDisponivel;
		}elseif($MargemDisponivel <= 0) return false;
	}
	
	/**
	 * Calcula a Parcela e o Prazo necessario para atender a necessidade de recuperação.
	 * 
	 * @method CalculaParcela
	 * @param float $ValorTotal
	 * @param integer $prazoMinimo
	 * @param integer $prazoMaximo
	 * @param float $parcelaSolicitada
	 * @param float $parcelaDisponivel
	 * @param float $parcelaSolicitada
	 * @return array
	 */
	public static function CalculaParcelas($ValorTotal, $prazoMinimo, $prazoMaximo, $parcelaSolicitada, $parcelaDisponivel, $FK_Movimento = false){
		$dao = new DAO();
		if($FK_Movimento){
			$query = "SELECT a.Parcela, a.Prazo, SUM(b.ValorParcela), a.Parcela- SUM(b.ValorParcela) AS ParcelaPossivel FROM tbl_movimento a LEFT JOIN tbl_averbado b ON a.PK_Movimento = b.FK_Movimento WHERE PK_Movimento = '$FK_Movimento'";
			$row = $dao->loadByField($query);
			if($row) $parcela = $row->ParcelaPossivel;
			else $parcela = ($parcelaDisponivel > $parcelaSolicitada ? $parcelaSolicitada : $parcelaDisponivel);
		}else{
			$parcela = ($parcelaDisponivel > $parcelaSolicitada ? $parcelaSolicitada : $parcelaDisponivel);
		}
		$prazoIdeal = ceil($ValorTotal/$parcela);
		
		if($ValorTotal < $parcelaSolicitada){
			$parcela = $parcelaSolicitada - $ValorTotal;
			$prazoIdeal = ceil($ValorTotal/$parcela);
			return array('Prazo' => $prazoIdeal, 'Parcela' => $parcela);
		}
		
		if($prazoIdeal < $prazoMinimo) $prazoIdeal = $prazoMinimo;
		//Verificar a quantidade de parcelas ideal;
		if($prazoIdeal > $prazoMaximo){
			$prazoIdeal = $prazoMaximo;
		}elseif($prazoIdeal == $prazoMaximo){
			$parcela = round($ValorTotal/$prazoIdeal,2);
		}else{
			$parcela = round($ValorTotal/$prazoIdeal,2);
		}
		return array('Prazo' => $prazoIdeal, 'Parcela' => $parcela);
	}
	
	/**
	 * Transforma numeros padrão BR para formato US
	 * Exemplo: valores 1.000,00 para 1000.00
	 * @method formataValor
	 * @param string $valor
	 * @return float|boolean
	 * 
	 */
	public static function formataValor($valor){
		$tmp = trim(str_replace(array("R$", ".",","),array("","","."),trim($valor)));
		if(is_numeric($tmp)) return $tmp;
		return false;
	}
	
	/**
	 * Transforma numeros padrão BR para formato US
	 * Exemplo: valores 1000.00 para 1.000,00
	 * @method formataValorBR
	 * @param string $valor
	 * @return float|boolean
	 *
	 */
	public static function formataValorBR($valor){
		$tmp = str_replace(array(",","."),array("",","),trim($valor));
		if(is_string($tmp)) return $tmp;
		return false;
	}
	
	/**
 	 * Transforma data padrão BR para formato US
	 * Exemplo: 31/05/1978 18:05:07 para 1978-05-31 18:05:07 e 6/2015 para 2015-06-01 
	 * @method formataData
	 * @param string $data
	 * @return NULL|string
	 */
	public static function formataData($data){
		$tmp = explode('/', $data);
		if(count($tmp) == 2){
			$data = date("Y-m-d" , strtotime($tmp[1].'-'.$tmp[0].'-01 '));
			return $data;
		}
		if(trim($data) == "") return null;
		$tmp = date("Y-m-d H:i:s",strtotime(str_replace("/", "-", $data)));
		return $tmp;
	}
	
	/**
	 * Busca String disponível entre 2 delimitadores.
	 * @method between
	 * @param string $string
	 * @param string $start
	 * @param string $end
	 * @return boolean|string
	 * @example UTIL::between('<teste>','<','>');
	 */
	
	public static function between($string, $start, $end){
		if(is_array($string)) return false;
		$out = explode($start, $string);
		if(isset($out[1])){
			$string = explode($end, $out[1]);
			return $string[0];
		}else{
			return false;
		}
		return '';
	}
	
	/**
	 * Busca texto depois de uma determinada string.
	 * @method getTextAfterString
	 * @param string $string
	 * @param string $text
	 * @return false|string
	 * @example getTextAfterString(': 1-','Numeros: 1-3232')
	 */
	public static function getTextAfterString($string, $text){
		if (($pos = strpos($text, $string)) !== FALSE) {
			return trim(substr($text, $pos+strlen($string)));
		}
		return false;
	}
	
	/**
	 * Transforma decimais padrão US para padrão BR.
	 * Exemplo: 10.89 para 10,89
	 * @param float $number
	 * @return string $number
	 */
	public static function floatBR($number){
		return str_replace(".", ",", $number);
	}
	
	
	public static function maskField($val, $mask){
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++){
			if($mask[$i] == '#'){
				if(isset($val[$k])) $maskared .= $val[$k++];
			}else{
				if(isset($mask[$i])) $maskared .= $mask[$i];
			}
		}
		return $maskared;
	}
	
}