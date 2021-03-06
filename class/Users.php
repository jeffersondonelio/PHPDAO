<?php

class Users {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

    public function __get($property) {
        //-var_dump(__METHOD__);
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        //-var_dump(__METHOD__);
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
	
	public function __toString()
	{
		return json_encode(array(
			"idusuario" => $this->idusuario,
			"deslogin" => $this->deslogin,
			"dessenha" => $this->dessenha,
			"dtcadastro" => $this->dtcadastro
		));
	}

	public function setData($row)
	{
		if(isset($row)){
			foreach($row as $key => $value){
				if($key == "dtcadastro"){
					$dt = new DateTime($value);
					$this->$key = $dt->format("d/m/Y H:i:s");
				}else{
					$this->$key = $value;
				}
			}
		}
		
	}

	public function loadById($id)
	{
		$sql = new Sql();
		$query = " SELECT * FROM tb_usuarios WHERE idusuario = :ID";
		$results = $sql->select($query,array(":ID" => $id));
		$this->setData($results[0]);
	}
	
	public static function getList()
	{
		$sql = new Sql();
		$query = "SELECT * FROM tb_usuarios ORDER BY idusuario";
		$results = $sql->select($query);
		return $results;
	}
	
	public static function search($login)
	{
		$sql = new Sql();
		$query = "SELECT * FROM tb_usuarios WHERE deslogin LIKE :LOGIN ";
		$results = $sql->select($query,array(":LOGIN" => '%'.$login.'%'));
		return $results;
	}
	
	public function login($login,$pass)
	{
		$sql = new Sql();
		$query = "SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASS ";
		$results = $sql->select($query,array(":LOGIN" => $login,":PASS" => $pass));
		if(count($results)){
			return $results;
		}else{
			throw new Exception("Login e/ou senha incorretos");
		}
	}
		
	public function insert()
	{
		$sql = new Sql();
		/*
		CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_users_insert`(
			pdeslogin varchar(64),
			pdessenha varchar(256)
		)
		BEGIN

			INSERT INTO tb_usuarios (deslogin,dessenha) VALUE (pdeslogin,pdessenha);
			
			SELECT * FROM tb_usuarios WHERE idusuario = last_insert_id();

		END
		*/
		$results = $sql->select("CALL sp_users_insert(:LOGIN,:PASS)",array(
			":LOGIN" => $this->deslogin,
			":PASS" => $this->dessenha
		));

		if(count($results)){
			return $this->setData($results[0]);
		}
	}
	
	public function update($login,$pass)
	{
		$this->deslogin = $login;
		$this->dessenha = $pass;
		
		$query = "UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASS WHERE idusuario = :ID";
		$parameters = array(
			":LOGIN" => $this->deslogin,
			":PASS" => $this->dessenha, 
			":ID" => $this->idusuario
		);
		
		$sql = new Sql();
		$sql->query($query,$parameters);
	}

	public function delete()
	{
		$query = "delete from tb_usuarios WHERE idusuario = :ID;";
		$parameters = array(":ID" => $this->idusuario);

		$sql = new Sql();
		$sql->query($query,$parameters);
		
		$this->idusuario = null;
		$this->deslogin = null;
		$this->dessenha = null;
		$this->dtcadastro = null;
		
	}
}

?>
