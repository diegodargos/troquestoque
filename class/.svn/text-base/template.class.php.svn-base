<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 13/04/2015 13:03:03
Baseado em : mysql.gs:3306/dbautomato 
*/

class Template{
   
    private $prefix = null;
    private $posfix = null;
    private $path = null;
    private $template = null;
   
    public function setPrefix($prefix){
        $this->prefix = $prefix;
    }
   
    public function setPosfix($posfix){
        $this->posfix = $posfix;
    }
   
    public function setPath($path){
        $this->path = $path;
    }
   
    public function loadFromFile($filename){
        $file = $this->path . $this->prefix . $filename . $this->posfix;
        if(!file_exists($file)) throw new Exception("File $file not found");
        $this->template = file_get_contents($file);
    }
   
    public function changeTag2Obj($obj){
        if(!is_object($obj)) throw new Exception("Var $$obj not instance of Object");
        $vars = get_class_methods($obj);
        foreach ($vars as $var){
            if(substr($var,0,3) == "get"){
                $this->template = str_replace("{".substr($var,3)."}", call_user_func(array(&$obj, $var)), $this->template);
            }
        }
    }
   
    public function setTag2Obj($tag, $obj){
        if(!is_object($obj)) throw new Exception("Var $$obj not instance of Object");
        $vars = get_class_methods($obj);
        foreach ($vars as $var){
            if(substr($var,0,3) == "get"){
                $tag = str_replace("{".substr($var,3)."}", call_user_func(array(&$obj, $var)), $tag);
            }
        }
        return $tag;
    }
   
    public function changeTag2Array($array){
        if(!is_array($array)) throw new Exception("Var $$array not instance of Array");
        //Loop de Valores.
        foreach($array as $var => $value){
            $this->template = str_replace("{$var}", $value, $this->template);
        }
    }
   
	public function setTag2Array($tag, $array){
    	if(!is_array($array)) throw new Exception("Var $$array not instance of Array");
    	foreach ($array as $field => $value){
   			$tag = str_replace("{".$field."}", $value, $tag);
    	}
    	return $tag;
    }   
   
    public function getContextByDefiner($tagInicio, $tagFinal){
    	if($tagInicio == "" || $tagFinal == "") return ;
        $str = explode($tagInicio, $this->template);
        $str = $str[1];
        $str = explode($tagFinal, $str);
        $str = $str[0];
        return $str;
    }

    public function loopContextByDefiner($array, $tagInicio, $tagFinal){
    	$tmp = self::getContextByDefiner($tagInicio,$tagFinal);
    	$opt = null;
    	foreach($array as $obj){
    		$data = (array) $obj;
    		$opt .= self::setTag2Array($tmp, $data);
    	}
    	self::setContextByDefiner($opt, "$tagInicio", "$tagFinal");
    }
       
    public function setContextByDefiner($context, $tagInicio, $tagFinal){
        $tmp = self::getContextByDefiner($tagInicio, $tagFinal);
        $this->template = str_replace($tmp, $context, $this->template);
    }
   
    public function getContextFromFile($filename){
        $file = $this->path . $this->prefix . $filename . $this->posfix;
        if(!file_exists($file)) throw new Exception("File $file not found");
        return file_get_contents($file);
    }
   
    public function show(){
        echo $this->template;
    }
   
}