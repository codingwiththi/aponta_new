 <!-- <?php

 
// /**
//  * PHP encrypt and decrypt example
//  *
//  * Simple method to encrypt or decrypt a plain text string initialization
//  * vector(IV) has to be the same when encrypting and decrypting in PHP 5.4.9.
//  *
//  * @link http://naveensnayak.wordpress.com/2013/03/12/simple-php-encrypt-and-decrypt/
//  *
//  * @param string $action Acceptable values are `encrypt` or `decrypt`.
//  * @param string $string The string value to encrypt or decrypt.
//  * @return string
//  */
// function encrypt_decrypt($action, $string)
// {
//   $output = false;
 
//   $encrypt_method = "AES-256-CBC";
//   $secret_key = 'This is my secret key';
//   $secret_iv = 'This is my secret iv';
 
//   // hash
//   $key = hash('sha256', $secret_key);
 
//   // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
//   // warning
//   $iv = substr(hash('sha256', $secret_iv), 0, 16);
 
//   if ($action == 'encrypt')
//   {
//     $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
//     $output = base64_encode($output);
//   }
//   else
//   {
//     if ($action == 'decrypt')
//     {
//       $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
//     }
//   }
 
//   return $output;
// }
 
 
// //
// // usage
// //
 
// $plain_txt = "This is my plain text";
// echo "Plain Text = $plain_txt\\n";
 
// $encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
// echo "Encrypted Text = $encrypted_txt\n";
 
// $decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
// echo "Decrypted Text = $decrypted_txt\n";
 
// if ($plain_txt === $decrypted_txt)
//   echo "SUCCESS";
// else
//   echo "FAILED";
 
// echo "\n";
 

// //  $y = '2019-03-15';
// //  echo date($y.'\TH:i:s');
// // $x = sha1("bruno");

// // echo $x."<br>";

// // echo md5($x);

// // echo "ok";
// // $mes = '03';      // Mês desejado, pode ser por ser obtido por POST, GET, etc.
// // $ano = date("Y"); // Ano atual
// // $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!
// // echo $ultimo_dia ."<br>";
// // echo $ano_mes = date("Y-m") . "<br>"; // Ano atual

// // $d = array();
// // for($i=1;$i < $ultimo_dia + 1 ;$i++){
// //     //echo $i;
// //     $ii = (string) $i;
// //     echo "data str ". $ii;
// //     echo "data : " . $ano_mes = date("Y-m-$ii") . "<br>"; // Ano atual
// //     // $ano_mes = $ano_mes. "-$i";   
// //     // print($ano_mes);
// //     $x = "("."$ano"."$mes"."$ii".")";
// //     $semanaNr = date("d - l", strtotime(date($x)+ "1 DAY"));
// //     $d[$i] = $semanaNr;
// //     echo "<br>". $semanaNr ."<br>";
// // }
// // print_r($d);
// // echo date('Y-m-d\TH:i:s')."</br>";


// // $data = new DateTime();
// // //print_r($data);
// // echo $data->format('Y-m-d\TH:i:s');
// // echo "<br>";



// // $x = date('Y-m-d\TH:i:s', strtotime('+5 days'));
// // echo $x;
// // $date = date('Y-m-d\TH:i:s');
// // echo $date;


// // if('2020-01-22T19:20:20' < $x){
// //     echo "ok";
// // } -->


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










	// //SERVIDOR MASTER UCCX
	// $servidor_master = 'UCCX_SNE0149';

	// //SERVIDOR SLAVE UCCX
	// $servidor_slave = 'UCCX_SNE0157';

	// //USUÁRIO
	// $usuario = 'uccxhruser';

	// //SENHA
	// $senha = '1qaz@WSX';

	// //NOME DO BANCO
	// $banco = 'db_cra';

	// //CONEXÃO ODBC MASTER
	// $conexao = odbc_connect($servidor_master,$usuario,$senha);
	// echo $conexao;
	
	// //TESTA SE O SERVIDOR MASTER ESTÁ ONLINE
	// if(!$conexao)
	// {
	// 	//CONEXÃO ODBC SLAVE
	// 	$conexao = odbc_connect($servidor_slave,$usuario,$senha);
	// 	if(!$conexao)
	// 	{
	// 		echo "Nenhuma das conexões com o banco está disponivel";
	// 		exit;
	// 	}
	// }

	// echo $conexao;














// $nome_banco = "db_cra_prod";
// $conexao_banco = new Conexao_Todos_os_Bancos($nome_banco);
// //$execucao = new FuncoesInformix();

