<?php
require_once '../class/template.class.php';
require_once '../class/dao.class.php';
require_once '../class/util.class.php';
require_once '../class/simplexlsx.class.php';
require_once '../class/funcoes.php';
require_once '../class/tbl_averb_log.class.php';
require_once '../class/tbl_averb_importacao.class.php';
require_once '../class/tbl_averb_importacao_data.class.php';
require_once '../class/tbl_averb_movimento.class.php';

checkSession();

$dao = new DAO();
$template = new Template();

$idUser = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : null;
$FK_Banco = isset($_POST['FK_Banco']) ? (int) $_POST['FK_Banco'] : false;
$FK_Convenio = isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
$md5 = md5_file($_POST['File']);

$dados = array();
$extensao = "csv";
//Validando o Arquivo a ser importado.
//Verificando o tipo do arquivo;
if(strtolower(substr(trim($_POST['File']),-4)) == "xlsx"){
	$extensao = "xslx";
	//Formato XLSX - Excel 2010 >
	$reader = new SimpleXLSX($_POST['File']);
	$registros = $reader->rows();
	$contador = 0;
	foreach ($registros as $registro){
		if(strtolower(trim($registro[0])) != "cpf"){
			if(is_numeric( $registro[3]) && is_numeric( $registro[4]) && is_numeric( $registro[5])){
				$dados[$contador]['Contrato'] = $registro[2];
				//Tratando CPF;
				if(strlen(trim($registro[0])) < 14){
					//CPF sem formatacao, adicionar.
					$dados[$contador]['CPF'] = UTIL::maskField(str_pad($registro[0],11,'0',STR_PAD_LEFT),"###.###.###-##");
				}else{
					$dados[$contador]['CPF'] = $registro[0];
				}
				$dados[$contador]['Matricula'] = str_pad($registro[1],8,'0',STR_PAD_LEFT);
				$dados[$contador]['Parcela'] = $registro[3];
				$dados[$contador]['Prazo'] = $registro[4];
				$dados[$contador]['Total'] = $registro[5];
				$dados[$contador]['Juros'] = $registro[6];
				$dados[$contador]['IOF'] = $registro[7];
				$dados[$contador]['Extra'] = $registro[8];
				$dados[$contador]['Repasse'] = $registro[9];
				
				$dados[$contador]['Banco'] = $registro[10];
				$dados[$contador]['Agencia'] = $registro[11];
				$dados[$contador]['Conta'] = $registro[12];
				
				$dados[$contador]['UsuarioServidor'] = $registro[13];
				$dados[$contador]['SenhaServidor'] = $registro[14];
				
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
				die('Erro ao separar arquivo CSV');
			}
		}
	}
	$contador = 0;
	foreach ($linhas as $linha){
		$registro = preg_split('/;/',$linha);
		if(strtolower(trim($registro[0])) != "cpf"){
			if(is_numeric(UTIL::formataValor($registro[3])) && is_numeric( UTIL::formataValor($registro[4])) && is_numeric(UTIL::formataValor($registro[5])) && is_numeric(UTIL::formataValor($registro[6]))){
				$dados[$contador]['Contrato'] = $registro[2];
				//Tratando CPF;
				if(strlen(trim($registro[0])) < 14){
					//CPF sem formatacao, adicionar.
					$dados[$contador]['CPF'] = UTIL::maskField(str_pad($registro[0],11,'0',STR_PAD_LEFT),"###.###.###-##");
				}else{
					$dados[$contador]['CPF'] = $registro[0];
				}
				$dados[$contador]['Matricula'] = str_pad($registro[1],8,'0',STR_PAD_LEFT);
				$dados[$contador]['Parcela'] = UTIL::formataValor($registro[3]);
				$dados[$contador]['Prazo'] = UTIL::formataValor($registro[4]);
				$dados[$contador]['Total'] = UTIL::formataValor($registro[5]);
				$dados[$contador]['Juros'] = UTIL::formataValor($registro[6]);
				$dados[$contador]['IOF'] = UTIL::formataValor($registro[7]);
				$dados[$contador]['Extra'] = UTIL::formataValor($registro[8]);
				$dados[$contador]['Repasse'] = UTIL::formataValor($registro[9]);
				
				$dados[$contador]['Banco'] = $registro[10];
				$dados[$contador]['Agencia'] = $registro[11];
				$dados[$contador]['Conta'] = $registro[12];
				
				$dados[$contador]['UsuarioServidor'] = $registro[13];
				$dados[$contador]['SenhaServidor'] = $registro[14];
				$contador++;
			}
		}
	}
}else{
	die("Arquivo não previsto para importação.");
}


$importacao = new Tbl_averb_importacao();
$importacao->setDateTimeInsert(date("Y-m-d H:i:s"));
$importacao->setDateTimeUpdate(date("Y-m-d H:i:s"));
$importacao->setFK_User((int) $idUser);
$importacao->setNomeArquivo($_POST['File']);
$importacao->setFK_Convenio((int) $FK_Convenio);
$importacao->setCheckSum($md5);
$importacao = $dao->save($importacao);


