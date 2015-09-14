function formPrefeituraRioJaneiro(){
	var formulario = '<legend class="int">Dados do Contrato:</legend>';
	formulario+= '<label class="half left clearfix">CPF:<input class="half right" type="text" name="CPF" id="CPF" data-format="custom" data-mask="999.999.999-99" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero da Matr&iacute;cula: <input class="half right" type="text" name="Matricula" id="Matricula" data-format="money" data-decimal="0" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero do Contrato: <input class="half right" type="text" name="NumeroContrato" id="NumeroContrato" data-format="money" data-decimal="0" ></label>';
	formulario+= '<label class="half left clearfix">Valor do Contrato: <input class="half right" type="text" name="ValorContrato" id="ValorContrato" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">Valor da Parcela: <input class="half right" type="text" name="ValorParcela" id="ValorParcela" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">Prazo (Parcelas): <input class="half right" type="text" name="Prazo" id="Prazo" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Taxa de Juros: <input class="half right" type="text" name="TaxaJuros" id="TaxaJuros" data-format="money" data-decimal="10"></label>';
	formulario+= '<label class="half left clearfix">IOF: <input class="half right" type="text" name="IOF" id="IOF" data-format="money" data-decimal="4"></label>';
	formulario+= '<label class="half left clearfix">Valor Extra: <input class="half right" type="text" name="ValorExtra" id="ValorExtra" data-format="money" data-decimal="2"></label>';
	formulario+= '<label class="half left clearfix">Valor Repasse: <input class="half right" type="text" name="ValorRepasse" id="ValorRepasse" data-format="money" data-decimal="2"></label>';
	formulario+= '<input class="right" type="button" value="Salvar" id="btSalvar">';
	return formulario;
}

function formPrefeituraBeloHorizonte(){
	var formulario = '<legend class="int">Dados do Contrato:</legend>';
	formulario+= '<label class="half left clearfix">CPF:<input class="half right" type="text" name="CPF" id="CPF" data-format="custom" data-mask="999.999.999-99" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero da Matr&iacute;cula: <input class="half right" type="text" name="Matricula" id="Matricula" data-format="money" data-decimal="0" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero do Contrato: <input class="half right" type="text" name="NumeroContrato" id="NumeroContrato" ></label>';
	formulario+= '<label class="half left clearfix">Valor do Contrato: <input class="half right" type="text" name="ValorContrato" id="ValorContrato" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">Valor da Parcela: <input class="half right" type="text" name="ValorParcela" id="ValorParcela" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">Prazo (Parcelas): <input class="half right" type="text" name="Prazo" id="Prazo" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Banco: <input class="half right" type="text" name="Banco" id="Banco" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Agencia: <input class="half right" type="text" name="Agencia" id="Agencia" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Conta Corrente: <input class="half right" type="text" name="ContaCorrente" id="ContaCorrente" data-format="money" data-decimal="0"></label>';
	formulario+= '<input class="right" type="button" value="Salvar" id="btSalvar">';
	return formulario;
}

function formAeronautica(){
	var formulario = '<legend class="int">Dados do Contrato:</legend>';
	formulario+= '<label class="half left clearfix">CPF:<input class="half right" type="text" name="CPF" id="CPF" data-format="custom" data-mask="999.999.999-99" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero da Matr&iacute;cula: <input class="half right" type="text" name="Matricula" id="Matricula" data-format="money" data-decimal="0" ></label>';
	formulario+= '<label class="half left clearfix">Valor da Parcela: <input class="half right" type="text" name="ValorParcela" id="ValorParcela" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero do Contrato: <input class="half right" type="text" name="NumeroContrato" id="NumeroContrato" data-format="money" data-decimal="0" ></label>';
	formulario+= '<input class="right" type="button" value="Salvar" id="btSalvar">';
	return formulario;
}

function formGovParana(){
	var formulario = '<legend class="int">Dados do Contrato:</legend>';
	formulario+= '<label class="half left clearfix">CPF:<input class="half right" type="text" name="CPF" id="CPF" data-format="custom" data-mask="999.999.999-99" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero da Matr&iacute;cula: <input class="half right" type="text" name="Matricula" id="Matricula" data-format="money" data-decimal="0" ></label>';
	formulario+= '<label class="half left clearfix">N&uacute;mero do Contrato: <input class="half right" type="text" name="NumeroContrato" id="NumeroContrato" ></label>';
	formulario+= '<label class="half left clearfix">Valor do Contrato: <input class="half right" type="text" name="ValorContrato" id="ValorContrato" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">Valor da Parcela: <input class="half right" type="text" name="ValorParcela" id="ValorParcela" data-format="money" data-decimal="2" ></label>';
	formulario+= '<label class="half left clearfix">Prazo (Parcelas): <input class="half right" type="text" name="Prazo" id="Prazo" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Banco: <input class="half right" type="text" name="Banco" id="Banco" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Agencia: <input class="half right" type="text" name="Agencia" id="Agencia" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Conta Corrente: <input class="half right" type="text" name="ContaCorrente" id="ContaCorrente" data-format="money" data-decimal="0"></label>';
	formulario+= '<label class="half left clearfix">Usuario Servidor: <input class="half right" type="text" name="UsuarioServidor" id="UsuarioServidor" ></label>';
	formulario+= '<label class="half left clearfix">Identificador: <input class="half right" type="text" name="SenhaServidor" id="SenhaServidor"></label>';
	formulario+= '<input class="right" type="button" value="Salvar" id="btSalvar">';
	return formulario;
}