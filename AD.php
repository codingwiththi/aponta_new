<?php

Namespace App;



class ConnectionAD {



    public function ConectaAD(){
        $ldap_server = "10.150.1.7";
        $user = "CN=IronPort Service,OU=SERVICOS,OU=GERENCIAMENTO_GRUPOS,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br";
        $ldap_porta = 389;
        $ldapcon = ldap_connect($ldap_server,$ldap_porta) or die("nao foi possivel conectar LDAP server");
        ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

        return $ldapcon;
    }


    public function IJI(){
        $bind = ldap_bind($ldapcon, $user, $ldap_pass) or die (" Usuario ou senha incorreta, erro ao pesquisar no AD.");

    }



}



?>