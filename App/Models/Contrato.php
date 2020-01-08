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
        $query = "select id,contrato, FK_cliente_Id from contrato where FK_cliente_Id= :fk_cliente_id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":fk_cliente_id",$this->__get("fk_cliente_id"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}