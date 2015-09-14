<?php
//Página contendo funções de apoio para utilização no filtro dos parametros;

function mask($val, $mask){
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
/**
 * @method bdDate
 * @param (string) $data 
 * @param (string) $mask 
 * @return (string) aaaa/mm/dd
 * Deixa a data no modelo do banco de dados
 * Informar mask no modelo em que a data está vindo ex: dd/mm/aaaa.
 */
function bdDate ($data , $mask){
	for($i = 0 ; $i < strlen($mask) ; $i++){
		if($mask[$i] == 'd') $dia[] = array ( $data[$i] );
		if($mask[$i] == 'm') $mes[] = array ( $data[$i] );
		if($mask[$i] == 'a') $ano[] = array ( $data[$i] );
	}
	
	$datafinal = $ano[0][0].$ano[1][0].$ano[2][0].$ano[3][0]."/".$mes[0][0].$mes[1][0]."/".$dia[0][0].$dia[1][0];
	return $datafinal; 
}

function ajustaParcela($divida, $parcelatual, $prazoMinimo, $prazoMaximo, $parcelaMinima, $parcelaSolicitada){
	if($parcelatual > $parcelaSolicitada){
		$parcela = $parcelaSolicitada;
	}else{
		$parcela = $parcelatual;
	}
	$parcelaSaida = $parcela;
	$prazoMaximoCalculado = (int) ( $divida/$parcelatual );
	$prazo = min ( array ( max ( array ( $prazoMaximoCalculado, $prazoMinimo) ), $prazoMaximo ) );
	$prazoInicial = $prazo;
	
	echo "<pre>";
	echo "Divida: $divida</br>";
	echo "Parcela Atual: $parcelatual</br>";
	echo "Prazo Minimo: $prazoMinimo</br>";
	echo "Prazo Maximo: $prazoMaximo</br>";
	echo "Parcela Minima: $parcelaMinima</br>";
	echo "Prazo Maximo Calculado: $prazoMaximoCalculado</br>";
	echo "Valor de Parcela Desejado: $parcelaSolicitada</br>";
	echo "Prazo a Aplicar: $prazo</br>";
	echo "</pre>";
	
	while( abs((round($parcela*$prazo,2) - round($divida,2))) > 0.10){
		if($prazo >= $prazoMaximo){
			echo "<pre>";
			echo "retornando devido a prazo Maximo<br>";
			echo "Valor Total a recuperar: ".round($parcela*$prazo,2)."<br>";
			echo "Valor Divida restante: ".($divida-round($parcela*$prazo,2))."<br>";
			return array('Parcela' => $parcela, 'Prazo' => $prazo);
			echo "</pre>";
		}
		$prazo++;
		$parcela = round($divida/$prazo,2);
		echo "<pre>";
		echo "Recalculadondo<br>";
		echo "Divida: $divida</br>";
		echo "Parcela Atual: $parcela</br>";
		echo "Novo Prazo: $prazo</br>";
		echo "Total Parcela x Prazo: ".round($parcela*$prazo,2)."<br>";
		echo "Diferença na somatoria: ".(round($parcela*$prazo,2) - round($divida,2))."<br>";
		echo "</pre>";
		if($parcela < $parcelaMinima){
			$parcela = round($divida/$prazoInicial,2);
			echo "<pre>";
			echo "Voltando pra Condição Inicial<br>";
			echo "Divida: $divida</br>";
			echo "Prazo: $prazoInicial<br>";
			echo "Parcela: $parcelaSaida<br>";
			echo "Valor Abatido: ".round($parcelaSaida*$prazoInicial,2)."<br>";
			return array('Parcela' => $parcelaSaida, 'Prazo' => $prazoInicial);
		}
	}
	
	return array('Parcela' => $parcela, 'Prazo' => $prazo);
}


function between($string,$start,$end){
	if(is_array($string)) die(var_dump($string));
	$out = explode($start, $string);
	if(isset($out[1])){
		$string = explode($end, $out[1]);
		return $string[0];
	}else{
		echo("<br>Error: $string between $start and $end <br>");
	}
	return '';
}

function numberFormat($valor){
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);
	return $valor;
}

function number2BR($valor){
	return str_replace(".", ",", $valor);
}
//Função para realizar busca phpquery através de selector CSS.
function getElemento($html, $cssSelector, $atributo){
	$dom = phpQuery::newDocument($html);
	$v = array();
	foreach(pq($cssSelector) as $elemento){
		if($atributo == "html"){
			$v[] = pq($elemento)->html();
		}elseif($atributo == "text"){
			$v[] = pq($elemento)->text();
		}else{
			$v[] = pq($elemento)->attr($atributo);
		}
	}

	if(count($v) == 1 ){
		return $v[0];
	}else{
		return $v;
	}
}

function debugPost($step, $post){
	echo "<h3>Passo $step</h3>";
	foreach($post as $elemento => $value){
		echo "<h6>POST $elemento=> $value</h6>";
	}
}

//Controle de usuario
//Valida Sessao
function checkSession($dir = '.'){
	$browserSession = isset($_COOKIE['session']) ? $_COOKIE['session'] : null;
	$browserUser = isset($_COOKIE['user']) ? $_COOKIE['user'] : null;
	$browserUserData = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
	if(!$browserSession || !$browserUser) return false;
	if(file_exists("$dir/sessions/$browserSession")){
		$data = preg_split('/\n/',file_get_contents("$dir/sessions/$browserSession"));
		if($data[0] > time() && $data[1] == $browserUser ){
			file_put_contents('update_session.txt', date("Y-m-d H:i:s"). "\n". print_r($data,true) . "\n", FILE_APPEND);
			$sessionTime = time() + 1800;
			setcookie("user", $browserUser, $sessionTime ); //1 hora
			setcookie("userData", $browserUserData, $sessionTime ); //1 hora
			setcookie("session", $browserSession, $sessionTime); //1 hora
			//Update
			file_put_contents("$dir/sessions/".$browserSession, "$sessionTime\n$browserUser");
			return true;
		}
	}
	return false;
}



function mkParcela($numero, $total){
	return str_pad($numero, 3, '0', STR_PAD_LEFT)."/".str_pad($total, 3, '0', STR_PAD_LEFT);
}

function addMes($data, $meses){
	$tmp = explode('/',$data);
	if(count($tmp) == 2){
		$data = mktime(0,0,0,trim($tmp[0]), 1, trim($tmp[1]));
	}else{
		$date = strtotime($data);
	}
	return mktime(0,0,0,date('m',$date)+$meses,date('d',$date),date('Y',$date));
}
?>