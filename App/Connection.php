<?php

 namespace App;

// class Connection {

// 	public static function getDb() {
// 		try {

// 			$conn = new \PDO(
// 				"mysql:host=localhost;dbname=aponta;port=3306;charset=utf8",
// 				"root",
// 				"" 
// 			);

// 			return $conn;

// 		} catch (\PDOException $e) {
// 			//.. tratar de alguma forma ..//
// 		    echo "Drivers disponiveis: " . implode( ",", \PDO::getAvailableDrivers() );
//     		echo "\nErro: " . $e->getMessage();
// 			echo $e;
// 		}
// 	}
// }

class Connection {

	public static function getDb() {
		try {
			$servidor = "10.150.1.193";
		    $instancia = "DEV";
		    $porta = 50746;
		    $database = "aponta";
		    $usuario = "aponta";
		    $senha = "q1w2e3r4t5";

			$conn = new \PDO("sqlsrv:Server={$servidor},$porta;Database={$database}",$usuario,$senha);

			return $conn;

		} catch (\PDOException $e) {
			//.. tratar de alguma forma ..//
		    echo "Drivers disponiveis: " . implode( ",", \PDO::getAvailableDrivers() );
    		echo "\nErro: " . $e->getMessage();
			echo $e;
		}
	}
}















?>