<?php
require_once '../class/dao.class.php';
require_once '../class/tbl_user.class.php';
require_once '../class/funcoes.php';

////Verifica a conexão ativa
checkSession();

$dao = new DAO();

$tbl = isset($_GET['Table']) ? $_GET['Table'] : false;
$pk_user = isset($_COOKIE['userData']) ? $_COOKIE['userData'] : false;
$user = $dao->loadByQuery("SELECT * FROM tbl_user WHERE PK_User = '$pk_user'", new Tbl_user());

$UserBancos = null;
if(!$user instanceof Tbl_user)	die(json_encode(false));
if(!$user->getAdmin() && !$user->getRoot()){
	$UserBancos = $dao->listaFromQuery("SELECT * FROM tbl_user_banco WHERE FK_User = '$pk_user'", new stdClass());
	$_bancos  = array();
	foreach($UserBancos as $banco){
		$_bancos[] = $banco->FK_Banco;
	} 
}
	
if($tbl == "cliente"){
	//Variaveis De Filtro
	$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$Vinculo =  isset($_POST['Vinculo']) ? $_POST['Vinculo'] : false;
	$Instituicao =  isset($_POST['Instituicao']) ? $_POST['Instituicao'] : false;
	$CPF =  isset($_POST['CPF']) ? $_POST['CPF'] : false;
	$NumeroMatricula =  isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
	$MargemMin =  isset($_POST['MargemMin']) ? $_POST['MargemMin'] : false;
	$Ativo =  isset($_POST['Ativo']) ? true : false;
	$MargemMax =  isset($_POST['MargemMax']) ? $_POST['MargemMax'] : false;
	$query = "SELECT IFNULL(DATE_FORMAT(b.DateTimeUpdate,'%d/%m/%Y %H:%i:%s'),DATE_FORMAT(NOW(),'%d/%m/%Y %H:%i:%s')) AS DtAtualiza, 
	a.CPF, a.Nome, IFNULL(b.NumeroMatricula,'') AS NumeroMatricula, UltimoMovimento, FORMAT(MargemDisponivel,2,'pt_BR') AS FormatMargemDisponivel, 
	IFNULL(Instituicao,'-') AS Instituicao,	IFNULL(DATE_FORMAT(DataNascimento,'%d/%m/%Y'),'') AS DataNascimento, 
	IFNULL(Cargo,'-') AS Cargo, IFNULL(Vinculo,'-') AS Vinculo
	FROM tbl_cada_cliente a
	LEFT JOIN tbl_cliente_matricula b ON a.PK_Cada_Cliente = b.FK_Cliente 
	LEFT JOIN tbl_convenio c ON c.PK_Convenio = a.FK_Convenio WHERE 1=1 ";
	//Fazendo os Filtros na Consulta
	if($FK_Banco) $query .= "AND c.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($Vinculo) $query .= "AND b.Vinculo = '{$Vinculo}' ";
	if($Instituicao) $query .= "AND b.Instituicao = '{$Instituicao}' ";
	if($MargemMin) $query .= "AND MargemDisponivel >= '".numberFormat($MargemMin)."' ";
	if($MargemMax) $query .= "AND MargemDisponivel <= '".numberFormat($MargemMax)."' ";
	if($CPF) $query .= "AND a.CPF LIKE '%$CPF%' ";
	if($NumeroMatricula) $query .= "AND b.NumeroMatricula LIKE '%$NumeroMatricula%' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( c.FK_Banco = '".implode("' OR c.FK_Banco = '", $_bancos)."' )";
	}
	$query.= " ORDER BY b.DateTimeUpdate DESC";
}elseif($tbl == "averb_todos"){
	$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$CPF =  isset($_POST['CPF']) ? $_POST['CPF'] : false;
	$NumeroMatricula =  isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
	$query = "SELECT a.PK_Movimento, DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%y %H:%i') AS DtAtualizado, a.CPF, 
	IFNULL(b.Nome,'-') AS Nome, a.NumeroMatricula, a.NumeroContrato,
	FORMAT(a.ValorParcela,2,'pt_BR') AS ValorParcela, 
	a.Parcelas, 
	FORMAT(IFNULL(c.ValorParcela,0),2,'pt_BR') As ParcelaRealizada,
	IF(a.Status='Parcial' OR a.Status='Consulta',
	DATE_FORMAT(DATE_ADD(DATE(a.DateTimeInsert), INTERVAL d.DiasRecorrencia DAY),'%d/%m/%y'),
	'-') AS DataFinal,
	a.Status
	FROM tbl_averb_movimento a
	LEFT JOIN tbl_cada_cliente b ON a.CPF = b.CPF AND a.FK_Convenio = b.FK_Convenio
	LEFT JOIN tbl_averb_averbado c ON c.FK_Movimento = a.PK_Movimento AND c.Status = 'Ativo'
	LEFT JOIN tbl_convenio d ON d.PK_Convenio = a.FK_Convenio
	WHERE 1=1 ";
	//Fazendo os Filtros na Consulta
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($CPF) $query .= "AND a.CPF LIKE '%$CPF%' ";
	if($NumeroMatricula) $query .= "AND a.NumeroMatricula LIKE '%$NumeroMatricula%' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' OR a.FK_Banco = '", $_bancos)."' )";
	}
	$query.= " ORDER BY b.DateTimeUpdate DESC";
}elseif($tbl == "averb_concluidos"){
	$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$CPF =  isset($_POST['CPF']) ? $_POST['CPF'] : false;
	$NumeroMatricula =  isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
	$query = "SELECT a.PK_Movimento, DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%y %H:%i') AS DtAtualizado, a.CPF, 
	IFNULL(b.Nome,'-') AS Nome, a.NumeroMatricula, a.NumeroContrato,
	FORMAT(a.ValorParcela,2,'pt_BR') AS ValorParcela, 
	a.Parcelas, 
	FORMAT(IFNULL(c.ValorParcela,0),2,'pt_BR') As ParcelaRealizada,
	IF(a.Status='Parcial' OR a.Status='Consulta',
	DATE_FORMAT(DATE_ADD(DATE(a.DateTimeInsert), INTERVAL d.DiasRecorrencia DAY),'%d/%m/%y'),
	'-') AS DataFinal,
	a.Status
	FROM tbl_averb_movimento a
	LEFT JOIN tbl_cada_cliente b ON a.CPF = b.CPF AND a.FK_Convenio = b.FK_Convenio
	LEFT JOIN tbl_averb_averbado c ON c.FK_Movimento = a.PK_Movimento AND c.Status = 'Ativo'
	LEFT JOIN tbl_convenio d ON d.PK_Convenio = a.FK_Convenio 
	WHERE (a.Status = 'Averbado' OR a.Status = 'Encerrado') ";
	//Fazendo os Filtros na Consulta
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($CPF) $query .= "AND a.CPF LIKE '%$CPF%' ";
	if($NumeroMatricula) $query .= "AND a.NumeroMatricula LIKE '%$NumeroMatricula%' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' OR a.FK_Banco = '", $_bancos)."' )";
	}
	$query.= " ORDER BY b.DateTimeUpdate DESC";
}elseif($tbl == "averb_recorrencia"){
	$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$CPF =  isset($_POST['CPF']) ? $_POST['CPF'] : false;
	$NumeroMatricula =  isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
	$query = "SELECT a.PK_Movimento, DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%y %H:%i') AS DtAtualizado, a.CPF, 
	IFNULL(b.Nome,'-') AS Nome, a.NumeroMatricula, a.NumeroContrato,
	FORMAT(a.ValorParcela,2,'pt_BR') AS ValorParcela, 
	a.Parcelas, 
	FORMAT(IFNULL(c.ValorParcela,0),2,'pt_BR') As ParcelaRealizada,
	IF(a.Status='Parcial' OR a.Status='Consulta',
	DATE_FORMAT(DATE_ADD(DATE(a.DateTimeInsert), INTERVAL d.DiasRecorrencia DAY),'%d/%m/%y'),
	'-') AS DataFinal,
	a.Status
	FROM tbl_averb_movimento a
	LEFT JOIN tbl_cada_cliente b ON a.CPF = b.CPF AND a.FK_Convenio = b.FK_Convenio
	LEFT JOIN tbl_averb_averbado c ON c.FK_Movimento = a.PK_Movimento AND c.Status = 'Ativo'
	LEFT JOIN tbl_convenio d ON d.PK_Convenio = a.FK_Convenio
	WHERE (a.Status = 'Consulta' OR a.Status = 'Parcial') ";
	//Fazendo os Filtros na Consulta
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($CPF) $query .= "AND a.CPF LIKE '%$CPF%' ";
	if($NumeroMatricula) $query .= "AND a.NumeroMatricula LIKE '%$NumeroMatricula%' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' OR a.FK_Banco = '", $_bancos)."' )";
	}
	$query.= " ORDER BY b.DateTimeUpdate DESC";
}elseif($tbl == "cartao_cliente"){
	$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$CPF =  isset($_POST['CPF']) ? $_POST['CPF'] : false;
	$NumeroMatricula =  isset($_POST['Matricula']) ? $_POST['Matricula'] : false;
	$query = "SELECT a.PK_Movimento, DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i') AS DtAtualizado, a.CPF, 
	IFNULL(b.Nome ,'-') AS Nome, a.NumeroMatricula, a.NumeroContrato,
	FORMAT(a.ValorSolicitado,2,'pt_BR') AS ValorSolicitado, 
	a.Status
	FROM tbl_cartao_movimento a
	LEFT JOIN tbl_cada_cliente b ON a.CPF = b.CPF AND a.FK_Convenio = b.FK_Convenio
	WHERE 1=1 ";
	//Fazendo os Filtros na Consulta
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($CPF) $query .= "AND a.CPF LIKE '%$CPF%' ";
	if($NumeroMatricula) $query .= "AND a.NumeroMatricula LIKE '%$NumeroMatricula%' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' OR a.FK_Banco = '", $_bancos)."' )";
	}
	$query.= " ORDER BY b.DateTimeUpdate DESC";
}elseif($tbl == "cpf_recorrencia"){
	//Variaveis De Filtro
	$Filtro =  isset($_POST['Condicao']) ? $_POST['Condicao'] : false;
	$query = "SELECT DATE_FORMAT(a.DateTimeInsert,'%d/%m/%Y %H:%i:%s') AS DtProcesso, b.CPF,
	b.Nome as Cliente, a.NumeroMatricula, FORMAT(a.MargemDisponivel,2,'pt_BR') AS Margem
	FROM tbl_log_cliente_matricula a
	LEFT JOIN tbl_cada_cliente b ON b.PK_Cada_Cliente = a.FK_Cliente
	LEFT JOIN tbl_convenio c ON c.PK_Convenio = b.FK_Convenio
	WHERE 1=1 ";
	if($Filtro) $query .= "AND b.CPF = '$Filtro' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( c.FK_Banco = '".implode("' OR c.FK_Banco = '", $_bancos)."' )";
	}
	
	$query.= "ORDER BY a.DateTimeInsert DESC";
}elseif($tbl == "matricula_recorrencia"){
	//Variaveis De Filtro
	$Filtro =  isset($_POST['Condicao']) ? $_POST['Condicao'] : false;
	$query = "SELECT DATE_FORMAT(a.DateTimeInsert,'%d/%m/%Y %H:%i:%s') AS DtProcesso, a.CPF,
	b.Nome as Cliente, a.NumeroMatricula, FORMAT(a.MargemDisponivel,2,'pt_BR') AS Margem
	FROM tbl_log_cliente_matricula a
	LEFT JOIN tbl_cada_cliente b ON b.PK_Cada_Cliente = a.FK_Cliente
	LEFT JOIN tbl_convenio c ON c.PK_Convenio = b.FK_Convenio
	WHERE 1=1 ";
	//Fazendo os Filtros na Consulta
	if($Filtro) $query .= "AND (a.NumeroMatricula = LEFT('$Filtro',8) OR a.NumeroMatricula = '$Filtro' )";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( c.FK_Banco = '".implode("' OR c.FK_Banco = '", $_bancos)."' )";
	}
	$query.= "ORDER BY a.DateTimeInsert DESC";
}elseif($tbl == "movimento"){
	$FK_Banco = isset($_POST['searchFK_Banco']) ? $_POST['searchFK_Banco'] : false;
	$FK_Convenio =  isset($_POST['searchFK_Convenio']) ? $_POST['searchFK_Convenio'] : false;
	
	$CPF =  isset($_POST['searchCPF']) ? $_POST['searchCPF'] : false;
	$NumeroContrato =  isset($_POST['searchContrato']) ? $_POST['searchContrato'] : false;
	$query = "SELECT PK_Movimento, DATE_FORMAT(DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS Atualizacao, CPF, NumeroContrato, FORMAT(Parcela,2,'pt_BR') AS ValorParcela,
	FORMAT(ValorFinanciado,2,'pt_BR') AS ValorFinanciado, FORMAT(ValorInadimplente,2,'pt_BR') AS ValorInadimplente, FORMAT(ValorInadimplenteAtual,2,'pt_BR') AS TotalAtual,	Prazo
	FROM tbl_movimento WHERE (Status <> 'Encerrado' AND Status <> 'Baixa') ";
	if($FK_Banco) $query.= "AND FK_Banco = '$FK_Banco' ";
	if($FK_Convenio) $query.= "AND FK_Convenio = '$FK_Convenio' ";
	if($CPF) $query.= "AND CPF LIKE '%$CPF%' ";
	if($NumeroContrato) $query.= "AND NumeroContrato LIKE '%$NumeroContrato%' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( FK_Banco = '".implode("' OR FK_Banco = '", $_bancos)."' )";
	}
	$query.= "ORDER BY DateTimeUpdate DESC ";
}elseif($tbl == "usuario_convenio"){
	$FK_Convenio =  isset($_POST['FiltroConvenio']) ? $_POST['FiltroConvenio'] : false;
	$query = "SELECT * FROM tbl_convenio_usuario WHERE 1=1 ";
	if($FK_Convenio) $query.= "AND FK_Convenio = '$FK_Convenio' ";
	if($user->getAdmin() == 0 && $user->getRoot() == 0){
		$query .= "AND FK_Convenio = '{$user->getFK_Convenio()}' ";
	}
}elseif($tbl == "parametro_convenio"){
	$FK_Convenio =  isset($_POST['FiltroConvenio']) ? $_POST['FiltroConvenio'] : false;
	$query = "SELECT * FROM tbl_convenio_parametro WHERE 1=1 ";
	if($FK_Convenio) $query.= "AND FK_Convenio = '$FK_Convenio' ";
	if($user->getAdmin() == 0 && $user->getRoot() == 0){
		$query .= "AND FK_Convenio = '{$user->getFK_Convenio()}' ";
	}
}elseif($tbl == "cons_hist"){
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$dtInicio = (isset($_POST['dtInicio']) ? strtotime(str_replace("/", "-", $_POST['dtInicio'])) : false);
	$dtFinal = (isset($_POST['dtFinal']) ? strtotime(str_replace("/", "-", $_POST['dtFinal'])) : false);
	
	$query = "SELECT a.PK_Movimento, DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i') AS DtAtualizado, a.CPF, 
	IFNULL(b.Nome ,'-') AS Nome, IFNULL(c.NumeroMatricula , a.NumeroMatricula ) AS Matricula,
	IFNULL(FORMAT(e.Margem,2,'pt_BR'),'-') AS MargemDisponivel , a.ValorParcela, IFNULL(e.Mensagem, '-') AS Mensagem,  d.FK_Orgao
	FROM tbl_cons_movimento a
	LEFT JOIN tbl_cada_cliente b ON a.CPF = b.CPF AND a.FK_Convenio = b.FK_Convenio
    LEFT JOIN tbl_cliente_matricula c ON c.FK_Cliente = b.PK_Cada_Cliente 
    LEFT JOIN tbl_convenio d ON a.FK_Convenio = d.PK_Convenio
	LEFT JOIN tbl_cons_log e ON e.FK_Cliente = b.PK_Cada_Cliente AND e.FK_Movimento = a.PK_Movimento AND e.FK_ClienteMatricula = c.PK_Cliente_Matricula
    WHERE 1=1 ";
	//Fazendo os Filtros na Consulta
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."' ";
	if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( d.FK_Banco = '".implode("' OR d.FK_Banco = '", $_bancos)."' )";
	}
	$query.= " ORDER BY a.DateTimeUpdate DESC";
}elseif($tbl == "cons_importacao"){
	$Filtro =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$query = "SELECT DATE_FORMAT(a.DateTimeInsert,'%d/%m/%y %H:%i') AS DataImportacao, 
	b.Nome AS Convenio, PK_Importacao, NomeArquivo, CheckSum, c.Nome AS Usuario,
	CONCAT(PK_Importacao,'.',SUBSTRING_INDEX('csv','.',-1)) AS Arquivo,
	(SELECT COUNT(*) FROM tbl_cons_importacaodata WHERE FK_Importacao = PK_Importacao) AS Registros
	FROM tbl_cons_importacao a
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_user c ON c.PK_User = a.FK_User WHERE 1=1 ";
	if($Filtro) $query .= "AND a.FK_Convenio = '$Filtro'";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( b.FK_Banco = '".implode("' OR b.FK_Banco = '", $_bancos)."' )";
	}
	$rows = $dao->listaFromQuery($query, new stdClass());
	foreach ($rows as $row){
		$row->Status = false;
		if (is_file('../csv/consulta_margem_'.$row->PK_Importacao.'.csv')){
			$row->Status = true;
		}
	}
	die(json_encode($rows));
}elseif($tbl == "rec_importacao"){
	$Filtro =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$query = "SELECT DATE_FORMAT(a.DateTimeInsert,'%d/%m/%y %H:%i') AS DataImportacao, 
	b.Nome AS Convenio, PK_Importacao, NomeArquivo, CheckSum, c.Nome AS Usuario,
	CONCAT(PK_Importacao,'.',SUBSTRING_INDEX(NomeArquivo,'.',-1)) AS Arquivo,
	(SELECT COUNT(*) FROM tbl_log_importacao_data WHERE FK_Importacao = PK_Importacao) AS Registros
	FROM tbl_log_importacao a
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_user c ON c.PK_User = a.FK_User WHERE 1=1 ";
	if($Filtro) $query .= "AND a.FK_Convenio = '$Filtro'";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( b.FK_Banco = '".implode("' OR b.FK_Banco = '", $_bancos)."' )";
	}
}elseif($tbl == "averb_importacao"){
	$Filtro =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$query = "SELECT DATE_FORMAT(a.DateTimeInsert,'%d/%m/%y %H:%i') AS DataImportacao, 
	b.Nome AS Convenio, PK_Importacao, NomeArquivo, CheckSum, c.Nome AS Usuario,
	CONCAT(PK_Importacao,'.',SUBSTRING_INDEX(NomeArquivo,'.',-1)) AS Arquivo,
	(SELECT COUNT(*) FROM tbl_averb_importacao_data WHERE FK_Importacao = PK_Importacao) AS Registros
	FROM tbl_averb_importacao a
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_user c ON c.PK_User = a.FK_User WHERE 1=1 ";
	if($Filtro) $query .= "AND a.FK_Convenio = '$Filtro'";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( b.FK_Banco = '".implode("' OR b.FK_Banco = '", $_bancos)."' )";
	}
}elseif($tbl == "averb_log"){
	$Filtro =  isset($_POST['Condicao']) ? $_POST['Condicao'] : false;
	$query = "SELECT DATE_FORMAT(DateTimeInsert,'%d/%m/%y %H:%i') AS DtOperacao, Mensagem, CPF
	FROM tbl_averb_log
	WHERE FK_Movimento = '$Filtro'
	ORDER BY PK_Log DESC ";
}elseif($tbl == "cartao_log"){
	$Filtro =  isset($_POST['Condicao']) ? $_POST['Condicao'] : false;
	$query = "SELECT DATE_FORMAT(DateTimeInsert,'%d/%m/%y %H:%i') AS DtOperacao, Mensagem, CPF
	FROM tbl_cartao_log
	WHERE FK_Movimento = '$Filtro'
	ORDER BY PK_Log DESC ";
}elseif($tbl == "cons_margem"){
	$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
	$FK_Convenio =  isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false;
	$CPF =  isset($_POST['CPF']) ? $_POST['CPF'] : false;
	$query = "Select DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%y %H:%i') AS DateTimeUpdate , a.Protocolo , 
	DATE_FORMAT(a.DataReserva,'%d/%m/%Y') AS DtSolicitacao , DATE_FORMAT(a.DataAverbacao,'%d/%m/%Y %H:%i') AS DtAutorizacao , a.Complemento, 
	FORMAT(a.ValorReserva,2,'pt_BR') AS ParcelaSolicitada , 
	FORMAT(a.ValorAverbacao,2,'pt_BR') AS ParcelaAutorizada
	FROM tbl_baixa_ativa a
	LEFT JOIN tbl_cada_cliente b ON a.FK_Cliente = b.PK_Cada_Cliente
	WHERE b.CPF = '{$CPF}' AND b.FK_Convenio = '{$FK_Convenio}' AND a.Complemento LIKE 'CART%'
	ORDER BY DateTimeUpdate DESC";
}
$rows = $dao->listaFromQuery($query, new stdClass());
die(json_encode($rows));
?>