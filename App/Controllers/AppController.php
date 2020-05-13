<?php

namespace App\Controllers;
// date_default_timezone_set('America/Sao_Paulo'); 

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	public function apontamento(){
		session_start();


		
		$this->view->dataInvalida = isset($_GET['cadastroAponta'])?$_GET['cadastroAponta'] : ''  ;//esse codigo significa estado incial

		//echo "chegou no apontamento";
		$cliente = Container::getModel("cliente");
		$this->view->clientes = $cliente->getAll();
		//============================================
		$tipo_hora =Container::getModel('tipo_hora');
		$this->view->tipo_hora = $tipo_hora->getAll();
		//============================================
		$tipoAtividade =Container::getModel('TipoDeAtividade');
		$this->view->tipoAtividade = $tipoAtividade->getAll();
		//============================================
		$apontamento = Container::getModel('apontamento');
		$apontamento->__set('fkFuncionarioId',$_SESSION['id']);
		$this->view->apontamentosRecentes = $apontamento->recentes();

		$apontamento->__set('fkFuncionarioId',$_SESSION['id']);
		$this->view->apontamentosDoDia = $apontamento->getApontamentosDia();

		//============================================
		//print_r($this->view->apontamentosRecentes);

		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){
			$this->render('apontamento','layout2');
		}else{
			header("location: /?login=erro");
		}

	}

	public function baseCadastro(){
		//proteger essa rota
		if(isset($_GET['cliente_id'])){
			$contrato = Container::getModel('Contrato');
			$contrato->__set('fk_cliente_id',$_GET['cliente_id']);
			$array_contratos = $contrato->getPorCliente();
			echo json_encode($array_contratos);
		}

		if(isset($_GET['tipo_atividade_id'])){
			$atividade = Container::getModel('Atividade');
			$atividade->__set('fk_tipoAtividade',$_GET['tipo_atividade_id']);
			$array_atividades = $atividade->getPorTipo();
			echo json_encode($array_atividades);
		}
	}
	//fim baseCadastro


	public function criaApontamento(){
		//print_r($_POST);
		session_start();

		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){

			$data_comparacao = date('Y-m-d\TH:i:s', strtotime('-2 days'));
			$data_atual = date('Y-m-d\TH:i:s');
			//print_r($_POST);
			$dataInicio = $_POST['data_inicial'] ."T".$_POST['hora_inicial'].':00';
			$dataTermino = $_POST['data_final'] ."T".$_POST['hora_final'].':00';
			//se a data inicial for maior que a daata atual eu nao posso cadastrar
			if( ($dataInicio > $data_atual or $dataTermino > $data_atual ) or ($dataTermino <= $dataInicio)) {
				$this->view->dataInvalida = 0;//zero significa erro
				echo "data invalida";
				echo "data inicio: ". $dataInicio . "<br>" . "data termino: ".$dataTermino . "<br>" ."data atual: ". $data_atual;
				header('Location:/apontamento?cadastroAponta=erroCadastro');//
			}else{
				//verificar data negativaaa
				echo "data negativa";
				echo "data inicio: ". $dataInicio . "<br>" . "data termino: ".$dataTermino . "<br>" ."data atual: ". $data_atual;
				
				// IF DATA NEGATIVA EU CRIO A VIEW DE ERROd
				if($dataTermino < $dataInicio ){
					$this->view->dataInvalida = 0;//zero significa erro
					header('Location:/apontamento?cadastroAponta=erroCadastro');//
				}else{
					//-------------------------
					//echo "ok";
					//echo $dataInicio;
					// echo "tudo certo";
					// echo "data inicio: ". $dataInicio . "<br>" . "data termino: ".$dataTermino . "<br>" ."data atual: ". $data_atual;
					if(!isset($_POST['numero_chamado']) or empty($_POST['numero_chamado'])){
						$numero_chamado = "";
					}else{
						$numero_chamado = $_POST['numero_chamado'];
					}

					if(!isset($_POST['descricao']) or empty($_POST['descricao'])){
						$descricao = "";
					}else{
						$descricao = $_POST['descricao'];
					}



					$apontamento = Container::getModel('Apontamento');
					$apontamento->__set('dataInicial',strval($dataInicio));
					$apontamento->__set('dataFinal',strval($dataTermino));
					$apontamento->__set('numeroChamado',$numero_chamado);
					$apontamento->__set('fkAtividadeId',$_POST['atividade']);
					$apontamento->__set('fkContratoId',strval($_POST['contrato']));
					$apontamento->__set('fkFuncionarioId',$_SESSION['id']);
					$apontamento->__set('fkTipoHoraId',$_POST['tipo_hora']);
					$apontamento->__set('descricao',$descricao);

					//data inicial menor que 2 dias atrás o staus vira pendente
					//1 - pendentes
					//2 - VALIDOS 
					if ($_POST['data_inicial'] < $data_comparacao){
						$apontamento->__set('fkStatusId',1);

					}else{
						$apontamento->__set('fkStatusId',2);
					}
					$existe = $apontamento->verificaExistencia();
					print_r($existe);
					if(!isset($existe)){
						echo "ja existe";
						//decidir oque fazer
						header('Location:/apontamento?cadastroAponta=erroCadastro');
						//fazer uma view pra receber um valor caso o usur ja exista
					}else{
						$apontamento->salvar();
						// echo '<pre>';
						// print_r($apontamento);
						// echo '</pre>';
						//fazer um header com mensagem de acertos
						header('Location:/apontamento');
					}

			}//fim verifica data negativa

			}//fim verifica data
		}//fim verifica sessão

	}//fim metodo



	public function criaApontamentoTpAtivi(){
		echo "cuk";
		print_r($_POST);

	}

	public function alterarApotamento(){
		//echo "chegamos ate aqui";
		//print_r($_POST);
		session_start();
		try{
			//verificar data negativaaa 
			//print_r($_POST);
			$data_atual = date('Y-m-d\TH:i:s');
			$data_comparacao = date('Y-m-d\TH:i:s', strtotime('-2 days'));
			//verificando se a hora inicio esta no formato aceito pelo convert (função sql server)
			if(strlen($_POST['edita_time_ini']) < 6){
				$_POST['edita_time_ini'] = $_POST['edita_time_ini'].":00.000";
				//echo $_POST['edita_time_ini'];
			}
			//verificando se a hora fim esta no formato aceito pelo convert (função sql server)
			if (strlen($_POST['edita_time_fim']) < 6){
				$_POST['edita_time_fim'] = $_POST['edita_time_fim'].":00.000";
				//echo $_POST['edita_time_fim'];
			}
			//------------------------------------------------------


			$dataInicio = $_POST['edita_dt_ini'] ."T".$_POST['edita_time_ini'];
			$dataTermino = $_POST['edita_dt_fim'] ."T".$_POST['edita_time_fim'];

			if (empty($_POST['edita_descricao']) ){
				echo "campo descrição vazio";
				exit();
			}

			// if (empty($_POST['edita_num_chamado']) or $_POST['edita_num_chamado']=="" ){
			// 	echo "campo numero do chamado vazio";
			// 	exit();
			// }

			if(!isset($_POST['edita_num_chamado']) or empty($_POST['edita_num_chamado'])){
				$numero_chamado = "";
			}else{
				$numero_chamado = $_POST['edita_num_chamado'];
			}


			// $date_dataInicio = date($dataInicio);
			// $date_dataTermino = date($dataTermino);
			//data precisar respeitar as regras de negocios
			if(($dataTermino == $dataInicio) or ($dataTermino < $dataInicio) or ($dataInicio > $data_atual ) or ($dataTermino > $data_atual) ){
				//if data inicio < (data atual - 2 days) == erro
				//$this->view->dataInvalida = 0;//zero significa erro
				// header('Location:/apontamento?cadastroAponta=erroCadastro');//
				echo "erro data invalida";
			}else{

				// nao pode ser anterior a dois dias
				//if 
					//se for anterior aos dois dias eu seto o id como pendente
					//1 - PENDENTES
					//2 - VALIDO
				if ($dataInicio < $data_comparacao ){
					$status_apontamento = 1;
					//1 == pendente
				}else{
					$status_apontamento = 2;
					//2 == valido
				}
				//não pode ser maior 
				$apontamento = Container::getModel('Apontamento');
				$apontamento->__set('dataInicial',$dataInicio);
				$apontamento->__set('dataFinal',$dataTermino);
				$apontamento->__set('numeroChamado',$numero_chamado);
				$apontamento->__set('fkAtividadeId',$_POST['edita_atividade']);
				$apontamento->__set('fkContratoId',strval($_POST['edita_contrato']));
				$apontamento->__set('fkFuncionarioId',$_SESSION['id']);
				$apontamento->__set('fkTipoHoraId',$_POST['edita_tp_hr']);
				$apontamento->__set('id',$_POST['id_linha_edita']);
				$apontamento->__set('fkStatusId',$status_apontamento);
				$apontamento->__set('descricao',$_POST['edita_descricao']);


				//print_r($apontamento);
				$verifica_update = $apontamento->update();
				if(!$verifica_update){
					echo "errado";
				}
				else{
					echo 1;

				}
				//print_r($verifica_update);
				//if isset deu certo
				//else deu errado
			}

			} catch(Exception $e){
	
				echo "erro";
			}
		
		//echo json_encode(['success'=> 'deu tudo certo' ]);
	}



	public function excluirApotamento(){
		//print_r( $_POST);
		try{
		$apontamento = Container::getModel('Apontamento');
		$apontamento->__set('id',$_POST['id_linha_edita']);
		$apontamento->excluir();
		echo "sucesso";
		} catch(Exception $e){

			echo "erro";
		}

	}


	public function historico(){
		//print_r($_POST);
		session_start();
		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){

			$aponta = Container::getModel('Apontamento');
			$aponta->__set('fkFuncionarioId',$_SESSION['id']);
			
			if(isset($_POST['dataInicio'])){
				$aponta->__set('dataInicial',strval($_POST['dataInicio'].'T00:00:00'));
				$aponta->__set('dataFinal',strval($_POST['dataFim'].'T23:59:59'));
				//print_r($_POST['dataInicio']);
				$this->view->todosApontamentos = $aponta->getPorIntervalo();

			}else{
				$this->view->todosApontamentos = $aponta->getAll();
				//print_r($this->view->todosApontamentos);
			}

			$this->render('historico','layout2');


		}else{
			header("location: /?login=erro");

		}

	}



	public function pendentes(){

		session_start();
		//verifica ismanager
		//se for pode continuar 
		//senao acaba aqui
		//verificar se é um manager
		
		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){
			$func = Container::getModel('funcionario');
			$aponta = Container::getModel('apontamento');
			$func->__set('nome',$_SESSION['nome'] );// session manager == true??? então faço tudo
	
			$manager = $func->isManager();
			//print_r($manager);	 
			// if($manager['manager'] == 0){
			// 	//echo "não é manager";
			// 	//RENDER VOCE NAO TEM ACESSO
			// 	//HEADER LOCATION
			// 	header("location: /apontamento");	
			// }
			$this->view->meusFuncionario = $func->GetFuncByManager();

			if(!$_POST){
				$this->view->meusPendentes = $func->getPendentesManager(); 
				
			}else{
				//print_r($_POST);
				$func->__set('fk_id_supervisionado',$_POST['funcionario']);
				$this->view->meusPendentes = $func->getPendentesByFunc(); 
			}	


			$this->render('pendentes','layout2');
		}else{
			header("location: /?login=erro");
		}


	}

	public function Dadospendentes(){
		session_start();
		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){
			$func = Container::getModel('funcionario');
			$aponta = Container::getModel('apontamento');
			$func->__set('nome',$_SESSION['nome'] );// session manager == true??? então faço tudo
			$manager = $func->isManager();
			//print_r($manager);	 
			// if($manager['manager'] == 0){
			// 	//echo "não é manager";
			// 	//RENDER VOCE NAO TEM ACESSO
			// 	//HEADER LOCATION
			// 	header("location: /apontamento");	
			// }
			// $this->view->meusFuncionario = $func->GetFuncByManager();
			if(!$_POST['funcionario']){
				$this->view->meusPendentes = $func->getPendentesManager(); 
			}else{
				// print_r($_POST);
				$func->__set('fk_id_supervisionado',$_POST['funcionario']);
				$this->view->meusPendentes = $func->getPendentesByFunc(); 
			}	
			 echo json_encode($this->view->meusPendentes);
			// echo json_encode($_POST);
			//echo "ok";

			// $this->render('pendentes','layout2');
		}
	}

	public function concluido(){
		session_start();

		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){

			$func = Container::getModel('funcionario');
			$func->__set('nome',$_SESSION['nome'] );
			$func->__set('id',$_SESSION['id'] );
			
			require_once('../public/testes.php');
			$this->view->dataRange = $dateRange;
			$this->view->fds = $finaisdesemana;

			$apontamento = Container::getModel('Apontamento');
			$apontamento->__set('fkFuncionarioId',$_SESSION['id']);

			//print_r($datasql);
			$str = "";
			for($i=0; $i <= count($datasql) -1 ;$i++){
				if($i != (count($datasql) -1)){
					$str .= '['. strval($datasql[$i]). ']'.','  ;

				}else{
					$str .= '['. strval($datasql[$i]). ']';
				}
			}
			//echo $str;

			$manager = $func->isManager();
			//print_r($manager);	 
			if($manager['manager'] == 0){
				$this->view->resultadoMensal = $apontamento->getMensalFuncionario($str);
			}else{
				$this->view->resultadoMensal = $apontamento->getMensal($str,$_SESSION['nome']);
			}

				
			
			$this->render('concluido','layout3');
		}else{
			header("location: /?login=erro");
		}



	}


	public function editaveis(){
		session_start();
		$this->view->postEdita = false;
		if($_SESSION['id'] !='' && $_SESSION['nome'] !=''){
			
			$func = Container::getModel('funcionario');
			$func->__set('nome',$_SESSION['nome'] );
			$manager = $func->isManager();
			//print_r($manager);	 
			if($manager['manager'] == 0){
				header("location: /apontamento");	
			}
			
			$this->view->postEdita = false;
			if($_POST['chamado_editavel']){
				//print_r($_POST);
				$apontamento = Container::getModel('Apontamento');
				$apontamento->__set('numeroChamado',$_POST['chamado_editavel']);
				$this->view->editaPorChamado = $apontamento->getPorNumeroChamado('teste');
				//print_r($this->view->editaPorChamado);
				$this->view->postEdita = true;
		
			}

			$this->render('editaveis','layout2');

		}else{
			header("location: /?login=erro");
		}





	}



	public function aceitarPendentes(){
		session_start();
		if($_SESSION['id'] =='' && $_SESSION['nome'] ==''){
			header("location: /?login=erro");
		}

		if($_POST){
			//print_r($_POST);
			if(array_key_exists("id_hist",$_POST)){
				$ID =$_POST['id_hist'];
			}else{
				$ID =$_POST['id_hist_bt'];
			}
			$apontamento = Container::getModel('Apontamento');
			$apontamento->__set('id',$ID);
			$verifica = $apontamento->aceitaPendente();
			if(!$verifica){
				if(array_key_exists("id_hist",$_POST)){
					header("location: /pendentes");
					}
				echo "erro";
				//vouta para pendentes
				//
			}else{
				if(array_key_exists("id_hist",$_POST)){
				header("location: /pendentes");
				}

				//print_r($verifica);
				echo "correto";

			}

		}

	}



	public function editaveisPendentes(){
		if($_POST){
			//print_r($_POST);
			if(array_key_exists("id_edt",$_POST)){
				$ID =$_POST['id_edt'];
			}else{
				$ID =$_POST['id_hist'];
			}
			$apontamento = Container::getModel('Apontamento');
			$apontamento->__set('id',$ID);
			$verifica = $apontamento->tornarEditavel();
			if($verifica){
				if(array_key_exists("id_edt",$_POST)){
					// header("location: /editaveis");
					echo "correto";
				}else{
					echo 1;
				}
				//echo 1;
				//vouta para pendentes
				//
			}
		}

	}





}

?>