<?php

require_once "config.php";
/*
$sql = new Sql($db_data);

$query = "SELECT * FROM tb_usuarios ORDER BY deslogin;";
$users = $sql->select($query);

echo "<pre>";
print_r($users);
echo "</pre>";


$users = Users::search('root');
echo "<pre>";
print_r($users);
echo "</pre>";
*/

$users = new Users();
$users->deslogin = 'teste1'; 
$users->dessenha = 'teste1'; 
$users->insert();

echo "<pre>";
print_r($users);
echo "</pre>";
?>
