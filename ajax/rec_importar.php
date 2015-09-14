<?php
require_once '../class/template.class.php';
require_once '../class/dao.class.php';
require_once '../class/util.class.php';
require_once '../class/simplexlsx.class.php';

require_once '../class/tbl_log_importacao.class.php';
require_once '../class/tbl_log_importacao_data.class.php';
require_once '../class/tbl_movimento.class.php';
require_once '../class/funcoes.php';

checkSession();

$dao = new DAO();
$template = new Template();

$idUser = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
$FK_Banco = isset($_POST['FK_Banco']) ? (int) $_POST['FK_Banco'] : false;
$FK_Convenio = isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
$md5 = md5_file($_POST['File']);

$retorno['Error'] = false;
$retorno['Mensagem'] = "";

$dados = array();
//Validando o Arquivo a ser importado.
//Verificando o tipo do arquivo;
if(strtolower(substr(trim($_POST['File']),-4)) == "xlsx"){
	$extensao = "xslx";
	//Formato XLSX - Excel 2010 >
	$reader = new SimpleXLSX($_POST['File']);
	$registros = $reader->rows();
	$contador = 0;
	foreach ($registros as $registro){
		if(strtolower(trim($registro[4])) != "cpf"){
			if(is_numeric( $registro[9]) && is_numeric( $registro[10]) && is_numeric( $registro[11]) && is_numeric( $registro[12])){
				$dados[$contador]['Contrato'] = $registro[3];
				//Tratando CPF;
				if(strlen(trim($registro[4])) < 14){
					//CPF sem formatacao, adicionar.
					$dados[$contador]['CPF'] = UTIL::maskField(str_pad($registro[4],11,'0',STR_PAD_LEFT),"###.###.###-##");
				}else{
					$dados[$contador]['CPF'] = $registro[4];
				}
				$dados[$contador]['Matricula1'] = $registro[5];
				$dados[$contador]['Identificador1'] = $registro[6];
				$dados[$contador]['Matricula2'] = $registro[7];
				$dados[$contador]['Identificador2'] = $registro[8];
				$dados[$contador]['Parcela'] = $registro[9];
				$dados[$contador]['Prazo'] = $registro[10];
				$dados[$contador]['ValorFinanciado'] = $registro[11];
				$dados[$contador]['ValorAtualizado'] = $registro[12];
				$dados[$contador]['Taxa'] = round($registro[13],2);
				$contador++;
			}
		}
	}
}elseif(strtolower(substr(trim($_POST['File']),-3)) == "csv"){
	$linhas = preg_split('/\n/', file_get_contents($_POST['File']));
	if(count($linhas) == 2){
		//Tenta Quebrar com \r
		$linhas = preg_split('/\r/', file_get_contents($_POST['File']));
		if(count($linhas) == 2){
			$linhas = preg_split('/\r\n/', file_get_contents($_POST['File']));
			if(count($linhas) == 2){
				$retorno['Error'] = true;
				$retorno['Mensagem'] = "Erro ao separar arquivo CSV";
				die(json_encode($retorno));
			}
		}
	}
	$contador = 0;
	foreach ($linhas as $linha){
		$registro = preg_split('/;/',$linha);
		if(count($registro) == 14 && strtolower(trim($registro[4])) != "cpf" ){
			if(is_numeric(UTIL::formataValor($registro[9])) && is_numeric(UTIL::formataValor($registro[10])) && is_numeric(UTIL::formataValor($registro[11])) && is_numeric(UTIL::formataValor($registro[12]))){
				$dados[$contador]['Contrato'] = $registro[3];
				//Tratando CPF;
				if(strlen(trim($registro[4])) < 14){
					//CPF sem formatacao, adicionar.
					$dados[$contador]['CPF'] = UTIL::maskField(str_pad($registro[4],11,'0',STR_PAD_LEFT),"###.###.###-##");
				}else{
					$dados[$contador]['CPF'] = $registro[4];
				}
				$dados[$contador]['Matricula1'] = $registro[5];
				$dados[$contador]['Identificador1'] = $registro[6];
				$dados[$contador]['Matricula2'] = $registro[7];
				$dados[$contador]['Identificador2'] = $registro[8];
				$dados[$contador]['Parcela'] = UTIL::formataValor($registro[9]);
				$dados[$contador]['Prazo'] = UTIL::formataValor($registro[10]);
				$dados[$contador]['ValorFinanciado'] = UTIL::formataValor($registro[11]);
				$dados[$contador]['ValorAtualizado'] = UTIL::formataValor($registro[12]);
				$dados[$contador]['Taxa'] = round(UTIL::formataValor($registro[13]),2);
				$contador++;
			}
		}
	}
}else{
	$retorno['Error'] = true;
	$retorno['Mensagem'] = utf8_encode("Layout inválido para operação solicitada.");
	die(json_encode($retorno));
}


$importacao = new Tbl_log_importacao();
$importacao->setDateTimeInsert(date("Y-m-d H:i:s"));
$importacao->setDateTimeUpdate(date("Y-m-d H:i:s"));
$importacao->setFK_User((int) $idUser);
$importacao->setNomeArquivo($_POST['File']);
$importacao->setFK_Convenio((int) $FK_Convenio);
$importacao->setCheckSum($md5);
$importacao = $dao->save($importacao);

