<?php
require_once 'phpQuery-onefile.php';
require_once 'funcoes.php';

class COMTEX_UTIL{

	/**
	 * @method chkConvenioMT
	 * @param string $html
	 * @return boolean
	 * Verifica se o conteudo da página contém o texto Governo do Municipio do Rio de janeiro
	 */
	
	public static function comtex_chkConvenioRJ($html){
		$checkConvenio = getElemento($html, 'a:contains(PREFEITURA RIO DE JANEIRO)', 'name');
		if($checkConvenio){
			return false ;
		}else{
			return true;
		}
	}
	
	/**
	 * @method isPageLogin
	 * @param string $html
	 * @return boolean
	 * Verifica se existe campo de password na pagina - Pagina de Login
	 */
	public static function comtex_isPageLogin($html){
		$check = getElemento($html, 'legend:contains(Informativos)', 'text');
		if($check){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * @method protege
	 * @param (string) $html
	 * @param (string) $cssSelector
	 * @param (string) $texto
	 * @return (boolean)
	 * Verifica se está na pagina correta.
	 */
	public static function comtex_protege($html , $cssSelector , $texto){
		$protege = getElemento($html, $cssSelector.':contains('.$texto.')', 'text');
		if($protege) return false;
		else return true;
	}
	
	/**
	 * @method getListaMatriculas
	 * @param string $html
	 * @return boolean|array <Matriculas>
	 * Retorna lista de matriculas do servidor localizado
	 */
	public static function comtex_getListaMatriculas($html){
		$tbl = getElemento ( $html, '.rf-edt-tbl', 'html' );
		$tbl = getElemento($tbl[2], 'tr', 'html');
		$listaMatriculas = array();
		$count = 0;
		//Gravando todas as matriculas para o CPF
		foreach($tbl as $item){
			$colunas = getElemento($item, 'td', 'html');
			if(count($colunas) == 5){
				$listaMatriculas[$count]['Matricula'] = getElemento($colunas[0],'div > div', 'text');//Matricula no site com 10 posições
				$listaMatriculas[$count]['Nome'] = UTIL::RemoveAcentos(getElemento($colunas[1],'div > div', 'text'));
				$listaMatriculas[$count]['Documento'] = getElemento($colunas[2],'div > div', 'text');
				$listaMatriculas[$count]['UlFolha'] = getElemento($colunas[3],'div > div', 'text');
				$listaMatriculas[$count]['Input'] = getElemento($colunas[4],'input', 'name');
				$listaMatriculas[$count]['Matricula_8'] = substr(getElemento($colunas[0],'div > div', 'text') , 0 , 8);//Matricula com 8 posições
				$count++;
			}
		}
		if(empty($listaMatriculas)){
			return false;
		}else{
			return $listaMatriculas;
		}
	}
	
	
	/**
	 * @method getInfoMatricula
	 * @param string $html
	 * @return array('Nome' , 'Matricula' , 'Documento' , 'Vinculo' , 'Cargo' , 'Data Nascimento' , 'Nome da Mae' , 'Instituicao')
	 * Rotina para buscar detalhes da matricula para gravacao em banco de dados.
	 */
	public static function comtex_getInfoMatricula($html){
		$html = UTIL::RemoveAcentos(utf8_decode($html));
		$tbl = getElemento ( $html, '.tabelaBorda', 'html');
		$td = getElemento ($tbl, 'td', 'text' );
		if(count($td) == 24){
			$info = array(
				'Nome' => trim($td[1]),
				'Matricula' => trim($td[3]),
				'UltimaFolha' => $td[5],
				'CPF' => UTIL::maskField($td[7],"###.###.###-##"),
				'Vinculo' => trim($td[9]),
				'Cargo' => trim($td[11]),
				'Nascimento' => UTIL::formataData($td[13]),
				'NomeMae' => trim($td[17]),
				'Instituicao' =>  trim($td[19]),
				'MargemBruta' => UTIL::formataValor( $td[21] ),
				'MargemDisponivel' => UTIL::formataValor($td[23])
			);
			return $info;
		}else{
			return false;
		}
	}
	
	/**
	 * @method getListaAtiva
	 * @param string $html
	 * Rotina para buscar informações ativas das matriculas ativas para gravacao em banco de dados.
	 */
	public static function comtex_getListaAtiva($html){
		$tbl = getElemento($html, 'div[id=tabelatblLancamentosAtivos:body]', 'html');
		if(!$tbl) {
			$ListaAtiva = array ();
		}else{
			$coluna = getElemento($tbl, 'td', 'text');
			$tr = getElemento($tbl, 'tr', 'html');
			if(count($tr) > 1){
			foreach ($tr as $linha){
				$coluna = getElemento($linha, 'td', 'text');
					$ListaAtiva[] = array (
							'Protocolo' => 	trim($coluna[0]),
							'Tipo' => UTIL::RemoveAcentos(utf8_decode($coluna[1])),
							'dtReserva' => UTIL::formataData( $coluna[2]),
							'dtAverbacao' => UTIL::formataData( $coluna[3]),
							'UsuarioReserva' =>trim( $coluna[4]),
							'UsuarioAverba' => trim($coluna[5]),
							'Evento' => UTIL::RemoveAcentos(utf8_decode($coluna[6])),
							'Complemento' => UTIL::RemoveAcentos(utf8_decode($coluna[7])),
							'NomedoEvento' => UTIL::RemoveAcentos(utf8_decode($coluna[8])),
							'valorReserva' => UTIL::formataValor ( $coluna[9]),
							'valorAverbado' => UTIL::formataValor($coluna[10]),
							'Prazo' =>trim($coluna[11]),
							'Desconto' =>trim( $coluna[12])
					);
				}
			}else{
				$ListaAtiva[] = array (
						'Protocolo' => 	trim($coluna[0]),
						'Tipo' => UTIL::RemoveAcentos(utf8_decode($coluna[1])),
						'dtReserva' => UTIL::formataData ( trim ( $coluna[2])),
						'dtAverbacao' => UTIL::formataData ( trim ( $coluna[3])),
						'UsuarioReserva' => trim($coluna[4]),
						'UsuarioAverba' => trim($coluna[5]),
						'Evento' => UTIL::RemoveAcentos(utf8_decode($coluna[6])),
						'Complemento' => UTIL::RemoveAcentos(utf8_decode($coluna[7])),
						'NomedoEvento' => UTIL::RemoveAcentos(utf8_decode($coluna[8])),
						'valorReserva' => UTIL::formataValor($coluna[9]),
						'valorAverbado' => UTIL::formataValor($coluna[10]),
						'Prazo' => trim($coluna[11]),
						'Desconto' =>trim( $coluna[12])
				);
			}
		}
		return $ListaAtiva;
	}
	
	/**
	 * @method getListaBaixa
	 * @param string $html
	 * Rotina para buscar detalhes das baixas das matriculas para gravacao em banco de dados.
	 */
	public static function comtex_getListaBaixa($html){
		$filtro = getElemento ( $html, '#pnlLancamentosBaixadas', 'html' );
		$tables = getElemento ( $filtro, 'table', 'html' );
		$baixas = array ();
		if (!$tables){
			$linhas = array();
		}else{
			$tbBaixas = $tables [2];
			$linhas = getElemento ( $tbBaixas, 'tr', 'html' );
		}
		foreach ( $linhas as $linha ) {
			$colunas = getElemento ( $linha, 'td', 'text' );
			if (count ( $colunas ) == 15) {
				$baixas [] = array (
						'Protocolo' => trim ( $colunas [0] ),
						'Tipo' => trim ( $colunas [1] ),
						'DtSolicitacao' => UTIL::formataData ( trim ( $colunas [2] )  ) ,
						'DtAutorizcao' => UTIL::formataData ( trim ( $colunas [3] )  ) ,
						'DtBaixa' => UTIL::formataData ( trim ( $colunas [4] ) ) ,
						'UsuarioBaixa' => trim ( $colunas [5] ),
						'UsuarioSolicitacao' => trim ( $colunas [6] ),
						'UsuarioAverbacao' => trim ( $colunas [7] ),
						'Evento' => trim ( $colunas [8] ),
						'Complemento' => trim ( $colunas [9] ),
						'NomeEvento' => trim ( $colunas [10] ),
						'ParcelaSolicitada' => UTIL::formataValor( trim ( $colunas [11] ) ),
						'ParcelaAutorizada' => UTIL::formataValor( trim ( $colunas [12] ) ),
						'QuantidadeParcela' => intval ( trim ( $colunas [13] ) ),
						'ParcelasDescontadas' => intval ( trim ( $colunas [14] ) )
				);
			}
		}
	return $baixas;
	}
}

?>