// $query="-- REVISÃO 21/05/2019 
// -- MES ANTERIOR
// -- CHAMADAS RECEBIDAS PARA REALIZADAS CCD.originatorType = 1
//  SELECT 
// LTRIM(CCD.sessionid) AS 'id_ligacao', 
// CASE WHEN CCD.originatorType IN (2,3) AND CCD.contactdisposition = 2 THEN 'atendida' WHEN CCD.originatorType = 1 AND CCD.contactdisposition = 2 THEN 'chamada realizada' ELSE 'abandonada fila' END 'resultado', 
// CASE WHEN CCD.originatorType = 1 THEN '-' ELSE CCD.originatordn END AS 'origem', 
// AGE.extension AS 'destino',
// AGE.resourcename AS 'nome_agente', 
// AGE.resourceloginid AS 'login_agente', 
// CONVERT(VARCHAR(23),CCD.startdatetime,121) 'inicio_ligacao',
// CONVERT(VARCHAR(8), dbo.TIME2SEC(CONVERT(TIME(0),CRD.startdatetime - CCD.startdatetime)), 108) 'tempo_ura',   
// CONVERT(VARCHAR(23),CRD.startdatetime,121) 'incio_fila', 
// LTRIM(CRD.queuetime) AS 'tempo_fila', 
// CASE WHEN CCD.contactdisposition = 2 THEN CONVERT(VARCHAR(23), DATEADD(second, CRD.queuetime, CRD.startdatetime),121) ELSE NULL END 'inicio_atendimento', 
// LTRIM(dbo.TIME2SEC(CASE WHEN CCD.contactdisposition = 2 THEN CONVERT(VARCHAR(8), (CCD.enddatetime - DATEADD(s, CRD.queuetime, CCD.startdatetime)), 108) ELSE NULL END)) as 'tempo_atendimento', 
// CONVERT(VARCHAR(23),CCD.enddatetime,121) 'fim_ligacao', 
// LTRIM(CCD.connecttime) AS 'tempo_ligacao' 
// FROM contactcalldetail CCD 
// CROSS APPLY ( 
// 	SELECT	
// 	LTRIM(convert(date,dateadd(mm,-1,dateadd(dd,-day(getdate())+1,GETDATE())))) + ' 00:00:00' AS dtIni, LTRIM(convert(date,dateadd(dd,-day(getdate()),GETDATE()))) + ' 23:59:59' AS dtFim
// )Datas 
// INNER JOIN contactroutingdetail CRD ON (CRD.sessionid = CCD.sessionid AND CRD.startdatetime BETWEEN CONVERT(DATETIME, Datas.dtIni) AND CONVERT(DATETIME, Datas.dtFim) )
// INNER JOIN contactqueuedetail CQD ON (CQD.sessionid = CRD.sessionid AND CQD.sessionseqnum = CCD.sessionseqnum)
// INNER JOIN contactservicequeue CSQ ON (CSQ.recordid = CQD.targetid )
// LEFT JOIN (
// 	SELECT ACD1.sessionid, MAX(ACD1.enddatetime) edt
// 	FROM agentconnectiondetail ACD1
// 	-- O ESCOPO DO CROSS APPLY Datas NÃO FUNCIONA AQUI DENTRO
// 	WHERE ACD1.startdatetime BETWEEN LTRIM(convert(date,dateadd(mm,-1,dateadd(dd,-day(getdate())+1,GETDATE())))) + ' 00:00:00' AND LTRIM(convert(date,dateadd(dd,-day(getdate()),GETDATE()))) + ' 23:59:59'
// 	GROUP BY ACD1.sessionid
// ) ACDmax ON (CCD.sessionid = ACDmax.sessionid)
// LEFT JOIN agentconnectiondetail ACD ON (CCD.sessionid = ACDmax.sessionid AND ACD.enddatetime = ACDmax.edt)
// LEFT JOIN resource AGE ON (AGE.resourceid = ACD.resourceid)
// WHERE CCD.startdatetime  BETWEEN CONVERT(DATETIME, Datas.dtIni) AND CONVERT(DATETIME, Datas.dtFim)
// AND ( CCD.callednumber in('8024') OR CCD.origcallednumber in('8024') )
// AND CCD.sessionseqnum = 0
// AND CCD.applicationid = 8024
// AND CSQ.CSQname in( 'CSQ_SEGER_FORNECEDOR' , 'CSQ_SEGER_SEM_OPCAO' , 'CSQ_SEGER_SERVIDOR_ESTADUAL' , 'CSQ_SEGER_SERVIDOR_MUNICIPAL' ) 
// AND CCD.contactdisposition IN(1,2)
// AND CCD.originatorType IN (2,3)
// ";
// echo $query;
// $resultado = odbc_exec($conexao, $query) or die ("Erro ao pesquisar: ".odbc_error($conexao)." ~~ " .odbc_errormsg($conexao) );
// $retorno = $this->FetchArray($resultado);
// odbc_free_result($resultado);
// print_r($resultado)
















?> 