if($importacao instanceof Tbl_log_importacao){
	if(copy($_POST['File'], "../csv_rec/".$importacao->getPK_Importacao().".csv" )){
		foreach($dados as $dado){
			try{
				$movimento = new Tbl_log_importacao_data();
				$movimento->setFK_Importacao((int) $importacao->getPK_Importacao());
				$movimento->setDateTimeInsert(date("Y-m-d H:i:s"));
				$movimento->setDateTimeUpdate(date("Y-m-d H:i:s"));
				$movimento->setCPF($dado['CPF']);
				$movimento->setIdentificador1($dado['Identificador1']);
				$movimento->setIdentificador2($dado['Identificador2']);
				$movimento->setMatricula1($dado['Matricula1']);
				$movimento->setMatricula2($dado['Matricula2']);
				$movimento->setNumeroContrato($dado['Contrato']);
				$movimento->setPrazo((int) $dado['Prazo']);
				$movimento->setParcela($dado['Parcela']);
				$movimento->setValorFinanciado($dado['ValorFinanciado']);
				$movimento->setValorInadimplente($dado['ValorAtualizado']);
				$movimento->setTaxaContrato($dado['Taxa']);
				$movimento = $dao->save($movimento);
				if(!$movimento instanceof Tbl_log_importacao_data) die("Erro ao importar");
				//Gravando Registros na tabela de movimento.
				$query = "SELECT * FROM tbl_movimento WHERE CPF ='{$movimento->getCPF()}' AND FK_Convenio = '{$importacao->getFK_Convenio()}' AND NumeroContrato = '{$movimento->getNumeroContrato()}' AND Status <> 'Encerrado'";
				$Lista = $dao->listaFromQuery($query, new Tbl_movimento());
				if(empty($Lista)){
					//Gravando Registros novos
					$mov = new Tbl_movimento();
					$mov->setDateTimeInsert(date("Y-m-d H:i:s"));
					$mov->setDateTimeUpdate(date("Y-m-d H:i:s"));
					$mov->setFK_Banco($FK_Banco);
					$mov->setFK_Convenio((int) $importacao->getFK_Convenio());
					$mov->setFK_ImportacaoData((int) $movimento->getPK_ImportacaoData());
					$mov->setCPF($movimento->getCPF());
					$mov->setNumeroContrato($movimento->getNumeroContrato());
					$mov->setIdentificador1($movimento->getIdentificador1());
					$mov->setIdentificador2($movimento->getIdentificador2());
					$mov->setMatricula1($movimento->getMatricula1());
					$mov->setMatricula2($movimento->getMatricula2());
					$mov->setParcela($movimento->getParcela());
					$mov->setPrazo($movimento->getPrazo());
					$mov->setValorFinanciado($movimento->getValorFinanciado());
					$mov->setValorInadimplente($movimento->getValorInadimplente());
					$mov->setValorInadimplenteAtual($movimento->getValorInadimplente());
					$mov->setStatus('Consulta');
					$mov->setFK_MovimentoPai(null);
					$dao->save($mov);
				}elseif(count($Lista) == 1){
					$update = $Lista[0];
					$update instanceof Tbl_movimento;
					if($update->getStatus() == 'Consulta' || $update->getStatus() == 'Inativo' || $update->getStatus() == 'Invalido'){
						$update->setDateTimeUpdate(date("Y-m-d H:i:s"));
						$update->setValorFinanciado($movimento->getValorFinanciado());
						$update->setValorInadimplente($movimento->getValorInadimplente());
						$update->setValorInadimplenteAtual($movimento->getValorInadimplente());
						$update->setMatricula1($movimento->getMatricula1());
						$update->setMatricula2($movimento->getMatricula2());
						$update->setTaxaContrato($movimento->getTaxaContrato());
						$update->setPrazo($movimento->getPrazo());
						$update->setParcela($movimento->getParcela());
						$update->setFK_ImportacaoData($movimento->getPK_ImportacaoData());
						$update->setStatus('Consulta');
						$dao->save($update);
					}else{
						$retorno['Error'] = true;
						$retorno['Mensagem'] = utf8_encode('Sem acao - Importacao: '.$movimento->getPK_ImportacaoData(). ' do movimento: '.$update->getPK_Movimento(). ' com status '.$update->getStatus());
						die(json_encode($retorno));
					}
				}else{
					$retorno['Error'] = true;
					$retorno['Mensagem'] = utf8_encode('Erro nao previsto');
					die(json_encode($retorno));
				}
			}catch(Exception $e){
				$retorno['Error'] = true;
				$retorno['Mensagem'] = utf8_encode($e->getTraceAsString());
				die(json_encode($retorno));
			}
		}
		unlink($_POST['File']);
	}else{
		$retorno['Error'] = true;
		$retorno['Mensagem'] = utf8_encode("Erro ao mover arquivo temporário para área de destino, verificar permissões.");
		die(json_encode($retorno));
	}
}


die(json_encode($retorno));
?>