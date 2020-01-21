<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

	public function autenticar(){
		// echo "cheguei no autenticar";
		//print_r($_POST);
		$ldap_server = "10.150.1.7";
        $ldap_porta = 389;
        $ldapcon = ldap_connect($ldap_server,$ldap_porta) or die("nao foi possivel conectar LDAP server");
        ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION,3);
		ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

		//---------------------------------------------------------------
		//verificar se usuario não existe


		$usuario = $_POST['matricula']."@corp.nexa.com.br";
		$password = $_POST['senha'];
		if ($ldapcon){
			$bind = ldap_bind($ldapcon, $usuario, $password);
			//print_r($bind);
			if ($bind) {
				echo "LDAP bind successful…";
				// $filter = "(samaccountname=*)";
				// $result = ldap_search($ldapcon,"OU=GERENCIAMENTO_EMPRESA,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br",$filter) or exit("Unable to search");
				// $entries = ldap_get_entries($ldapcon, $result);
				// print "<pre>";
				// print_r ($entries);
				// print "</pre>";
				//----------------------------------------
				$funcionario = Container::getModel('Funcionario');
				$funcionario->__set('matricula',$_POST['matricula']);
				//$funcionario->__set('senha',$_POST['senha']);
				//teste db 		
				$funcionario->autenticar();

				//print_r($funcionario);
				if($funcionario->__get('id') != '' && $funcionario->__get('nome')!=''){
					//echo "esse cara exite";
					session_start();
					session_start(); 
					$_SESSION['id']= $funcionario->__get('id');
					$_SESSION['nome']= $funcionario->__get('nome');
					header("Location:/apontamento");

				}else{
					//echo "tu nao exeite";
					header('Location:/?login=erro');
				}

			}else {
				header('Location:/?login=erro');
				//echo "LDAP bind falhou…";
			}
		
		}
		
		// $funcionario = Container::getModel('Funcionario');
		// $funcionario->__set('matricula',$_POST['matricula']);
		// $funcionario->__set('senha',$_POST['senha']);
		// //teste db 		
		// $funcionario->autenticar();

		// //print_r($funcionario);
		// if($funcionario->__get('id') != '' && $funcionario->__get('nome')!=''){
		// 	//echo "esse cara exite";
		// 	session_start();
		// 	session_start(); 
		// 	$_SESSION['id']= $funcionario->__get('id');
		// 	$_SESSION['nome']= $funcionario->__get('nome');
		// 	//header("Location:/apontamento");

		// }else{
		// 	//echo "tu nao exeite";
		// 	//header('Location:/?login=erro');
		// }
	}


	public function sair(){
		session_start();
		session_destroy();
		header("Location:/");
	}

}

?>