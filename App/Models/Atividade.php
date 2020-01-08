<?php

namespace App\Models;

use MF\Model\Model;


class Atividade extends Model{
    private $id;
    private $fk_tipoAtividade;
    private $nome;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        return $this->$atributo = $valor;
    }

    public function getPorTipo(){
        $query ="select id,nome from atividade where FK_tipo_ativ_Id = :fk_tipoAtividade" ;
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':fk_tipoAtividade',$this->__get('fk_tipoAtividade'));
        $stmt->execute();


        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}

?>