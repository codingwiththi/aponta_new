<?php

namespace App\Models;

use MF\Model\Model;


class Tipo_hora extends Model{
    private $id;
    private $tipo_hora;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo,$valor){
        return $this->$atributo = $valor;
    }

    public function getAll(){
        $query = "select id,tipo_hora from tipo_hora";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}


?>