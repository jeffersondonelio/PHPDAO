<?php

require_once "config.php";

$sql = new Sql($db_data);

$query = "SELECT * FROM tb_usuarios ORDER BY deslogin;";
$users = $sql->select($query);

echo "<pre>";
print_r($users);
echo "</pre>";
?>
