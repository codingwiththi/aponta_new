<?php

namespace App\Models;

use MF\Model\Model;


class Funcionario extends Model{
	private $id;
	private $nome;
	private $matricula;
	private $senha;

	public function __get($atributo){
		return $this->$atributo; 
	}

	public function __set($atributo,$valor){
		return $this->$atributo = $valor;
	}


	// public function salvar(){
	// 	$query = "insert into Funcionario (nome,matricula,senha) values(:nome,:matricula,:senha)";

	// 	$stmt = $this->db->prepare($query);
	// 	$stmt->bindValue(':nome',$this->__get('nome'));
	// 	$stmt->bindValue(':matricula',$this->__get('matricula'));
	// 	$stmt->bindValue(':senha',$this->__get('senha'));
	// 	$stmt->execute();
	// return $this;

	// }

	public function autenticar(){
		$query = "select id,nome,matricula from funcionario where matricula =:matricula and senha = :senha";
		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':matricula',$this->__get('matricula'));
		$stmt->bindValue(':senha',$this->__get('senha'));
		$stmt->execute();

		$funcionario= $stmt->fetch(\PDO::FETCH_ASSOC);
		// return $funcionario;

		if($funcionario['id'] != '' && $funcionario['nome'] !=''){
			$this->__set('id',$funcionario['id']);
			$this->__set('nome',$funcionario['nome']);

		}


		return $funcionario;

	}


	    public function testedb(){
        $query = "select @@version";
        $stmt= $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fectAll(\PDO::FETCH_ASSOC);


    }






	

}


?>