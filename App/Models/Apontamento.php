<?php

namespace App\Models;

use MF\Model\Model;


class Apontamento extends Model{

    private $id;
    private $dataInicial;
    private $dataFinal;
    private $numeroChamado;
    private $fkAtividadeId;
    private $fkContratoId;
    private $fkFuncionarioId;
    private $fkTipoHoraId;
    private $fkStatusId;
    private $editavel;
    private $data_editavel;
    private $descricao;


    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        return $this->$atributo = $valor;
    }


    public function salvar(){
        $query ="insert into dbo.Apontamento
        (Data_inicial,
        Data_final,
        num_chamado,
        FK_atividade_Id,
        FK_contrato_Id,
        FK_func_Id,
        FK_tipo_hora_Id,
        FK_status_Id,
        descricao
        )values
        (CONVERT(DATETIME,:dataInicial,126),
        CONVERT(DATETIME,:dataFinal,126),
        :numeroChamado,
        :fkAtividadeId,
        :fkContratoId,
        :fkFuncionarioId,
        :fkTipoHoraId,
        :fkStatusId,
        :descricao)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal'));   
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->bindValue(':fkAtividadeId',$this->__get('fkAtividadeId'));
        $stmt->bindValue(':fkContratoId',$this->__get('fkContratoId'));
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->bindValue(':fkTipoHoraId',$this->__get('fkTipoHoraId'));
        $stmt->bindValue(':fkStatusId',$this->__get('fkStatusId'));
        $stmt->bindValue(':descricao',$this->__get('descricao'));

        $stmt->execute();
        //print_r($this);
        // print_r($stmt->errorInfo());
        return $this;
    }


    public function verificaExistencia(){
        $query = "select Id 
        from apontamento 
        where num_chamado =:numeroChamado,
        Data_inicial = :dataInicial 
        and Data_final =:dataFinal";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal'));   
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }



    public function Recentes(){;
        $query="SELECT apontamento.Id,
        apontamento.num_chamado,
        cliente.nome AS cliente,
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
        FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
        JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
        JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
        JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id)  
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id) 
        join status on (Apontamento.FK_status_Id =  status.id)
        WHERE (apontamento.FK_func_Id = :fkFuncionarioId 
        AND apontamento.data_alteracao >  DATEADD(DAY, -2 , GETDATE())) 
        OR ( editavel = 1 AND apontamento.data_editavel > DATEADD(DAY, -2 , GETDATE()) AND apontamento.FK_func_Id = :fkFuncionarioId  ) 
        order by apontamento.Data_inicial";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function excluir(){
        $query = "delete from apontamento where Id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute();
        return $this;
    }

    public function update(){
        $query = "update apontamento set num_chamado = :numeroChamado,
        Data_inicial = CONVERT(DATETIME,:dataInicial,126),Data_final=CONVERT(DATETIME,:dataFinal,126),
        FK_atividade_Id = :fkAtividadeId,
        FK_contrato_Id = :fkContratoId,
        FK_tipo_hora_Id = :fkTipoHoraId,
        FK_status_Id = :fkStatusId,
        descricao = :descricao
        where Id=:id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal'));   
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->bindValue(':fkAtividadeId',$this->__get('fkAtividadeId'));
        $stmt->bindValue(':fkContratoId',$this->__get('fkContratoId'));
        $stmt->bindValue(':fkTipoHoraId',$this->__get('fkTipoHoraId'));
        $stmt->bindValue(':fkStatusId',$this->__get('fkStatusId'));
        $stmt->bindValue(':descricao',$this->__get('descricao'));


        $stmt->execute();
        
        return $this;
    }



    public function getAll(){
        $query = "SELECT apontamento.Id,
        case
		when LEN(LTRIM(RTRIM(apontamento.num_chamado))) = 0
			then CONVERT(VARCHAR(40),Apontamento.Id)
		else apontamento.num_chamado 
        end as num_chamado,
        cliente.nome AS cliente,
        status.status,
        atividade.nome
        as atividade,
        convert(varchar, apontamento.Data_inicial ,120) AS  Data_inicial,
        convert(varchar, apontamento.Data_final ,120) AS  Data_final,
        tipo_hora.tipo_hora,
        apontamento.FK_status_Id,
        DATEDIFF(HOUR,apontamento.Data_inicial,apontamento.Data_final) as duracao,
        apontamento.data_alteracao FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
		JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
        JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
        JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id) 
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id)
        join status on (Apontamento.FK_status_Id =  status.id)
        WHERE apontamento.FK_func_Id = :fkFuncionarioId";

        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        


    }

    public function getPorIntervalo(){
        $query = "SELECT apontamento.Id,
        apontamento.num_chamado,
        cliente.nome AS cliente,
        status.status,
        atividade.nome
        as atividade,
        convert(varchar, apontamento.Data_inicial ,120) AS  Data_inicial,
        convert(varchar, apontamento.Data_final ,120) AS  Data_final,
        tipo_hora.tipo_hora,
        DATEDIFF(HOUR,apontamento.Data_inicial,apontamento.Data_final) as duracao,
        apontamento.data_alteracao FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
		JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
        JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
        JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id)
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id)
        join status on (Apontamento.FK_status_Id =  status.id)
        WHERE apontamento.Data_inicial >= CONVERT(DATETIME,:dataInicial,126) 
        and apontamento.Data_inicial <= CONVERT(DATETIME,:dataFinal,126)
        and apontamento.FK_func_Id = :fkFuncionarioId";

        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal')); 
        $stmt->execute();
       // echo $query;
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }



    public function  aceitaPendente(){
        $query = "update apontamento set 
        FK_status_Id = 2
        where Id=:id";
        $stmt = $this->db->prepare($query);
        if(!$stmt){
            return $db->errorInfo();
        }
        
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute();
        
        return $this;

    }

    
    public function  getApontamentosDia(){
        try {

        $query = "SELECT  
        apontamento.Id,
        apontamento.FK_func_Id,
        case
		when LEN(LTRIM(RTRIM(apontamento.num_chamado))) = 0
			then CONVERT(VARCHAR(40),Apontamento.Id)
		else apontamento.num_chamado 
        end as numero_chamado_OU_id,
        Atividade.nome as tipo,
        status.status,
        convert(varchar, apontamento.Data_inicial ,120) AS  Data_inicial,
        convert(varchar, apontamento.Data_final ,120) AS  Data_final,
        DATEDIFF(HOUR, apontamento.Data_inicial,apontamento.Data_final) as duracao,
        (SELECT SUM(DATEDIFF(HOUR, apontamento.Data_inicial,apontamento.Data_final ))
		from Apontamento
		where Data_inicial >  DATEADD(day, DATEDIFF(day, 0, GETDATE()), 0)) as total
        FROM Apontamento join Atividade on (Apontamento.FK_atividade_Id = Atividade.id)
        join status on (Apontamento.FK_status_Id =  status.id)
        where Data_inicial >  DATEADD(day, DATEDIFF(day, 0, GETDATE()), 0) 
        and apontamento.FK_func_Id = :fkFuncionarioId";
        $stmt = $this->db->prepare($query);
        if(!$stmt){
            return $db->errorInfo();
        }
        // $stmt->bindValue($data,$this->__get('id'));
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
    		echo "\nErro: " . $e->getMessage();
			return $e;
		}



    }
    

    public function tornarEditavel(){
        // zero nao é editavell
        // 1 é editavels
        $query = "update apontamento set 
        editavel = 1,
        FK_status_Id = 3,
        data_editavel = GETDATE()
        where Id=:id";
        $stmt = $this->db->prepare($query);
        if(!$stmt){
            return $db->errorInfo();
        }
        
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->bindValue(':data_editavel',$this->__get('data_editavel'));

        $stmt->execute();
        
        return $this;

    }

    public function getPorNumeroChamado(){

        $query="SELECT apontamento.Id,
        apontamento.num_chamado,
        funcionario.displayName as nome,
        cliente.nome AS cliente,
        status.status,
        atividade.nome as atividade,
        apontamento.Data_inicial,
        tipo_hora.tipo_hora,
        DATEDIFF(HOUR, apontamento.Data_inicial,apontamento.Data_final) as duracao, 
        apontamento.data_alteracao 
        FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
        JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
        JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
        JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id)
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id)
        join status on (Apontamento.FK_status_Id =  status.id) 
        WHERE apontamento.num_chamado = :numeroChamado  ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    

    public function getPorNumeroChamadoOuId($id){

        $query="SELECT apontamento.Id,
        apontamento.num_chamado,
        case
		when LEN(LTRIM(RTRIM(apontamento.num_chamado))) = 0
			then CONVERT(VARCHAR(40),Apontamento.Id)
		else apontamento.num_chamado 
        end as numero_chamado_OU_id,
        funcionario.displayName as nome,
        cliente.nome AS cliente,
        status.status,
        atividade.nome as atividade,
        apontamento.Data_inicial,
        tipo_hora.tipo_hora,
        DATEDIFF(HOUR, apontamento.Data_inicial,apontamento.Data_final) as duracao, 
        apontamento.data_alteracao 
        FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
        JOIN Cliente_Contrato on (Apontamento.FK_contrato_Id = Cliente_Contrato.Id)
        JOIN cliente ON (Cliente_Contrato.Fk_cliente_Id = cliente.Id)
        JOIN Contrato ON (Cliente_Contrato.Fk_contrato_Id = Contrato.Id)
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id)
        join status on (Apontamento.FK_status_Id =  status.id) 
        WHERE apontamento.num_chamado = :numeroChamado or apontamento.Id =$id";
        //echo $query;
        //echo $this->__get('numeroChamado');
        $stmt = $this->db->prepare($query);
        //$id = intval($this->__get('numeroChamado'));
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }








    public function getMensal($intervalo, $manager){
        $query = "SELECT * from (
            SELECT
            Funcionario.displayName AS nome,
                    convert(varchar(MAX),apontamento.Data_inicial,103) as data ,
                    SUM(DATEDIFF(hour,apontamento.Data_inicial,apontamento.Data_final)) as duracao
                 FROM apontamento 
                    JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
                    WHERE manager like ?
                    GROUP BY 
                    apontamento.Data_inicial,Funcionario.displayName) em_linha
                    pivot (sum(duracao) for data in ($intervalo)) em_colunas order by 1";
        //echo $query;
        $stmt= $this->db->prepare($query);
        $stmt->bindValue(1,"%" . $manager . "%");

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }







    public function getMensalFuncionario($intervalo){
        $query = "SELECT * from (
            SELECT
            Funcionario.id,
            Funcionario.displayName AS nome,
                    convert(varchar(MAX),apontamento.Data_inicial,103) as data ,
                    SUM(DATEDIFF(hour,apontamento.Data_inicial,apontamento.Data_final)) as duracao
                 FROM apontamento 
                    JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
                    WHERE apontamento.FK_func_Id = :fkFuncionarioId
                    GROUP BY 
                    apontamento.Data_inicial,Funcionario.displayName, funcionario.id) em_linha
                    pivot (sum(duracao) for data in ($intervalo)) em_colunas order by 1";
        //echo $query;

        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

















    
}

?>

