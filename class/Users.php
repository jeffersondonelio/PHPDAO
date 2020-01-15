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

	public function loadById($id)
	{
		global $db_data;
		$sql = new Sql($db_data);
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
	
	public function __toString()
	{
		return json_encode(array(
			"idusuario" => $this->idusuario,
			"deslogin" => $this->deslogin,
			"dessenha" => $this->dessenha,
			"dtcadastro" => $this->dtcadastro
		));
	}

}

?>
