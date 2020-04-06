<?php
class DB {
	private static $instance = null;
	private $conn = null;

	private function __construct()
	{
		$host    = "localhost";
		$db      = "happy_brides";
		$user    = "root";
		$pass    = "";
		$charset = "utf8mb4";

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
	  	];

		$this->conn = new PDO($dsn, $user, $pass, $options);
	}

	private static function Instance()
   {
		if (self::$instance == null)
		{
   		self::$instance = new DB();
   	}
 
   	return self::$instance;
	}

	private static function Connection() {
   	return DB::Instance()->conn;
	}
}
?>