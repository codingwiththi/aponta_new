<?php

namespace App;

class Connection {

	public static function getDb() {
		try {
		    $servidor = "SNE0193";
		    $instancia = "DEV";
		    $porta = 50746;
		    $database = "aponta";
		    $usuario = "bruno";
		    $senha = "q1w2e3r4t5";

			$conn = new \PDO("sqlsrv:Server={$servidor}\\{$instancia},{$porta};Database={$database}",$usuario,$senha);

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