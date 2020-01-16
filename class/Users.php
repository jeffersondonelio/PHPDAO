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

	public function loadById($id)
	{

		$sql = new Sql();
		$query = " SELECT * FROM tb_usuarios WHERE idusuario = :ID";
		$results = $sql->select($query,array(":ID" => $id));
	
		if(isset($results[0])){
			$row = $results[0];

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

}

?>
