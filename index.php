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
/*
 * INSERT
$users = new Users();
$users->deslogin = 'teste1'; 
$users->dessenha = 'teste1'; 
$users->insert();
*/

$users = new Users();
$users->loadById('2');
echo "<pre>";
print_r($users);
echo "</pre>";

$users->delete();
echo "<pre>";
print_r($users);
echo "</pre>";
?>
