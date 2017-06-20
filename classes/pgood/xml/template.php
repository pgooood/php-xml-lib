<?php
namespace pgood\xml;

class template extends cached{
	function __construct($path){
		if(is_file($path))
			parent::__construct($path);
		else throw new \Exception('Wrong value <pre>'.print_r($path,1).'</pre>');
		$this->registerNameSpace('xsl','http://www.w3.org/1999/XSL/Transform');
	}
	function included($noCache = false){
		$xml = $this;
		if($noCache){
			$xml = new xml($this->documentURI());
			$xml->registerNameSpace('xsl','http://www.w3.org/1999/XSL/Transform');
		}
		$ns = $xml->query('/xsl:stylesheet/xsl:include');
		if($ns->length){
			$arXsl = array();
			foreach($ns as $e)
				$arXsl[] = $e->getAttribute('href');
			return $arXsl;
		}
	}
	function xslInclude($path){
		if($this->de() && !$this->evaluate('count(/xsl:stylesheet/xsl:include[@href="'.htmlspecialchars($path).'"])')){
			$include = $this->de()->insertBefore(
				$this->dd()->createElementNS('http://www.w3.org/1999/XSL/Transform','xsl:include')
				,$this->de()->firstChild);
			$include->href = $path;
			return true;
		}
	}
	function xslVariable($name,$value){
		if(!$this->evaluate('count(/xsl:stylesheet/xsl:variable[@name="'.$name.'"])')){
			$e = new element($this->de()->insertBefore(
				$this->dd()->createElementNS('http://www.w3.org/1999/XSL/Transform','xsl:variable')
				,$this->de()->firstChild));
			$e->name = $name;
			$e->text($value);
		}
	}
	function transform($xml){
		if($this->de()){
			$xml = new xml($xml);
			$proc = new \XSLTProcessor;
			$proc->importStyleSheet($this->dd());
			return $proc->transformToXML($xml->dd());
		}
		throw new \Exception('Template XML error');
	}
}