<?php 

namespace HOdonto\DB;

class Sql {

	private $conn;

	public function __construct()
	{
		$this->conn = new \PDO(
			getenv('DB_DRIVE').":dbname=".getenv('DB_DBNAME').";host=".getenv('DB_HOSTNAME').";PORT=".getenv('DB_PORT'), 
			getenv('DB_USERNAME'),
			getenv('DB_PASSWORD')
		);
	}

	private function setParams($statement, $parameters = array())
	{
		foreach ($parameters as $key => $value) {		
			$this->bindParam($statement, $key, $value);
		}
	}

	private function bindParam($statement, $key, $value)
	{
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array())
	{
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
	}

	public function select($rawQuery, $params = array()):array
	{
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

}

 ?>