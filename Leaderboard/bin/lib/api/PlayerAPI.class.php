<?php

// Generated by Haxe 3.3.0
class api_PlayerAPI {
	public function __construct() {}
	public function addPlayer() {
		$p = new db_Player();
		$data = php_Web::getParams();
		$p->name = $data->get("name");
		$p->location = $data->get("location");
		$p->value = 20;
		$p->date = Date::now();
		db_ConnectDatabase::Connect();
		$p->insert();
		db_ConnectDatabase::disconnect();
		php_Lib::hprint("player added");
	}
	function __toString() { return 'api.PlayerAPI'; }
}