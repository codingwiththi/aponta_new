<?php

namespace App\Models;

use MF\Model\Model;


class Cliente extends Model{
    private $id;
    private $CNPJ;
    private $nome;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        return $this->$atributo = $valor;
    }

    public function getAll(){
        //consultar no banco todo os clientes
        $query = "select id,CNPJ,nome from cliente";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
 
   }





}

?>