<?php
class Database {
	private PDO $pdo;

	public function __construct(){
		try {
			$this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			));
		} catch (PDOException $error){
			echo $error->getMessage();
		}
	}

	public function query(string $query, array $params = []){
		$statement = $this->pdo->prepare($query);
		$statement->execute($params);
		return $statement;
	}

	public function selectQuery(string $query, array $params = []){
		return $this->query($query, $params)->fetchAll();
	}

	public function singleSelectQuery(string $query, array $params = []){
		return $this->query($query, $params)->fetch();
	}

	public function singleValueQuery(string $query, array $params = []){
		return $this->query($query, $params)->fetchColumn();
	}

	public function lastInsertId(){
		return $this->pdo->lastInsertId();
	}
}