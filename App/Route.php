<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['login'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'login'
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);


		$routes['apontamento'] = array(
			'route' => '/apontamento',
			'controller' => 'AppController',
			'action' => 'apontamento'
		);

		$routes['baseCadastro'] = array(
			'route' => '/apontamento/baseCadastro',
			'controller' => 'AppController',
			'action' => 'baseCadastro'
		);

		$routes['criaApontamento'] = array(
			'route' => '/apontamento/criaApontamento',
			'controller' => 'AppController',
			'action' => 'criaApontamento'
		);

		$routes['criaApontamentoTpAtivi'] = array(
			'route' => '/apontamento/criaApontamentoTpAtivi',
			'controller' => 'AppController',
			'action' => 'criaApontamentoTpAtivi'
		);

		$routes['alterarApotamento'] = array(
			'route' => '/apontamento/alterarApotamento',
			'controller' => 'AppController',
			'action' => 'alterarApotamento'
		);

		$routes['excluirApotamento'] = array(
			'route' => '/apontamento/excluirApotamento',
			'controller' => 'AppController',
			'action' => 'excluirApotamento'
		);

		$routes['historico'] = array(
			'route' => '/historico',
			'controller' => 'AppController',
			'action' => 'historico'
		);

		$routes['pendentes'] = array(
			'route' => '/pendentes',
			'controller' => 'AppController',
			'action' => 'pendentes'
		);

		$routes['concluido'] = array(
			'route' => '/concluido',
			'controller' => 'AppController',
			'action' => 'concluido'
		);
		
		$routes['editaveis'] = array(
			'route' => '/editaveis',
			'controller' => 'AppController',
			'action' => 'editaveis'
		);
		$routes['editaveisPendentes'] = array(
			'route' => '/editaveis/Pendentes',
			'controller' => 'AppController',
			'action' => 'editaveisPendentes'
		);

		$routes['Dadospendentes'] = array(
			'route' => '/pendentes/Dadospendentes',
			'controller' => 'AppController',
			'action' => 'Dadospendentes'
		);

		$routes['aceitarPendentes'] = array(
			'route' => '/Pendentes/Aceitar',
			'controller' => 'AppController',
			'action' => 'aceitarPendentes'
		);

		
		




		$this->setRoutes($routes);
	}

}

?>