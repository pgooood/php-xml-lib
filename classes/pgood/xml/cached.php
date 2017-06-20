<?php
namespace pgood\xml;

class cached extends xml{
	function init($v){
		$res = parent::init($v);
		if($uri = $this->documentURI()){
			if($dd = $this->cache($uri))
				$res = parent::init($dd);
			else $this->cache();
		}
		return $res;
	}
	function load($src){
		if($dd = $this->cache($src)){
			$this->dd = $dd;
		}else{
			parent::load($src);
			$this->cache();
		}
	}
	function save($uri = null){
		$old = $this->documentURI();
		if(($res = parent::save($uri)) && $old != $this->documentURI()){
			$this->clearCache($old);
			$this->cache();
		}
		return $res;
	}
	protected function cache($src = false){
		global $_xmlCache;
		if($src !== false){
			if(($uri = cached::normalizePath($src)) && isset($_xmlCache[$uri]))
				return $_xmlCache[$uri];
		}elseif($uri = cached::normalizePath($this->documentURI())){
			if(!isset($_xmlCache)) $_xmlCache = array();
			$_xmlCache[$uri] = $this->dd();
		}
	}
	static function clearCache($src){
		global $_xmlCache;
		if(($uri = cached::normalizePath($src))
		   && isset($_xmlCache[$uri])
		) unset($_xmlCache[$uri]);
	}
	static function normalizePath($path){
		if($path && (!($url = parse_url($path)) || !isset($url['scheme']))){
			if(substr($path,0,1)!='/'){
				$scriptDir = pathinfo(filter_input(INPUT_SERVER,'SCRIPT_FILENAME'),PATHINFO_DIRNAME);
				$arScriptDir = explode('/',$scriptDir);
				$arPath = explode('/',$path);
				foreach($arPath as $folder){
					if($folder=='..') array_pop($arScriptDir);
					elseif($folder) array_push($arScriptDir,$folder);
				}
				$path = implode('/',$arScriptDir);
			}
			$path = 'file://'.(substr($path,0,1)!='/' ? '/' : null).$path;
		}
		return $path;
	}
}