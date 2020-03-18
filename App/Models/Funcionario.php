<?php

namespace App\Models;

use MF\Model\Model;


class Funcionario extends Model{
	private $id;
	private $nome;
	private $matricula;
	private $senha;
	private $manager;
	private $fk_id_supervisionado;
	
	
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
		$query = "select id,displayName as nome,SamAccountName from funcionario where SamAccountName =:matricula";
		$stmt = $this->db->prepare($query);

		$stmt->bindValue(':matricula',$this->__get('matricula'));
		//$stmt->bindValue(':senha',$this->__get('senha'));
		$stmt->execute();

		$funcionario= $stmt->fetch(\PDO::FETCH_ASSOC);
		// return $funcionario;

		if($funcionario['id'] != '' && $funcionario['nome'] !=''){
			$this->__set('id',$funcionario['id']);
			$this->__set('nome',$funcionario['nome']);

		}
		return $funcionario;

	}

	public function isManager(){
		$query = "with 
		managers as 
		(select distinct manager from Funcionario)
		select count(manager) as manager from managers where manager LIKE ? ";
		$stmt = $this->db->prepare($query);
		$nome = $this->__get('nome');
		$stmt->bindValue(1,"%" . $nome . "%");
		$stmt->execute();
		$manager= $stmt->fetch(\PDO::FETCH_ASSOC);


		return $manager;

	}

//  public function testedb(){
//        $query = "select @@version";
//        $stmt= $this->db->prepare($query);
//        $stmt->execute();
//        return $stmt->fetch(\PDO::FETCH_ASSOC);
	
//    }
public function getPendentesManager (){
    $query = "select apontamento.id,
                funcionario.displayName as nome,
                apontamento.num_chamado,
                DATEDIFF(minute,apontamento.Data_inicial,apontamento.Data_final) as duracao,
                apontamento.Data_inicial,
                funcionario.department,
                cliente.nome AS cliente
                from apontamento inner join status on (Apontamento.FK_status_Id = status.id) 
                inner join Funcionario on (Apontamento.FK_func_Id = Funcionario.id)
                inner join Contrato on ( Apontamento.FK_contrato_Id = Contrato.Id)
                JOIN cliente ON (contrato.FK_cliente_Id = cliente.Id) 
                where status.id =2 and Funcionario.manager like ?";
        $stmt= $this->db->prepare($query);
        $nome = 'Vinicius Detoni Capelli Soares';//$this->__get('nome');
        //return $nome;
		$stmt->bindValue(1,"%" . $nome . "%");
		$stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	} 
	

	public function getPendentesByFunc(){
        $query = "select apontamento.id,
                funcionario.displayName as nome,
                apontamento.num_chamado,
				DATEDIFF(minute,apontamento.Data_inicial,apontamento.Data_final) as duracao,
								apontamento.Data_inicial,
								funcionario.department,
								cliente.nome AS cliente
								from apontamento inner join status on (Apontamento.FK_status_Id = status.id)
								inner join Funcionario on (Apontamento.FK_func_Id =
				Funcionario.id)
								inner join Contrato on ( Apontamento.FK_contrato_Id =
				Contrato.Id)
                JOIN cliente ON (contrato.FK_cliente_Id =  cliente.Id)
                where status.id =2 and Funcionario.id = :fk_id_supervisionado";

        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':fk_id_supervisionado',$this->__get('fk_id_supervisionado'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }




	public function GetFuncByManager(){

	$query = "SELECT id,displayName as nome FROM funcionario WHERE manager like ? order by 2";
	$stmt= $this->db->prepare($query);
	$nome ='Vinicius Detoni Capelli Soares';//$this->__get('nome');
	$stmt->bindValue(1,"%" . $nome . "%");
	$stmt->execute();

	return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}






	

}


?>