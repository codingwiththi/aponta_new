<?php

namespace App\Models;

use MF\Model\Model;


class Contrato extends Model{
    private $id;
    private $contrato;
    private $fk_cliente_id;


    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo,$valor){
        return $this->$atributo = $valor;
    }

    public function getPorCliente(){
        $query = "select Cliente_Contrato.id,Contrato.contrato, Cliente_Contrato.Fk_cliente_Id from cliente 
        join Cliente_Contrato on (Cliente_Contrato.Fk_cliente_Id = Cliente.Id)
        join Contrato on (contrato.Id = Cliente_Contrato.Fk_contrato_Id)
        where Cliente_Contrato.Fk_cliente_Id =  :fk_cliente_id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":fk_cliente_id",$this->__get("fk_cliente_id"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}