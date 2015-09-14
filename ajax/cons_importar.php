<?php
require_once '../class/template.class.php';
require_once '../class/dao.class.php';
require_once '../class/util.class.php';
require_once '../class/simplexlsx.class.php';

require_once '../class/tbl_cons_importacao.class.php';
require_once '../class/tbl_cons_importacaodata.class.php';
require_once '../class/tbl_cons_movimento.class.php';
require_once '../class/tbl_cons_log.class.php';
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
		if(strtolower(trim($registro[0])) != "cpf" && trim($registro[0]) != ""){
			if(strlen(trim($registro[0])) < 14){
				//CPF sem formatacao, adicionar.
				$dados[$contador]['CPF'] = UTIL::maskField(str_pad($registro[0],11,'0',STR_PAD_LEFT),"###.###.###-##");
			}else{
				$dados[$contador]['CPF'] = substr($registro[0],0,14);
			}
			
			if(trim($registro[1]) != "" ){
				$dados[$contador]['Matricula'] = $registro[1];
			}else{
				$dados[$contador]['Matricula'] = "";
			}
			
			if(isset($registro[2])){
				$dados[$contador]['ValorParcela'] =  round($registro[2] , 2);
			}
			
			if(isset($registro[3])){
				$dados[$contador]['UsuarioServidor'] = $registro[3];
			}else{
				$dados[$contador]['UsuarioServidor'] = "";
			}
			
			if(isset($registro[4])){
				$dados[$contador]['SenhaServidor'] = $registro[4];
			}else{
				$dados[$contador]['SenhaServidor'] = "";
			}
			$contador++;
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
		if(strtolower(trim($registro[0])) != "cpf" && trim($registro[0]) != ""){
				//Tratando CPF;
			if(strlen(trim($registro[0])) < 14){
				//CPF sem formatacao, adicionar.
				$dados[$contador]['CPF'] = UTIL::maskField(str_pad($registro[0],11,'0',STR_PAD_LEFT),"###.###.###-##");
			}else{
				$dados[$contador]['CPF'] = substr($registro[0],0,14);
			}
			
			if(trim($registro[1]) != "" ){
				$dados[$contador]['Matricula'] = $registro[1];
			}else{
				$dados[$contador]['Matricula'] = "";
			}
			
			if(isset($registro[2])){
				$dados[$contador]['ValorParcela'] = round($registro[2],2);
			}
			
			if(isset($registro[3])){
				$dados[$contador]['UsuarioServidor'] = $registro[3];
			}else{
				$dados[$contador]['UsuarioServidor'] = "";
			}
			
			if(isset($registro[4])){
				$dados[$contador]['SenhaServidor'] = $registro[4];
			}else{
				$dados[$contador]['SenhaServidor'] = "";
			}
			$contador++;
		}
	}
}else{
	$retorno['Error'] = true;
	$retorno['Mensagem'] = utf8_encode("Layout inválido para operação solicitada.");
	die(json_encode($retorno));
}

$importacao = new Tbl_cons_importacao();
$importacao->setFK_Banco($FK_Banco);
$importacao->setDateTimeInsert(date("Y-m-d H:i:s"));
$importacao->setFK_User((int) $idUser);
$importacao->setNomeArquivo($_POST['File']);
$importacao->setFK_Convenio((int) $FK_Convenio);
$importacao->setCheckSum($md5);
$importacao = $dao->save($importacao);

$consLog = new Tbl_cons_log();
$consLog->setFK_Convenio((int)$FK_Convenio);
$consLog->setDateTimeInsert(date("Y-m-d H:i:s"));
$consLog->setMensagem("Inclusao de arquivo para consulta de margem");
$consLog = $dao->save($consLog);

if($importacao instanceof Tbl_cons_importacao){
	if(copy($_POST['File'], "../csv/".$importacao->getPK_Importacao().".csv")){
		foreach($dados as $dado){
			try{

				$movimento = new Tbl_cons_importacaodata();
				$movimento->setFK_Importacao((int) $importacao->getPK_Importacao());
				$movimento->setDateTimeInsert(date("Y-m-d H:i:s"));
				$movimento->setCPF($dado['CPF']);
				$movimento->setMatricula($dado['Matricula']);
				$movimento->setValorParcela($dado['ValorParcela']);
				$movimento->setUsuarioServidor($dado['UsuarioServidor']);
				$movimento->setSenhaServidor($dado['SenhaServidor']);
				$movimento = $dao->save($movimento);
				if(!$movimento instanceof Tbl_cons_importacaodata) die("Erro ao importar");
				//Gravando Registros na tabela de movimento.
					//Gravando Registros novos
					$mov = new Tbl_cons_movimento();
					$mov->setDateTimeInsert(date("Y-m-d H:i:s"));
					$mov->setDateTimeUpdate(date("Y-m-d H:i:s"));
					$mov->setFK_Convenio((int) $importacao->getFK_Convenio());
					$mov->setFK_ImportacaoData((int) $movimento->getPK_ImportacaoData());
					$mov->setCPF($movimento->getCPF());
					$mov->setNumeroMatricula($movimento->getMatricula());
					$mov->setValorParcela($dado['ValorParcela']);
					$mov->setUsuarioServidor($movimento->getUsuarioServidor());
					$mov->setSenhaServidor($movimento->getSenhaServidor());
					$mov->setStatus('Consulta');
					$dao->save($mov);
			}catch(Exception $e){
				die($e->getTraceAsString() );
			}
		}
		//Arquivo para execucao Batch.
		//$filename = date("YmdHis.exec");
		
		//Achar Processo.
		$processo = $dao->loadByQuery("SELECT PROCESSO FROM tbl_convenio WHERE PK_Convenio = '".$importacao->getFK_Convenio()."'", new stdClass());
		if($processo){
			$command = 'lynx "https://www.sysconsigna.com.br/processo/'.$processo->PROCESSO.'?Lote='.$movimento->getFK_Importacao().'"';
			exec($command);
		}
		unlink($_POST['File']);
	}else{
		$retorno['Error'] = true;
		$retorno['Mensagem'] = utf8_encode("Erro ao mover arquivo ".$_POST['File']);
		die(json_encode($retorno));
	}
}

die(json_encode($retorno));
?>