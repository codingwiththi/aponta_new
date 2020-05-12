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
    $query = "SELECT apontamento.Id,
	apontamento.num_chamado,
	cliente.nome AS cliente,
	funcionario.displayName as nome,
	contrato.contrato as contrato,
	funcionario.department,
	tipo_atividade.tipo_atividade,
	atividade.nome as atividade,
	convert(varchar, apontamento.Data_inicial ,120) AS  Data_inicial,
	convert(varchar, apontamento.Data_final ,120) AS  Data_final,
	status.status,
	apontamento.FK_status_Id,
	tipo_hora.tipo_hora,
	DATEDIFF(HOUR, apontamento.Data_inicial,apontamento.Data_final) as duracao,
	apontamento.data_alteracao,
	apontamento.descricao
	from apontamento
		JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
		JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
		JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
		JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
		JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id)  
		JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
		JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id) 
		join status on (Apontamento.FK_status_Id =  status.id)
                where status.id =1 and Funcionario.manager like ?";
        $stmt= $this->db->prepare($query);
        $nome = 'Vinicius Detoni Capelli Soares';//$this->__get('nome') ; ////
        //return $nome;
		$stmt->bindValue(1,"%" . $nome . "%");
		$stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	} 
	

	public function getPendentesByFunc(){
        $query = "SELECT apontamento.Id,
						apontamento.num_chamado,
						cliente.nome AS cliente,
						contrato.contrato as contrato,
						funcionario.displayName as nome,
						funcionario.department,
						tipo_atividade.tipo_atividade,
						atividade.nome as atividade,
						convert(varchar, apontamento.Data_inicial ,120) AS  Data_inicial,
						convert(varchar, apontamento.Data_final ,120) AS  Data_final,
						status.status,
						apontamento.FK_status_Id,
						tipo_hora.tipo_hora,
						DATEDIFF(HOUR, apontamento.Data_inicial,apontamento.Data_final) as duracao,
						apontamento.data_alteracao,
						apontamento.descricao
						from apontamento
				JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
				JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
				JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
				JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
				JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id)  
				JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
				JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id) 
				join status on (Apontamento.FK_status_Id =  status.id)
                where status.id =1 and Funcionario.id = :fk_id_supervisionado";

        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':fk_id_supervisionado',$this->__get('fk_id_supervisionado'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }




	public function GetFuncByManager(){

	$query = "SELECT id,displayName as nome FROM funcionario WHERE manager like ? order by 2";
	$stmt= $this->db->prepare($query);
	$nome = 'Vinicius Detoni Capelli Soares';// $this->__get('nome');//
	$stmt->bindValue(1,"%" . $nome . "%");
	$stmt->execute();

	return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}






	

}


?>