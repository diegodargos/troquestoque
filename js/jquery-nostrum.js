function nPrompt(text,label,defaultValue,fnSubmit,fnCallback){nPrompt(text,label,defaultValue,fnSubmit,fnCallback,1);}function nPrompt(text,label,defaultValue,fnSubmit,fnCallback,rows){if((defaultValue==null)||(defaultValue==undefined)){defaultValue="";}if((rows==null)||(rows==undefined)){rows=1;}var txt=text+'<div class="field"><br><label for="editfield">'+label+'</label><textarea id="editfield" name="editfield" rows="'+rows+'" cols="70">'+defaultValue+"</textarea></div><br>";$.prompt(txt,{buttons:{Confirmar:true,Cancelar:false},submit:function(v,m){return fnSubmit(v,m);},callback:function(v,m){fnCallback(v,m);}});}function nConfirm(text,fnSubmit,fnCallback){$.prompt(text,{buttons:{Confirmar:true,Cancelar:false},submit:function(v,m){return fnSubmit(v,m);},callback:function(v,m){fnCallback(v,m);}});}function postData(href,target){if(window.console){window.console.clear;}var hrefCodificado;var firstQt=href.indexOf("?");var p;if(firstQt>0){var prefixHref=href.substr(0,(firstQt+1));var suffixHref=href.substr((firstQt+1),href.length);var suffixHrefEncoded=encodeURIComponent(suffixHref);hrefCodificado=prefixHref.concat(suffixHrefEncoded);p=hrefCodificado.split("?");for(var i=0;i<p.length;i++){p[i]=decodeURIComponent(p[i]);}}else{p=href.split("?");}var action=p[0];var params;if(p.length>1){params=p[1].split("&");}var frame;try{if(typeof target!="undefined"){if(typeof this.parent[target]!="undefined"){frame=this.parent[target];}else{if(typeof this.parent.acessoMainFrame!="undefined"){frame=this.parent.acessoMainFrame[target];}}}else{if(typeof this.parent.acessoMainFrame!="undefined"){frame=this.parent.acessoMainFrame;}else{if(typeof this.parent.mainFrame!="undefined"){frame=this.parent.mainFrame;}}}}catch(err){frame=window.frames[target];}if(typeof frame=="undefined"){frame=this;}var form=frame.document.createElement("form");form.setAttribute("action",action);form.setAttribute("method","post");if(typeof target!="undefined"){form.setAttribute("target",target);}try{frame.document.getElementsByTagName("body")[0].appendChild(form);}catch(err){}jQuery(frame.document.createElement("input")).attr("type","hidden").attr("name","dummy").attr("id","dummy").attr("value","bugie11").appendTo(form);for(var i=0;i<(typeof params!="undefined"?params.length:0);i++){var tmp=params[i].split("=");var key=(tmp.length>0?tmp[0]:"");var value=(tmp.length>1?tmp[1]:"");try{value=decodeURIComponent(value);}catch(err){}if(key){jQuery(frame.document.createElement("input")).attr("type","hidden").attr("name",key).attr("id",key).attr("value",value).appendTo(form);}}form.submit();return false;}