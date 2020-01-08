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

}


?>

