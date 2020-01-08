<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function login() {
		$this->view->login = isset($_GET['login']) ? $_GET['login']:'';
		$this->render('login');
	}

}


?>