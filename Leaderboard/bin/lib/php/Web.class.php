<?php

// Generated by Haxe 3.3.0
class php_Web {
	public function __construct(){}
	static function getParams() {
		$a = array_merge($_GET, $_POST);
		$tmp = get_magic_quotes_gpc();
		if($tmp) {
			reset($a); while(list($k, $v) = each($a)) $a[$k] = stripslashes((string)$v);
		}
		return php_Lib::hashOfAssociativeArray($a);
	}
	static function getURI() {
		$s = $_SERVER['REQUEST_URI'];
		$tmp = _hx_explode("?", $s);
		return $tmp[0];
	}
	static $isModNeko;
	function __toString() { return 'php.Web'; }
}
php_Web::$isModNeko = !php_Lib::isCli();
