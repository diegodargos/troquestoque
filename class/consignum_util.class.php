<?php
require_once 'phpQuery-onefile.php';
require_once 'funcoes.php';
require_once 'util.class.php';

CLASS CONSIGNUM_UTIL{
	
	/**
	 * @method chkConvenioMT
	 * @param string $html
	 * @return boolean
	 * Verifica se o conteudo da página contém o texto Governo do Estado do Mato Grosso
	 */
	
	public static function chkConvenioMT($html){
		$checkConvenio = getElemento($html, 'a:contains(Governo do Estado de Mato Grosso)', 'text');
		if(is_string($checkConvenio) && strlen($checkConvenio) == 32){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * @method isPageLogin
	 * @param string $html
	 * @return boolean
	 * Verifica se existe campo de password na pagina - Pagina de Login
	 */
	public static function isPageLogin($html){
		$check = getElemento($html, 'input[type=password]', 'html');
		if(empty($check)){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * @method isLogged
	 * @param string $html
	 * @param string $usuario
	 * @return boolean
	 * Verifica se contem label com o codigo do usuario para garantir que a conexao esta ativa.
	 */
	public static function isLogged($html, $usuario){
		$check = getElemento($html, 'label:contains('.$usuario.')', 'text');
		if(is_string($check) && strlen(trim($check)) > 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * @method getListaBaixas
	 * @param string $html
	 * @return array $_baixas
	 * Retorna a lista de Baixas da Matricula aberta;
	 */
	public static function getListaBaixas($html){
		$_baixas = array();
		$tmpBaixas = getElemento($html, 'table:contains(LISTAGEM DE BAIXAS) > tbody', 'html');
		if(!is_string($tmpBaixas) || strlen(trim($tmpBaixas)) < 20 ) return false;
		$lista = getElemento($tmpBaixas, 'tr', 'html');
		if(!is_array($lista)){
			$lista = array($lista);
		}
		foreach ($lista as $item){
			$_campos = getElemento($item, 'td', 'text');
			$_baixas[] = array(
					'Protocolo' => trim($_campos[0]),
					'DtSolicitacao' => UTIL::formataData($_campos[1]),
					'DtAutorizacao' => UTIL::formataData($_campos[2]),
					'DtBaixa' => UTIL::formataData($_campos[3]),
					'Evento' => trim($_campos[4]),
					'ValorParcela' => UTIL::formataValor($_campos[5]),
					'QtdParcela' => trim($_campos[6]),
					'QtdParcelaDescontada' => trim($_campos[7]),
					'Observacao' => trim($_campos[8]),
			);
		}
	
		if(empty($_baixas)){
			return false;
		}else{
			return $_baixas;
		}
	}
	
	/**
	 * Retorna lista de Solicitações ativas para matricula selecionada
	 * @method getListaAtivos
	 * @param string $html
	 * @return boolean|array
	 */
	public static function getListaAtivos($html){
		$ativos = getElemento($html, 'table:contains(ATIVAS) > tbody', 'html');
		$_ativos = array();
		if(is_string($ativos)){
			$linhas = getElemento($ativos, 'tr', 'html');
			if(!is_array($linhas)){
				$linhas = array($linhas);
			}
			foreach($linhas as $linha){
				$ativo = getElemento($linha, 'td', 'text');
				if(is_string($ativo) && trim($ativo) == "" ) continue;
				$_ativos[] = array('Protocolo' => trim($ativo[0]),
						'Tipo' => trim($ativo[1]),
						'Nome' => trim($ativo[2]),
						'ValorSolicitado' => UTIL::formataValor($ativo[3]),
						'DtSolicitacao' => UTIL::formataData($ativo[4]),
						'ValorAutorizado' => UTIL::formataValor($ativo[5]),
						'DtAutorizacao' => UTIL::formataData($ativo[6]),
						'QtdParcelas' => $ativo[7]);
			}
		}
		if(empty($_ativos)){
			return false;
		}else{
			return $_ativos;
		}
	}
	
	/**
	 * Rotina para buscar detalhes da matricula para gravacao em banco de dados.
	 * @method getInfoMatricula
	 * @param string $html
	 * @return array('Evento','Colaborador','Matricula','Parceiro','InfoExtra',Margem','Instituicao','Situacao','Cargo','Nascimento')
	 */
	public static function getInfoMatricula($html){
		$instituicao = null;
		$nascimento = null;
		$situacao = null;
		$cargo = null;
	
		$tmpDetalhe = getElemento($html, 'table', 'html');
		$detalhe = $tmpDetalhe[2];
		if(!is_string($detalhe) || strlen(trim($detalhe)) == 0 ) return false;
		$tmpDados = getElemento($detalhe, 'td', 'text');
		$tmp = explode('-', trim($tmpDados[10]));
	
		if(count($tmp) == 6){
			$instituicao = trim($tmp[0]);
			$nascimento = strtotime(trim(str_replace(array('/','Dt Nasc'),array('-',''),trim($tmp[1]))));
			$situacao = trim($tmp[4]);
			$cargo = trim(str_replace(array("Cargo/Funcao:",$instituicao,"$situacao"),"",trim($tmp[2])));
		}elseif(count($tmp) == 7){
			$instituicao = trim($tmp[0]);
			$nascimento = strtotime(trim(str_replace(array('/','Dt Nasc'),array('-',''),trim($tmp[1]))));
			$situacao = trim($tmp[5]);
			$cargo = trim(str_replace(array("Cargo/Funcao:",$instituicao,"$situacao"),"",trim($tmp[2])." ".trim($tmp[3])));
		}elseif(count($tmp) == 8){
			$instituicao = trim($tmp[0]);
			if(strpos($tmp[1],'Dt Nasc') != false ){
				$nascimento = strtotime(trim(str_replace(array('/','Dt Nasc'),array('-',''),trim($tmp[1]))));
				$situacao = trim($tmp[6]);
				$cargo = trim(str_replace(array("Cargo/Funcao:",$instituicao,"$situacao"),"",trim($tmp[2])." ".trim($tmp[3])));
			}else{
				$nascimento = strtotime(trim(str_replace(array('/','Dt Nasc'),array('-',''),trim($tmp[2]))));
				$situacao = trim($tmp[6]);
				$cargo = trim(str_replace(array("Cargo/Funcao:",$instituicao,"$situacao"),"",trim($tmp[3])." ".trim($tmp[4])));
			}
		}else{
			error_log('Informacao de Separacao de dados da Matricula nao previsto');
		}
	
		$info = array(
				'Evento' => trim($tmpDados[2]),
				'Colaborador' => trim($tmpDados[4]),
				'Matricula' => trim($tmpDados[6]),
				'Parceiro' => trim($tmpDados[8]),
				'InfoExtra' => trim($tmpDados[10]),
				'Margem' => str_replace(array(".",","),array("","."),trim($tmpDados[12])),
				'Instituicao' => $instituicao,
				'Situacao' => $situacao,
				'Cargo' => $cargo,
				'Nascimento' => $nascimento == null ? null : date("Y-m-d",$nascimento)
		);
		return $info;
	}
	
	/**
	 * Retorna lista de matriculas do servidor localizado
	 * @method getListaMatriculas
	 * @param string $html
	 * @return boolean|array <Matriculas>
	 */
	public static function getListaMatriculas($html){
		$htmlMatriculas = getElemento($html, '#table_table', 'html');
		$listaMatriculas = array();
		if(is_string($htmlMatriculas) && strlen(trim($htmlMatriculas)) > 0 ){
			$Matriculas = getElemento($htmlMatriculas, 'tr', 'html');
			if(is_string($Matriculas)){
				$dados = getElemento($Matriculas,'td','text');
				$listaMatriculas[] = array(
						'Matricula' => trim($dados[0]),
						'Nome' => trim($dados[1]),
						'CPF' => trim($dados[2]),
						'Folha' => trim($dados[3])
				);
			}else{
				foreach($Matriculas as $Matricula){
					$dados = getElemento($Matricula,'td','text');
					$listaMatriculas[] = array(
							'Matricula' => trim($dados[0]),
							'Nome' => trim($dados[1]),
							'CPF' => trim($dados[2]),
							'Folha' => trim($dados[3])
					);
				}
			}
		}
		if(empty($listaMatriculas)){
			return false;
		}else{
			return $listaMatriculas;
		}
	}
	
	/**
	 * Busca dados de informação do colaborar na etapa de reserva
	 * @method getDadosReserva
	 * @param string $html
	 * @return boolean|array
	 */
	public static function getDadosReserva($html){
		$dados = getElemento($html, 'table:contains(Colaborador)', 'html');
		if(is_string($dados)){
			//Filtrando;
			$trs = getElemento($dados, 'tr', 'html');
			$filtro = getElemento($trs[2], 'td', 'text');
			$colaborador = trim($filtro[1]);
			$filtro = getElemento($trs[3], 'td', 'text');
			$matricula = trim($filtro[1]);
			$filtro = getElemento($trs[7], 'td', 'text');
			$margem = UTIL::formataValor(trim($filtro[1]));
			
			//Buscando dados da Reserva
			$dados = getElemento($html, 'table:contains(Valor Solicitado) > tbody', 'html');
			if(is_string($dados)){
				$trs = getElemento($dados, 'tr', 'html');
				$filtro = getElemento($trs[0], 'td', 'text');
				$contrato = trim($filtro[1]);
				$filtro = getElemento($trs[1], 'td', 'text');
				$ValorSolicitado = UTIL::formataValor(trim($filtro[1]));
				$filtro = getElemento($trs[2], 'td', 'text');
				$ValorParcela = UTIL::formataValor(trim($filtro[1]));
				$filtro = getElemento($trs[4], 'td', 'text');
				$Prazo = UTIL::formataValor(trim($filtro[0]));
				$filtro = getElemento($trs[5], 'td', 'text');
				$PeriodoInicio = trim($filtro[1]);
				$filtro = getElemento($trs[7], 'td', 'text');
				$ValorRepasse = UTIL::formataValor(trim($filtro[0]));
				$filtro = getElemento($trs[9], 'td', 'text');
				$ValorTotalExtra = UTIL::formataValor(trim($filtro[0]));
				$filtro = getElemento($trs[11], 'td', 'text');
				$Fator = UTIL::formataValor(trim($filtro[0]));
				return array('Colaborador' => $colaborador, 'Matricula' => $matricula, 'Margem' => $margem,
					'Contrato' => $contrato, 'ValorSolicitado' => $ValorSolicitado, 'ValorParcela' => $ValorParcela, 'Prazo' => $Prazo,
					'PeriodoInicio' => $PeriodoInicio, 'ValorRepasse' => $ValorRepasse, 'ValorTotalExtra' => $ValorTotalExtra, 'Fator' => $Fator);
			}
			return false;
		}else{
			return false;
		}
	}
	
	/**
	 * Busca os dados da confirmação da reserva de averbação;
	 * @method getReciboReserva
	 * @param string $html
	 * @return boolean|array
	 */
	public static function getReciboReserva($html){
		$campos = array();
		$dados = getElemento($html, 'table:contains(Reserva de Margem: Confirmada)', 'html');
		if(is_string($dados) && strlen(trim($dados)) > 20){
			//Estamos na pagina correta, recuperar informações.
			$dados = getElemento($html, 'form > fieldset', 'html');
			$parceiroHtml = $dados[0];
			//Informações do Protocolo da Reserva
			$_dadosProtocolo = getElemento($dados[1], 'li', 'text');
			$Protocolo = UTIL::getTextAfterString(": ",$_dadosProtocolo[1]);
			$IP = UTIL::between($_dadosProtocolo[2], '(', ')');
			//Informações de Valores da Reserva
			$valoresHtml = getElemento($dados[2], 'td', 'text');
			$contrato = trim($valoresHtml[1]);
			$valorSolicitado = trim($valoresHtml[3]);
			$valorParcela = trim($valoresHtml[5]);
			$Prazo = trim($valoresHtml[8]);
			$PeriodoInicio = trim($valoresHtml[11]);
			$valorRepasse = UTIL::formataValor(trim($valoresHtml[14]));
			$valorTotalExtra = UTIL::formataValor(trim($valoresHtml[17]));
			$Fator = trim($valoresHtml[22]);
			$campos = array('Protocolo' => $Protocolo, 'IP' => $IP, 'Contrato' => $contrato, 'ValorSolicitado' => $valorSolicitado,
				'ValorParcela' => $valorParcela, 'Prazo' => $Prazo, 'PeriodoInicio' => $PeriodoInicio, 'ValorRepasse' => $valorRepasse,
				'ValorTotalExtra' => $valorTotalExtra, 'Fator' => number_format($Fator,10));
			return $campos;
		}
		return false;
	}
	
	
	public static function getLinkReserva($html, $NumeroProtocolo){
		$dados = getElemento($html, "td > a:contains($NumeroProtocolo)", 'id');
		if(!is_string($dados) || strlen($dados) < 60) return false;
		return $dados;
	}
	
	public static function getConfirmacaoAverbacao($html){
		$dados = getElemento($html, '.ui-messages-info-summary:contains(sucesso)', 'text');
		if(trim($dados)){
			$dados = getElemento($html, 'table:contains(Matricula) > tbody', 'html');
			$dados = getElemento($dados, 'td', 'text');
			if(!is_array($dados)){
				return false;
			}
			return array('Colaborador' => trim($dados[1]), 'Matricula' => trim($dados[3]));
		}
		return false;
	}

}

?>