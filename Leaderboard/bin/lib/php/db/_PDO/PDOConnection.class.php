<?php

// Generated by Haxe 3.3.0
class php_db__PDO_PDOConnection implements sys_db_Connection{
	public function __construct($dsn, $user = null, $password = null, $options = null) {
		if(!php_Boot::$skip_constructor) {
		if(null === $options) {
			$this->pdo = new PDO($dsn, $user, $password);
		} else {
			$arr = array();
			{
				$_g = 0;
				$_g1 = Reflect::fields($options);
				while($_g < $_g1->length) {
					$key = $_g1[$_g];
					++$_g;
					$tmp = Reflect::field($options, $key);
					$arr[$key] = $tmp;
					unset($tmp,$key);
				}
			}
			$this->pdo = new PDO($dsn, $user, $password, $arr);
		}
		$this->dbname = _hx_explode(":", $dsn)->shift();
		{
			$_g2 = strtolower($this->dbname);
			switch($_g2) {
			case "mysql":{
				$this->dbname = "MySQL";
			}break;
			case "sqlite":{
				$this->dbname = "SQLite";
			}break;
			}
		}
	}}
	public $pdo;
	public $dbname;
	public function close() {
		$this->pdo = null;
		unset($this->pdo);
	}
	public function request($s) {
		$tmp = PDO::PARAM_STR;
		$result = $this->pdo->query($s, $tmp);
		$tmp1 = ($result === false);
		if($tmp1) {
			$a = $this->pdo->errorInfo();
			$info = new _hx_array($a);
			$tmp2 = "Error while executing " . _hx_string_or_null($s) . " (";
			$tmp3 = $info[2];
			$tmp4 = Std::string($tmp3);
			throw new HException(_hx_string_or_null($tmp2) . _hx_string_or_null($tmp4) . ")");
		}
		$db = strtolower($this->dbname);
		if($db === "sqlite") {
			return new php_db__PDO_AllResultSet($result, new php_db__PDO_DBNativeStrategy($db));
		} else {
			return new php_db__PDO_PDOResultSet($result, new php_db__PDO_PHPNativeStrategy());
		}
	}
	public function quote($s) {
		$tmp = _hx_index_of($s, "\x00", null);
		if($tmp >= 0) {
			$tmp1 = $this->base16_encode($s);
			return "x'" . _hx_string_or_null($tmp1) . "'";
		}
		return $this->pdo->quote($s, null);
	}
	public function addValue($s, $v) {
		$tmp = null;
		$tmp1 = !is_int($v);
		if($tmp1) {
			$tmp = is_null($v);
		} else {
			$tmp = true;
		}
		if($tmp) {
			$s->add($v);
		} else {
			$tmp2 = is_bool($v);
			if($tmp2) {
				$tmp3 = null;
				if($v) {
					$tmp3 = 1;
				} else {
					$tmp3 = 0;
				}
				$s->add($tmp3);
			} else {
				$tmp4 = Std::string($v);
				$tmp5 = $this->quote($tmp4);
				$s->add($tmp5);
			}
		}
	}
	public function lastInsertId() {
		$tmp = $this->pdo->lastInsertId(null);
		return Std::parseInt($tmp);
	}
	public function dbName() {
		return $this->dbname;
	}
	public function base16_encode($str) {
		$str = unpack("H" . _hx_string_rec(2 * strlen($str), ""), $str);
		$str = chunk_split($str[1]);
		return $str;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'php.db._PDO.PDOConnection'; }
}
