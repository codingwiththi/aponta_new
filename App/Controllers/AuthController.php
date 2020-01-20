<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

	public function autenticar(){
		// echo "cheguei no autenticar";
		//print_r($_POST);
		$funcionario = Container::getModel('Funcionario');
		$funcionario->__set('matricula',$_POST['matricula']);
		$funcionario->__set('senha',$_POST['senha']);
		//teste db 		
		$funcionario->autenticar();

		//print_r($funcionario);
		if($funcionario->__get('id') != '' && $funcionario->__get('nome')!=''){
			//echo "esse cxara exite";
			session_start();

			session_start(); 
			$_SESSION['id']= $funcionario->__get('id');
			$_SESSION['nome']= $funcionario->__get('nome');
			header("Location:/apontamento");

		}else{
			//echo "tu nao exeite";
			header('Location:/?login=erro');
		}
	}


	public function sair(){
		session_start();
		session_destroy();
		header("Location:/");
	}

}

?>