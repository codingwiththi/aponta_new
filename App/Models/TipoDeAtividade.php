<?php

namespace App\Models;

use MF\Model\Model;


class TipoDeAtividade extends Model{
    private $id;
    private $tipoAtividade;

    public function __get($atributo){
		return $this->$atributo; 
	}

	public function __set($atributo,$valor){
		return $this->$atributo = $valor;
    }
    
    public function getAll(){
        //consultar no banco todo os tipos de atividades
        $query = "select id,tipo_atividade from tipo_atividade";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }




}


?>