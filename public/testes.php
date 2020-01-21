<?php

$ldap_server = "10.150.1.7";
//$dominio = "@corp.nexa.com.br"; //Dominio local ou global
//$user = "CN=IronPort Service,OU=SERVICOS,OU=GERENCIAMENTO_GRUPOS,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br";
//$user = "CN=Bruno Vicente do Nascimento,OU=USUARIOS,OU=WINTEL,OU=SUPORTE_ESPECIALIZADO,OU=JARDIM_CAMBURI,OU=GERENCIAMENTO_EMPRESA,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br";
//$u = "bvnascimento@corp.nexa.com.br";
$ldap_porta = 389;
//$ldap_pass   = 'qefef
$ldapcon = ldap_connect($ldap_server,$ldap_porta) or die("nao foi possivel conectar LDAP server");


ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION,3);
ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);
//print_r($ldapcon);
//$person = "bvnascimento".$dominio;
//-----------------------------------------------------------
if ($ldapcon){

    $bind = ldap_bind($ldapcon, $u, $ldap_pass) or die ("Não foi possível pesquisa no AD.");
    print_r($bind);
    if ($bind) {
        echo "LDAP bind successful…";
        $filter = "(samaccountname=B*)";
        $result = ldap_search($ldapcon,"OU=GERENCIAMENTO_EMPRESA,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br",$filter) or exit("Unable to search");
		$entries = ldap_get_entries($ldapcon, $result);
		
		print "<pre>";
        print_r ($entries);
		print "</pre>";

    }else {
        echo "LDAP bind failed…";

    }

}


?>