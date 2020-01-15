<?php
//-AUTOLOAD
spl_autoload_register(function($nameClass){
	
	$filename = str_replace ("\\", "/", $nameClass . ".php");
	
	if(file_exists($filename)) require_once $filename;

});

$db_data = array(
	"db_type" => 'mysql',
	"db_host" => 'localhost',
	"db_name" => 'dbphp7',
	"db_user" => 'root',
	"db_pass" => 'root'
);
?>