//if($importacao instanceof Tbl_averb_importacao){
	if(copy($_POST['File'], "../csv_averb/". $importacao->getPK_Importacao().".$extensao" )){
		
		try{
			$averbLog = new Tbl_averb_log();
			$averbLog->setFK_Movimento(1);
			$averbLog->setFK_Convenio((int) $FK_Convenio);
			$averbLog->setDateTimeInsert(date("Y-m-d H:i:s"));
			$averbLog->setCPF('');
			$averbLog->setMatricula('');
			$averbLog->setMensagem("Inclusao de averbacao em Lote PK_Importacao ".$importacao->getPK_Importacao(). " Usuario ".$idUser  );
			$dao->save($averbLog);
		}catch (Exception $e){
			die($e->getTraceAsString() );
		}
		
		foreach($dados as $dado){
			try{
				$movimento = new tbl_averb_importacao_data();
				$movimento->setFK_Importacao((int) $importacao->getPK_Importacao());
				$movimento->setDateTimeInsert(date("Y-m-d H:i:s"));
				$movimento->setDateTimeUpdate(date("Y-m-d H:i:s"));
				$movimento->setCPF($dado['CPF']);
				$movimento->setMatricula1($dado['Matricula']);
				$movimento->setNumeroContrato($dado['Contrato']);
				$movimento->setPrazo((int) $dado['Prazo']);
				$movimento->setParcela($dado['Parcela']);
				$movimento->setValorFinanciado($dado['Total']);
				$movimento->setValorInadimplente($dado['Total']);
				$movimento->setTaxaContrato($dado['Juros']);
				$movimento->setValorExtra($dado['Extra']);
				$movimento->setIOF($dado['IOF']);
				$movimento->setValorRepasse($dado['Repasse']);
				$movimento->setCodigoBanco($dado['Banco']);
				$movimento->setCodigoAgencia($dado['Agencia']);
				$movimento->setContaCorrente($dado['Conta']);
				$movimento->setUsuarioServidor($dado['UsuarioServidor']);
				$movimento->setSenhaServidor($dado['SenhaServidor']);
				$movimento = $dao->save($movimento);
				if(!$movimento instanceof tbl_averb_importacao_data) die("Erro ao importar");
				//Gravando Registros na tabela de movimento.
				$query = $query = "SELECT * FROM tbl_averb_movimento WHERE CPF = '{$movimento->getCPF()}' AND NumeroMatricula = '{$movimento->getMatricula1()}' AND NumeroContrato = '{$movimento->getNumeroContrato()}' AND (Status = 'Averbado' OR Status = 'Parcial' OR Status = 'Consulta') ";
				$Lista = $dao->listaFromQuery($query, new Tbl_averb_movimento());
				if(empty($Lista)){
					//Gravando Registros novos
					$mov = new tbl_averb_movimento();
					$mov->setDateTimeInsert(date("Y-m-d H:i:s"));
					$mov->setDateTimeUpdate(date("Y-m-d H:i:s"));
					$mov->setFK_Banco($FK_Banco);
					$mov->setFK_Convenio((int) $importacao->getFK_Convenio());
					$mov->setFK_ImportacaoData((int) $movimento->getPK_ImportacaoData());
					$mov->setCPF($movimento->getCPF());
					$mov->setFator(0);
					$mov->setIOF($movimento->getIOF());
					$mov->setNumeroContrato($movimento->getNumeroContrato());
					$mov->setNumeroMatricula($movimento->getMatricula1());
					$mov->setParcelas($movimento->getPrazo());
					$mov->setValorParcela($movimento->getParcela());
					$mov->setValorTotalExtra($movimento->getValorExtra());
					$mov->setValorParcelaPendente($movimento->getParcela());
					$mov->setValorSolicitado($movimento->getValorFinanciado());
					$mov->setValorSolicitadoPendente($movimento->getValorFinanciado());
					$mov->setTaxaJuros($movimento->getTaxaContrato());
					$mov->setValorRepasse($movimento->getValorRepasse());
					$mov->setCodigoBanco($movimento->getCodigoBanco());
					$mov->setCodigoAgencia($movimento->getCodigoAgencia());
					$mov->setContaCorrente($movimento->getContaCorrente());
					$mov->setUsuarioServidor($movimento->getUsuarioServidor());
					$mov->setSenhaServidor($movimento->getSenhaServidor());
					$mov->setStatus('Consulta');
					$dao->save($mov);
					
				}
			}catch(Exception $e){
				echo $e->getMessage()."<br>\n";
				var_dump($mov);
				die($e->getTraceAsString() );
			}
		}
	}else{
		die("Erro ao mover arquivo temporário para área de destino, verificar permissões.");
	}
//}
?>