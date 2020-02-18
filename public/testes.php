 <?php

// $x = '2019-03-15';
// echo date($x.'\TH:i:s');

$mes = '03';      // Mês desejado, pode ser por ser obtido por POST, GET, etc.
$ano = date("Y"); // Ano atual
$ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
echo $ultimo_dia ."<br>";
echo $ano_mes = date("Y-m") . "<br>"; // Ano atual

$d = array();
for($i=1;$i < $ultimo_dia + 1 ;$i++){
    //echo $i;
    $ii = (string) $i;
    echo "data str ". $ii;
    echo "data : " . $ano_mes = date("Y-m-$ii") . "<br>"; // Ano atual
    // $ano_mes = $ano_mes. "-$i";   
    // print($ano_mes);
    $x = "("."$ano"."$mes"."$ii".")";
    $semanaNr = date("d - l", strtotime(date($x)+ "1 DAY"));
    $d[$i] = $semanaNr;
    echo "<br>". $semanaNr ."<br>";
}
print_r($d);
// echo date('Y-m-d\TH:i:s')."</br>";


// $data = new DateTime();
// //print_r($data);
// echo $data->format('Y-m-d\TH:i:s');
// echo "<br>";



// $x = date('Y-m-d\TH:i:s', strtotime('+5 days'));
// echo $x;
// $date = date('Y-m-d\TH:i:s');
// echo $date;


// if('2020-01-22T19:20:20' < $x){
//     echo "ok";
// } -->


// $ldap_server = "10.150.1.7";
// $dominio = "@corp.nexa.com.br"; //Dominio local ou global
// $user = "CN=IronPort Service,OU=SERVICOS,OU=GERENCIAMENTO_GRUPOS,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br";
// //$user = "CN=Bruno Vicente do Nascimento,OU=USUARIOS,OU=WINTEL,OU=SUPORTE_ESPECIALIZADO,OU=JARDIM_CAMBURI,OU=GERENCIAMENTO_EMPRESA,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br";
// $u = "bvnascimento@corp.nexa.com.br";
// $ldap_porta = 389;
// $ldap_pass   = 'senhaTOSC@321';
// $ldapcon = ldap_connect($ldap_server,$ldap_porta) or die("nao foi possivel conectar LDAP server");


// ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION,3);
// ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);
// //print_r($ldapcon);
// //$person = "bvnascimento".$dominio;
// //-----------------------------------------------------------
// if ($ldapcon){

//     $bind = ldap_bind($ldapcon, $u, $ldap_pass) or die ("Não foi possível pesquisa no AD.");
//     print_r($bind);
//     if ($bind) {
//         echo "LDAP bind successful…";
//         $filter = "(samaccountname=bvnascimento*)";
//         $result = ldap_search($ldapcon,"OU=GERENCIAMENTO_EMPRESA,OU=NEXA TECNOLOGIA,DC=corp,DC=nexa,DC=com,DC=br",$filter) or exit("Unable to search");
// 		$entries = ldap_get_entries($ldapcon, $result);
		
// 		print "<pre>";
//         print_r ($entries);
// 		print "</pre>";

//     }else {
//         echo "LDAP bind failed…";

//     }

// }


?>