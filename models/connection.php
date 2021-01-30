<?php
class Connection {

	var $servername = "localhost";
	var $username = "root";
	var $password = "";
	var $databaseName = "cms";
	var $connection;

	function createConnection() {
		$this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->databaseName);
		return $this->connection;
	}
	function closeConnection() {
		mysqli_close($this->connection);
	}
	function executeQuery($sql) {
		return mysqli_query($this->connection, $sql);	
	}
	function getLastInsertedId() {
		return mysqli_insert_id($this->connection);
	}

}

?>