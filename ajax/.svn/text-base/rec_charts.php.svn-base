<?php
require_once '../class/dao.class.php';
require_once '../class/tbl_user.class.php';
require_once '../class/funcoes.php';

$dao = new DAO();

$chart = isset($_POST['Chart']) ? $_POST['Chart'] : false;
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

$FK_Banco = isset($_POST['FK_Banco']) ? $_POST['FK_Banco'] : false;
$FK_Convenio = isset($_POST['FK_Convenio']) ? $_POST['FK_Convenio'] : false; 

$query = "SELECT b.PK_Convenio,  b.Nome AS Nome,  COUNT(1) AS Contratos, 
SUM(ValorInadimplente) AS ValorRecuperar, 
SUM(Parcela) AS ParcelaRecuperar,
(SELECT SUM(x.ValorParcela) FROM tbl_averbado x WHERE x.FK_Movimento IN (SELECT PK_Movimento FROM tbl_movimento y  WHERE y.FK_Convenio = a.FK_Convenio ) ) AS ParcelaAverbada,
(SELECT SUM(x.ValorSolicitado) FROM tbl_averbado x WHERE x.FK_Movimento IN (SELECT PK_Movimento FROM tbl_movimento y  WHERE y.FK_Convenio = a.FK_Convenio ) ) AS ValorAverbado,
(SELECT COUNT(1) FROM tbl_movimento x WHERE x.FK_Convenio = a.FK_Convenio  AND x.Status = 'Invalido') AS Invalidos,
(SELECT COUNT(1) FROM tbl_movimento x WHERE x.FK_Convenio = a.FK_Convenio  AND x.Status = 'Inativo') AS Inativo,
(SELECT COUNT(1) FROM tbl_movimento x WHERE x.FK_Convenio = a.FK_Convenio  AND (x.Status = 'Consulta' OR x.Status = 'Averbado') ) AS Consulta,
(SELECT COUNT(1) FROM tbl_movimento x WHERE x.FK_Convenio = a.FK_Convenio  AND x.Status = 'Averbado' AND x.ValorInadimplenteAtual > 1) AS AverbadoTotal,
(SELECT COUNT(1) FROM tbl_movimento x WHERE x.FK_Convenio = a.FK_Convenio  AND x.Status = 'Averbado' AND x.ValorInadimplenteAtual < 1) AS AverbadoParcial
FROM tbl_movimento a
LEFT JOIN tbl_convenio b ON a.FK_Convenio = b.PK_Convenio
WHERE 1=1 ";
if($FK_Banco) $query.= "AND a.FK_Banco = '$FK_Banco' ";
if($FK_Convenio) $query.= "AND a.FK_Convenio = '$FK_Convenio' ";

if($UserBancos){
	$query.= "AND ( a.FK_Banco = '".implode("' OR a.FK_Banco = '", $_bancos)."' ) ";
}
$query .= "GROUP BY a.FK_Convenio ";

$lista = $dao->listaFromQuery($query, new stdClass());
die(json_encode($lista));

?>