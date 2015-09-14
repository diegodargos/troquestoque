//Arquivo contendo functions de apoio de formularios.

//Formata valor da moeda
Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
	c = isNaN(c = Math.abs(c)) ? 2 : c, 
	d = d == undefined ? "," : d, 
	t = t == undefined ? "." : t, s = n < 0 ? "-" : "", 
	i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
	j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

String.prototype.trim = function(){
    return this.replace(/^\s+|\s+$/g, ''); 
};

/**
 * Fun��o que retorna os valores passados por json para os campos com os nomes correspondentes.
 * @param data
 * @returns {Boolean}
 */
function fJson(data, fcallback){
	$.each(data,function(i,item){
		try{
			$("input[id='"+i+"']").val(item);
			$("select[id='"+i+"']").val(item);
			$("textarea[id='"+i+"']").val(item);
			$("input[type=checkbox][id='"+i+"']").attr('checked',(item == true) );
		}catch(e){
			console.log("i: " + i + " item: " + item + " erro: " + e.message );
		}
	});
	fFormatInput();
	if(fcallback && typeof(fcallback) === "function") fcallback(true);
}

//Formata��o de campos baseado em attr do input.
function fFormatInput(){
	var decimais = 2;
	$("input").each(function(index, element){
		if($(this).attr("data-format") == "money"){
			if($(this).attr("data-decimal") != undefined) decimais = $(this).attr("data-decimal");
			$(this).val(function(i,value){
				if( value.indexOf(".") == -1 ) return value; 
				return parseFloat(value).formatMoney(decimais,',',''); 
			});
			if(decimais == 0){
				$(this).keydown(function(event) {
					//console.log(event.keyCode);
				    if (!(!event.shiftKey //Disallow: any Shift+digit combination
				            && !(event.keyCode < 48 || event.keyCode > 57) //Disallow: everything but digits
				            || !(event.keyCode < 96 || event.keyCode > 105) //Allow: numeric pad digits
				            || event.keyCode == 46 // Allow: delete
				            || event.keyCode == 8  // Allow: backspace
				            || event.keyCode == 9  // Allow: tab
				            || event.keyCode == 27 // Allow: escape
				            || event.keyCode == 173 || event.keyCode == 109 // Allow: -
				            || (event.keyCode == 65 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+A
				            || (event.keyCode == 67 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+C
				            //Uncommenting the next line allows Ctrl+V usage, but requires additional code from you to disallow pasting non-numeric symbols
				            || (event.keyCode == 86 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+Vpasting 
				            || (event.keyCode >= 35 && event.keyCode <= 39) // Allow: Home, End
				            )) {
				        event.preventDefault();
				    }
				});
			}else{
				$(this).keydown(function(event) {
					//console.log(event.keyCode);
				    if (!(!event.shiftKey //Disallow: any Shift+digit combination
				            && !(event.keyCode < 48 || event.keyCode > 57) //Disallow: everything but digits
				            || !(event.keyCode < 96 || event.keyCode > 105) //Allow: numeric pad digits
				            || event.keyCode == 46 // Allow: delete
				            || event.keyCode == 8  // Allow: backspace
				            || event.keyCode == 9  // Allow: tab
				            || event.keyCode == 27 // Allow: escape
				            || event.keyCode == 173 // Allow: -
				            || event.keyCode == 188 || event.keyCode == 110 // Allow: ,
				            || (event.keyCode == 65 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+A
				            || (event.keyCode == 67 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+C
				            //Uncommenting the next line allows Ctrl+V usage, but requires additional code from you to disallow pasting non-numeric symbols
				            || (event.keyCode == 86 && (event.ctrlKey === true || event.metaKey === true)) // Allow: Ctrl+Vpasting 
				            || (event.keyCode >= 35 && event.keyCode <= 39) // Allow: Home, End
				            )) {
				        event.preventDefault();
				    }
				});
			}
			$(this).css("text-align","right");
			if($(this).attr("size") == undefined){
				$(this).attr("size",10);
			}
		}
		if($(this).attr("data-format") == "date"){
			var data = $(this).val();
			if($(this).attr("data-mask") == "year" ){
				$(this).datepicker({ showButtonPanel: true,
			        dateFormat: 'yy', changeMonth: false, changeYear: true, yearRange: "-1:+10", nextText: "" , prevText: "" });	
					$(this).attr("size",5);
			}else{
				if( data.indexOf("/") == -1 && data != ""){
					$(this).val(function(i,value){ return value.substring(8,10) + "/" + value.substring(5,7) + "/" + value.substring(0,4); });
				}
				$(this).mask("99/99/9999",{placeholder:" "});
				$(this).datepicker({ nextText: "" , prevText: "" });
				$(this).attr("size",11);
			}
		}
		if($(this).attr("data-format") == "time"){
			$(this).mask("99:99",{placeholder:" "});
			$(this).attr("size",5);
		}
		if($(this).attr("data-format") == "custom"){
			if($(this).attr("data-mask") != undefined){
				$(this).mask($(this).attr("data-mask"),{placeholder:" "});
				$(this).attr("size", $(this).attr("data-mask").length + 1);
			}
			
		}
		if($(this).attr("data-required") == "true"){
			$(this).addClass("obg");
		}
	});
}