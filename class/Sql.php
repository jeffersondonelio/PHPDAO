<?php

class Sql extends PDO {

	private $conn;
	private $db_type = 'mysql';
	private $db_host = 'localhost';
	private $db_name = 'dbphp7';
	private $db_user = 'root';
	private $db_pass = 'root';
	
	public function __construct()
	{
		$conect = $this->db_type.":host=".$this->db_host.";dbname=".$this->db_name;
		$this->conn = new PDO($conect, $this->db_user , $this->db_pass);
	}

	private function setParams($statement,$parameters = array())
	{
		if(!empty($parameters)){
			foreach($parameters as $key => $value){
				$this->setParam($statement,$key, $value);
			}
		}
	} 

	private function setParam($statement,$key,$value)
	{
		$statement->bindParam($key, $value);
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
