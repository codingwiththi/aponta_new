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

		
		$this->setRoutes($routes);
	}

}

?>