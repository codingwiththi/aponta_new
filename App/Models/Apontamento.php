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

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        return $this->$atributo = $valor;
    }


    public function salvar(){
        $query ="insert into dbo.Apontamento(Data_inicial,Data_final,num_chamado,FK_atividade_Id,FK_contrato_Id,FK_func_Id,FK_tipo_hora_Id)values(CONVERT(DATETIME,:dataInicial,126),CONVERT(DATETIME,:dataFinal,126),:numeroChamado,:fkAtividadeId,:fkContratoId,:fkFuncionarioId,:fkTipoHoraId)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal'));   
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->bindValue(':fkAtividadeId',$this->__get('fkAtividadeId'));
        $stmt->bindValue(':fkContratoId',$this->__get('fkContratoId'));
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->bindValue(':fkTipoHoraId',$this->__get('fkTipoHoraId'));
        $stmt->execute();
        print_r($this);
        return $this;
    }


    public function verificaExistencia(){
        $query = "select Id from apontamento where num_chamado =:numeroChamado,Data_inicial = :dataInicial and Data_final =:dataFinal";
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
        apontamento.Data_inicial,
        apontamento.Data_final,
        tipo_hora.tipo_hora,DATEDIFF(MINUTE, apontamento.Data_inicial,apontamento.Data_final) as duracao, apontamento.data_alteracao 
        FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
        JOIN contrato ON (apontamento.FK_contrato_Id = contrato.Id) 
        JOIN cliente ON (contrato.FK_cliente_Id = cliente.Id) 
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id) 
        WHERE apontamento.FK_func_Id = :fkFuncionarioId AND apontamento.data_alteracao >  DATEADD(DAY, -2 , GETDATE()) ";
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
        FK_tipo_hora_Id = :fkTipoHoraId
        where Id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal'));   
        $stmt->bindValue(':numeroChamado',$this->__get('numeroChamado'));
        $stmt->bindValue(':fkAtividadeId',$this->__get('fkAtividadeId'));
        $stmt->bindValue(':fkContratoId',$this->__get('fkContratoId'));
        $stmt->bindValue(':fkTipoHoraId',$this->__get('fkTipoHoraId'));
        $stmt->execute();
        
        return $this;
    }



    public function getAll(){
        $query = "SELECT apontamento.Id,
        apontamento.num_chamado,
        cliente.nome AS cliente,
        tipo_atividade.tipo_atividade,
        atividade.nome
        as atividade,
        apontamento.Data_inicial,
        apontamento.Data_final,
        tipo_hora.tipo_hora,
        DATEDIFF(minute,apontamento.Data_inicial,apontamento.Data_final) as duracao,
        apontamento.data_alteracao FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
        JOIN contrato ON (apontamento.FK_contrato_Id = contrato.Id) 
        JOIN cliente ON (contrato.FK_cliente_Id = cliente.Id) 
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id)
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
        tipo_atividade.tipo_atividade,
        atividade.nome
        as atividade,
        apontamento.Data_inicial,
        apontamento.Data_final,
        tipo_hora.tipo_hora,
        DATEDIFF(minute,apontamento.Data_inicial,apontamento.Data_final) as duracao,
        apontamento.data_alteracao FROM apontamento 
        JOIN tipo_hora ON (apontamento.FK_tipo_hora_Id = tipo_hora.Id) 
        JOIN funcionario ON (apontamento.FK_func_Id = funcionario.Id) 
        JOIN contrato ON (apontamento.FK_contrato_Id = contrato.Id) 
        JOIN cliente ON (contrato.FK_cliente_Id = cliente.Id) 
        JOIN atividade ON (apontamento.FK_atividade_Id = atividade.Id) 
        JOIN tipo_atividade ON (atividade.FK_tipo_ativ_Id = tipo_atividade.Id)
        WHERE apontamento.Data_inicial >= CONVERT(DATETIME,:dataInicial,126) 
        and apontamento.Data_inicial <= CONVERT(DATETIME,:dataFinal,126)
        and apontamento.FK_func_Id = :fkFuncionarioId";

        $stmt= $this->db->prepare($query);
        $stmt->bindValue(':fkFuncionarioId',$this->__get('fkFuncionarioId'));
        $stmt->bindValue(':dataInicial',$this->__get('dataInicial'));
        $stmt->bindValue(':dataFinal',$this->__get('dataFinal')); 
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }





}

?>

