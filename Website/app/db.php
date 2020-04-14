<?php

use FFI\ParserException;

class DB
{
	private static $instance = null;
	private $conn = null;

	private function __construct()
	{
		try {
			$db_credentials = @parse_ini_file(configPath(), true)["database"];

			if ($db_credentials === null) {
				throw new Exception("File not found");
			}

			$host    = $db_credentials["host"];
			$db      = $db_credentials["databasename"];
			$user    = $db_credentials["username"];
			$pass    = $db_credentials["password"];
			$charset = "utf8mb4";

			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];

			$this->conn = new PDO($dsn, $user, $pass, $options);
		} catch (ParserException $exception) {
			throw $exception;
		} catch (PDOException $exception) {
			throw $exception;
		} catch (Exception $exception) {
			throw $exception;
		}
	}

	private static function Instance()
	{
		if (self::$instance == null) {
			self::$instance = new DB();
		}

		return self::$instance;
	}

	public static function Connection()
	{
		return DB::Instance()->conn;
	}
}
