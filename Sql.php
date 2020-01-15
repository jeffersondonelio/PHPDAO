<?php

class Sql extends PDO {

	private $conn;
	
	public function __construct($data)
	{
		if(!empty($data)){
			$conect = $data['db_type'].":host=".$data['db_host'].";dbname=".$data['db_name'];
			$this->conn = new PDO($conect, $data['db_user'] , $data['db_pass']);
		}else{
			die("ERRO AO CONECTAR NO BANCO");
		}
	}

	private function setParams($statment,$parameters = array())
	{
		foreach($parameters as $key => $value){
			$this->setParam($key, $value);
		}
	} 

	private function setParam($statment,$key,$value)
	{
		$statment->bindParam($key, $value);
	} 

	public function query($rowQuery,$params = array())
	{
		$stmt = $this->conn->prepare($rowQuery);
		$this->setParams($stmt,$params);
		$stmt->execute();
		
		return $stmt;
	}
	
	public function select($rowQuery, $params = array()):array
	{
		$stmt = $this->query($rowQuery,$params);
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}

?>
