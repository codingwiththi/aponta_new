<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	public function apontamento(){
		session_start();

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
			//echo "ok";
			$apontamento = Container::getModel('Apontamento');
			$apontamento->__set('dataInicial',$_POST['data_inicial']);
			$apontamento->__set('dataFinal',$_POST['data_final']);
			$apontamento->__set('numeroChamado',$_POST['numero_chamado']);
			$apontamento->__set('fkAtividadeId',$_POST['atividade']);
			$apontamento->__set('fkContratoId',$_POST['contrato']);
			$apontamento->__set('fkFuncionarioId',$_SESSION['id']);
			$apontamento->__set('fkTipoHoraId',$_POST['tipo_hora']);
			

			$existe = $apontamento->verificaExistencia();
			print_r($existe);
			if(!isset($existe)){
				echo "ja existe";
				//decidir oque fazer
				//fazer uma view pra receber um valor caso o usur ja exista

			}else{
				$apontamento->salvar();
				// echo '<pre>';
				// print_r($apontamento);
				// echo '</pre>';
				//fazer um header com mensagem de acertos
				header('Location:/apontamento');
			}
		}

	}

	public function alterarApotamento(){
		//echo "chegamos ate aqui";
		//print_r($_POST);
		try{
			$apontamento = Container::getModel('Apontamento');

			$apontamento->update();
			echo "sucesso";
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
				$aponta->__set('dataInicial',$_POST['dataInicio']);
				$aponta->__set('dataFinal',$_POST['dataFim']);
				//print_r($_POST['dataInicio']);
				$this->view->todosApontamentos = $aponta->getPorIntervalo();

			}else{
				$this->view->todosApontamentos = $aponta->getAll();
				//print_r($this->view->todosApontamentos);
			}

			$this->render('historico','layout2');


		}

	}






}

?>