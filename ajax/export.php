<?php
require_once '../class/dao.class.php';
require_once '../class/csv.class.php';
require_once '../class/tbl_user.class.php';
require_once '../class/funcoes.php';

//Verifica a conexão ativa
checkSession();
$dao = new DAO();
$csv = new CSV();

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

$FK_Banco = (isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false);
$FK_Convenio = (isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false);
$status = (isset($_POST['businessStatus']) ? $_POST['businessStatus'] : false);
$dtInicio = (isset($_POST['dtInicio']) ? strtotime(str_replace("/", "-", $_POST['dtInicio'])) : false);
$dtFinal = (isset($_POST['dtFinal']) ? strtotime(str_replace("/", "-", $_POST['dtFinal'])) : false);
$TIPO = (isset($_POST['tipo']) ? $_POST['tipo'] : '');

if($TIPO == "movimento"){
	$filename = "../tmp/".date("Y_m_d_H_i_s")."_consulta_registros.csv";
	
	$query = "SELECT DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS UltimaAtualizacao, a.CPF AS CPF, c.Nome AS Cliente, a.NumeroContrato AS Contrato,
	FORMAT(a.Parcela,2,'pt_BR') AS ParcelaValor, Prazo, FORMAT(ValorInadimplente,2,'pt_BR') AS ValorInadimplente, Status,
	FORMAT(IFNULL((SELECT SUM(x.MargemDisponivel) FROM tbl_cliente_matricula x WHERE x.FK_Cliente = c.PK_Cada_Cliente),0),2,'pt_BR') AS MargemDisponivel,
	FORMAT(IFNULL((SELECT SUM(x.ValorSolicitado) FROM tbl_reserva x WHERE x.FK_Movimento = a.PK_Movimento),0),2,'pt_BR') AS ValorReservado,
	FORMAT(IFNULL((SELECT SUM(x.ValorSolicitado) FROM tbl_averbado x LEFT JOIN tbl_reserva y ON x.FK_Reserva = y.PK_Reserva WHERE y.FK_Movimento = a.PK_Movimento),0),2,'pt_BR') AS ValorAverbado,
	b.ValorMinimo 
	FROM tbl_movimento a 
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_cada_cliente c ON a.CPF = c.CPF AND a.FK_Convenio = c.FK_Convenio 
	WHERE 1=1 ";
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."' ";
	if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' a.FK_Banco = '", $_bancos)."' )";
	}
	if($status == "Margem"){
		$query.="GROUP BY PK_Movimento HAVING MargemDisponivel > b.ValorMinimo "; 
	}elseif($status == "Reservado"){
		$query.="AND Status = 'Reservado' ";
	}elseif($status == "Averbado"){
		$query.="AND Status = 'Averbado' ";
	}elseif($status == "Inativos"){
		$query.="AND Status='Inativo' ";
	}
	
	if($status == 'Averbado'){
		$query = "SELECT DATE_FORMAT(d.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS Consulta,
		DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS dtAverbado, e.CPF, Nome, NumeroContrato, 
		FORMAT(d.Parcela,2,'pt_BR') AS ParcelaOriginal, d.Prazo AS PrazoOriginal, FORMAT(d.ValorInadimplente,2,'pt_BR') AS InadimplenciaOriginal, 
		FORMAT(d.ValorInadimplenteAtual,2,'pt_BR') AS ValorInadimplenteAtual,
		a.Protocolo, a.Prazo, a.PeriodoInicio,FORMAT(a.ValorParcela,2,'pt_BR') AS ValorParcela,
		FORMAT(a.ValorSolicitado,2,'pt_BR') AS ValorSolicitado, FORMAT(c.ValorBaseReserva,2,'pt_BR') AS ValorBaseReserva , 
		IF(d.Parcela > (SELECT SUM(ValorParcela) FROM tbl_averbado x WHERE x.FK_Movimento = d.PK_Movimento), 'Averbado Parcial', 'Averbado Total') AS SituacaoParcela,
		IF(ValorInadimplenteAtual > 0, 'Averbado Parcial', 'Averbado Total') AS SituacaoInadimplencia, 
		f.PK_Cliente_Matricula
		FROM tbl_averbado a
		LEFT JOIN tbl_matricula_baixa b ON a.Protocolo = b.CodigoSolicitacao
		LEFT JOIN tbl_reserva c ON c.PK_Reserva = a.FK_Reserva
		LEFT JOIN tbl_movimento d ON d.PK_Movimento = c.FK_Movimento
		LEFT JOIN tbl_cada_cliente e ON e.CPF = d.CPF
		LEFT JOIN tbl_cliente_matricula f ON f.PK_Cliente_Matricula = c.FK_ClienteMatricula	WHERE 1=1 ";
		if($FK_Banco) $query .= "AND d.FK_Banco = '{$FK_Banco}' ";
		if($FK_Convenio) $query .= "AND d.FK_Convenio = '{$FK_Convenio}' ";
		if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."'";
		if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."'";
		
		if($UserBancos){
			$query.= "AND ( d.FK_Banco = '".implode("' d.FK_Banco = '", $_bancos)."' )";
		}
		$data = $dao->listaFromQuery($query, new stdClass());
		$csv->setCabecalho(array("Ultima Consulta Realizada", "Averbado em",  "CPF", "Cliente", "Contrato", "Valor Parcela Original", "Prazo Original", "Valor Inadimplente Original", "Valor Inadimplente Atual", 
				"Protocolo", "Periodo Inicio", "Prazo", "Valor Parcela", "Valor Solicitado", "Valor Base para Averbar","Status Parcela", "Status Inadimplencia"));
		$csv->setDados(array("Consulta", "dtAverbado", "CPF", "Nome", "NumeroContrato", "ParcelaOriginal", "PrazoOriginal", "InadimplenciaOriginal", "ValorInadimplenteAtual",
			 "Protocolo", "PeriodoInicio","Prazo", "ValorParcela", "ValorSolicitado", "ValorBaseReserva", "SituacaoParcela", "SituacaoInadimplencia"));
		$csv->setCCData($data);
	}else{
		$data = $dao->listaFromQuery($query, new stdClass());
		$csv->setCabecalho(array("Consulta realizada em","CPF", "Cliente", "Contrato", "Valor Parcela", "Prazo", "Valor Inadimplente total", "Status", "Margem Disponivel", "Valor Reservado Total", "Valor Averbado Total"));
		$csv->setDados(array("UltimaAtualizacao", "CPF", "Cliente", "Contrato", "ParcelaValor", "Prazo", "ValorInadimplente", "Status", "MargemDisponivel", "ValorReservado", "ValorAverbado"));
		$csv->setCCData($data);
	}
	
}elseif($TIPO == 'movimento_cartao'){
	$filename = "../tmp/".date("Y_m_d_H_i_s")."_consulta_registros.csv";
	
	$query = "SELECT DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS UltimaAtualizacao, a.CPF AS CPF, c.Nome AS Cliente, a.NumeroContrato AS Contrato,
	FORMAT(a.ValorSolicitado,2,'pt_BR') AS ParcelaValor, Status,
	FORMAT(IFNULL((SELECT SUM(x.MargemDisponivel) FROM tbl_cliente_matricula x WHERE x.FK_Cliente = c.PK_Cada_Cliente),0),2,'pt_BR') AS MargemDisponivel,
	FORMAT(IFNULL((SELECT SUM(x.ValorSolicitado) FROM tbl_cartao_averbado x WHERE a.PK_Movimento = x.FK_Movimento ),0),2,'pt_BR') AS ValorAverbado 
	FROM tbl_cartao_movimento a 
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_cada_cliente c ON a.CPF = c.CPF AND a.FK_Convenio = c.FK_Convenio 
	WHERE 1=1 ";
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."' ";
	if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' a.FK_Banco = '", $_bancos)."' )";
	}
	if($status == "Margem"){
		$query.="GROUP BY PK_Movimento HAVING MargemDisponivel > b.ValorMinimo "; 
	}elseif($status == "Reservado"){
		$query.="AND Status = 'Reservado' ";
	}elseif($status == "Averbado"){
		$query.="AND Status = 'Averbado' ";
	}elseif($status == "Inativos"){
		$query.="AND Status='Inativo' ";
	}
	
	if($status == 'Averbado'){
		$query = "SELECT DATE_FORMAT(d.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS Consulta,
		DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS dtAverbado, e.CPF, d.NumeroMatricula , d.NumeroContrato , Nome, 
		FORMAT(d.ValorSolicitado,2,'pt_BR') AS ParcelaOriginal, 
		FORMAT(a.ValorSolicitado,2,'pt_BR') AS ValorSolicitado , FORMAT (d.ValorSolicitado - a.ValorSolicitado,2,'pt_BR') AS ValorDiferenca, d.Status AS StatusAverbacao
		FROM tbl_cartao_averbado a
		LEFT JOIN tbl_cartao_movimento d ON d.PK_Movimento = a.FK_Movimento
		LEFT JOIN tbl_cada_cliente e ON e.CPF = d.CPF AND e.FK_Convenio = d.FK_Convenio
		LEFT JOIN tbl_cliente_matricula f ON f.PK_Cliente_Matricula = a.FK_ClienteMatricula	
        WHERE 1=1  ";
		if($FK_Banco) $query .= "AND d.FK_Banco = '{$FK_Banco}' ";
		if($FK_Convenio) $query .= "AND d.FK_Convenio = '{$FK_Convenio}' ";
		if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."'";
		if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."'";
		
		if($UserBancos){
			$query.= "AND ( d.FK_Banco = '".implode("' d.FK_Banco = '", $_bancos)."' )";
		}
		$data = $dao->listaFromQuery($query, new stdClass());
		$csv->setCabecalho(array("Ultima Consulta Realizada", "Averbado em",  "CPF", "Matricula" , "Contrato" , "Cliente", "Parcela Original" , "Parcela Solicitada" , "Diferenca" , "Status"));
		$csv->setDados(array("Consulta", "dtAverbado", "CPF", "NumeroMatricula", "NumeroContrato", "Nome", "ParcelaOriginal", "ValorSolicitado", "ValorDiferenca", "StatusAverbacao"));
		$csv->setCCData($data);
	}else{
		$data = $dao->listaFromQuery($query, new stdClass());
		$csv->setCabecalho(array("Consulta realizada em","CPF", "Cliente", "Contrato", "Valor Parcela", "Status", "Margem Disponivel", "Valor Averbado Total"));
		$csv->setDados(array("UltimaAtualizacao", "CPF", "Cliente", "Contrato", "ParcelaValor", "Status", "MargemDisponivel", "ValorAverbado"));
		$csv->setCCData($data);
	}
}elseif($TIPO == 'movimento_averb'){
	$filename = "../tmp/".date("Y_m_d_H_i_s")."_consulta_registros.csv";
	
	$query = "SELECT DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS UltimaAtualizacao, a.CPF AS CPF, a.NumeroMatricula AS Matricula, c.Nome AS Cliente, a.NumeroContrato AS Contrato,
	FORMAT(a.ValorParcela,2,'pt_BR') AS ParcelaValor, a.Parcelas AS Prazo, a.ValorSolicitado, Status,
	FORMAT(IFNULL((SELECT SUM(x.MargemDisponivel) FROM tbl_cliente_matricula x WHERE x.FK_Cliente = c.PK_Cada_Cliente),0),2,'pt_BR') AS MargemDisponivel
	FROM tbl_averb_movimento a 
	LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
	LEFT JOIN tbl_cada_cliente c ON a.CPF = c.CPF AND a.FK_Convenio = c.FK_Convenio 
	WHERE 1=1 ";
	if($FK_Banco) $query .= "AND a.FK_Banco = '{$FK_Banco}' ";
	if($FK_Convenio) $query .= "AND a.FK_Convenio = '{$FK_Convenio}' ";
	if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."' ";
	if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."' ";
	//Proteção de Usuario
	if($UserBancos){
		$query.= "AND ( a.FK_Banco = '".implode("' OR a.FK_Banco = '", $_bancos)."' )";
	}
	if($status == "Margem"){
		$query.="GROUP BY PK_Movimento HAVING MargemDisponivel > b.ValorMinimo "; 
	}elseif($status == "Reservado"){
		$query.="AND Status = 'Reservado' ";
	}elseif($status == "Averbado"){
		$query.="AND Status = 'Averbado' ";
	}elseif($status == "Inativos"){
		$query.="AND Status='Inativo' ";
	}
	
	if($status == 'Averbado'){
		$query = "SELECT DATE_FORMAT(d.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS Consulta,
		DATE_FORMAT(a.DateTimeUpdate,'%d/%m/%Y %H:%i:%s') AS dtAverbado, e.CPF, d.NumeroMatricula AS Matricula, d.NumeroContrato AS Contrato, e.Nome AS Cliente, a.Prazo,
		FORMAT(d.ValorParcela,2,'pt_BR') AS ParcelaOriginal, FORMAT(d.ValorSolicitado,2,'pt_BR') AS ValorSolicitadoOriginal,
		FORMAT(a.ValorParcela,2,'pt_BR') AS ParcelaSolicitada , FORMAT(a.ValorSolicitado,2,'pt_BR') AS ValorSolicitado , d.Status AS StatusAverbacao
		FROM tbl_averb_averbado a
		LEFT JOIN tbl_averb_movimento d ON d.PK_Movimento = a.FK_Movimento
		LEFT JOIN tbl_cada_cliente e ON e.CPF = d.CPF AND e.FK_Convenio = d.FK_Convenio
		WHERE 1=1  ";
		if($FK_Banco) $query .= "AND d.FK_Banco = '{$FK_Banco}' ";
		if($FK_Convenio) $query .= "AND d.FK_Convenio = '{$FK_Convenio}' ";
		if($dtInicio) $query.= "AND DATE(a.DateTimeUpdate) >= '".date('Y-m-d',$dtInicio)."'";
		if($dtFinal) $query.= "AND DATE(a.DateTimeUpdate) <= '".date('Y-m-d',$dtFinal)."'";
		
		if($UserBancos){
			$query.= "AND ( d.FK_Banco = '".implode("' OR d.FK_Banco = '", $_bancos)."' )";
		}
		$data = $dao->listaFromQuery($query, new stdClass());
		$csv->setCabecalho(array("Ultima Consulta Realizada", "Averbado em",  "CPF", "Matricula" , "Contrato" , "Cliente", "Prazo", "Parcela Original" , "Valor Solicitado Original", "Parcela Averbada" , "Valor Averbado" , "Status"));
		$csv->setDados(array("Consulta", "dtAverbado", "CPF", "Matricula", "Contrato", "Cliente", "Prazo", "ParcelaOriginal", "ValorSolicitadoOriginal", "ParcelaSolicitada", "ValorSolicitado", "StatusAverbacao"));
		$csv->setCCData($data);
	}else{
		$data = $dao->listaFromQuery($query, new stdClass());
		$csv->setCabecalho(array("Consulta realizada em","CPF","Matricula", "Cliente", "Contrato", "Valor Parcela", "Prazo", "ValorSolicitado", "Status", "Margem Disponivel"));
		$csv->setDados(array("UltimaAtualizacao", "CPF", "Matricula", "Cliente", "Contrato", "ParcelaValor", "Prazo", "ValorSolicitado", "Status", "MargemDisponivel"));
		$csv->setCCData($data);
	}
}
$csv->save($filename);
die($filename);

?>